<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\AlamatPengiriman;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user()->id)
                            ->with('order.cart.detail.produk.toko')
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('transaksi.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $itemuser = $request->user();
        $itemcart = Cart::where('status_cart', 'cart')
                        ->where('user_id', $itemuser->id)
                        ->first();
        if ($itemcart) {
            $itemalamatpengiriman = AlamatPengiriman::where('user_id', $itemuser->id)
                                                    ->where('status', 'utama')
                                                    ->first();
            
            // Jika user memilih "Ambil di tempat", alamat pengiriman utama tidak wajib ada
            $opsi_pengiriman = $request->input('opsi_pengiriman', 'Diantar');
            
            if ($itemalamatpengiriman || $opsi_pengiriman === 'Ambil di tempat') {
                $inputanorder['cart_id'] = $itemcart->id;
                
                if ($opsi_pengiriman === 'Ambil di tempat') {
                    $inputanorder['nama_penerima'] = $itemuser->name;
                    $inputanorder['no_tlp'] = $request->input('Telp', $itemalamatpengiriman?->no_tlp ?? '-');
                    
                    $alamat_detail = 'Ambil di Toko';
                    if ($request->filled('koordinat')) {
                        $alamat_detail .= ' | Koordinat: ' . $request->koordinat;
                    }
                    $alamat_detail .= ' | Pengiriman: Ambil di tempat';
                    $alamat_detail .= ' | Pembayaran: ' . $request->input('metode_pembayaran', 'Cash');
                    
                    $inputanorder['alamat'] = $alamat_detail;
                    $inputanorder['provinsi'] = '-';
                    $inputanorder['kota'] = '-';
                    $inputanorder['kecamatan'] = '-';
                    $inputanorder['kelurahan'] = '-';
                    $inputanorder['kodepos'] = '-';
                } else {
                    $inputanorder['nama_penerima'] = $itemalamatpengiriman->nama_penerima;
                    $inputanorder['no_tlp'] = $itemalamatpengiriman->no_tlp;
                    
                    $alamat_detail = $itemalamatpengiriman->alamat;
                    if ($request->filled('koordinat')) {
                        $alamat_detail .= ' | Koordinat: ' . $request->koordinat;
                    }
                    $alamat_detail .= ' | Pengiriman: Diantar';
                    $alamat_detail .= ' | Pembayaran: ' . $request->input('metode_pembayaran', 'Cash');
                    
                    $inputanorder['alamat'] = $alamat_detail;
                    $inputanorder['provinsi'] = $itemalamatpengiriman->provinsi;
                    $inputanorder['kota'] = $itemalamatpengiriman->kota;
                    $inputanorder['kecamatan'] = $itemalamatpengiriman->kecamatan;
                    $inputanorder['kelurahan'] = $itemalamatpengiriman->kelurahan;
                    $inputanorder['kodepos'] = $itemalamatpengiriman->kodepos;
                }
                
                $itemorder = Order::create($inputanorder); // simpan order
                
                // Create Transaction
                $transaction = Transaction::create([
                    'user_id' => $itemuser->id,
                    'order_id' => $itemorder->id,
                    'status' => 'Pending',
                    'total_price' => $itemcart->total,
                ]);

                // update status cart
                $itemcart->update(['status_cart' => 'checkout']);
                
                return redirect()->route('transaksi.nota', $transaction->id)->with('success', 'Order berhasil disimpan');
            } else {
                return back()->with('error', 'Alamat pengiriman belum diisi');
            }
        } else {
            return abort('404');
        }
    }

    /**
     * Display the success receipt invoice (nota) for a transaction.
     */
    public function nota($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())
                            ->with('order.cart.detail.produk')
                            ->findOrFail($id);
        return view('transaksi.nota', compact('transaction'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function complete(Request $request, Transaction $transaction) {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }
        $transaction->update(['status' => 'Completed']);
        return back()->with('success', 'Pesanan telah diselesaikan.');
    }

    public function cancel(Request $request, Transaction $transaction) {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403);
        }
        
        if ($transaction->status !== 'Pending') {
            return back()->with('error', 'Hanya pesanan yang masih pending yang dapat dibatalkan.');
        }

        $transaction->update(['status' => 'Cancelled']);
        return back()->with('success', 'Pesanan Anda berhasil dibatalkan.');
    }
}
