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
                            ->with('order.cart.detail.produk')
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
            if ($itemalamatpengiriman) {
                // buat variabel inputan order
                $inputanorder['cart_id'] = $itemcart->id;
                $inputanorder['nama_penerima'] = $itemalamatpengiriman->nama_penerima;
                $inputanorder['no_tlp'] = $itemalamatpengiriman->no_tlp;
                $inputanorder['alamat'] = $itemalamatpengiriman->alamat;
                $inputanorder['provinsi'] = $itemalamatpengiriman->provinsi;
                $inputanorder['kota'] = $itemalamatpengiriman->kota;
                $inputanorder['kecamatan'] = $itemalamatpengiriman->kecamatan;
                $inputanorder['kelurahan'] = $itemalamatpengiriman->kelurahan;
                $inputanorder['kodepos'] = $itemalamatpengiriman->kodepos;
                $itemorder = Order::create($inputanorder);//simpan order
                
                // Create Transaction
                Transaction::create([
                    'user_id' => $itemuser->id,
                    'order_id' => $itemorder->id,
                    'status' => 'Pending',
                    'total_price' => $itemcart->total,
                ]);

                // update status cart
                $itemcart->update(['status_cart' => 'checkout']);
                return redirect('/transaksi')->with('success', 'Order berhasil disimpan');
            } else {
                return back()->with('error', 'Alamat pengiriman belum diisi');
            }
        } else {
            return abort('404');//kalo ternyata ga ada shopping cart, maka akan menampilkan error halaman tidak ditemukan
        }
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
}
