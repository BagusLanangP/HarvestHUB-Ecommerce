<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartDetail;
use Illuminate\Http\Request;

class CartDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'produk_id' => 'required',
        ]);

        $itemuser = $request->user();

        

        //request->produk_id nya menyesuiakan lagi
        $itemproduk = Product::findOrFail($request->produk_id);

        $cart = Cart::where('user_id', $itemuser->id)->where('status_cart', 'cart')->first();


        //if else berfungsi untuk mengecek apakah sudah cart(nota) untuk user
        if($cart){
            $itemcart = $cart;
        }else{

            $no_invoice = Cart::where('user_id', $itemuser->id)->count();

            $inputancart['user_id'] = $itemuser->id;
            //Membuat no invoice 
            //str_pad yang digunakan untuk memastikan bahwa nomor invoice selalu memiliki panjang sebanyak 3 karakter
            //jika no_invoice nya kurang dari 3 maka dia akan memberikan value 0
            $inputancart['no_invoice'] = 'HHUB'.str_pad(($no_invoice + 1), '3', '0', STR_PAD_LEFT);
            $inputancart['status_cart'] = 'cart';
            $inputancart['status_pembayaran'] = 'belum';
            $inputancart['status_pengiriman'] = 'belum';
            //membuat cart lewat create
            $itemcart = Cart::create($inputancart);
        }
        //$cartdetail -> mengecek apakah ada produk yang sama dalam suatu cart
        $cekdetail = CartDetail::where('cart_id', $itemcart->id)->where('produk_id', $itemproduk->id)->first();
        //inisialisai value cart detail
        $qty = 1;
        $harga = $itemproduk->harga;
        $subtotal = ($qty * $harga);

        if($cekdetail){
            //jika ada produk yang sama maka dia akan melakukan update

            //mengupdate dengan fungsi updatedetail pada modelnya CartDetail
            $cekdetail->updatedetail($cekdetail, $qty, $harga);

            //mengupdate nilai subtotal dari tabel kita
            $cekdetail->cart->updatetotal($cekdetail->cart, $subtotal);
        }else{
            $inputan = $request->all();
            $inputan['cart_id'] = $itemcart->id;
            $inputan['produk_id'] = $itemproduk->id;
            $inputan['qty'] = $qty;
            $inputan['harga'] = $harga;
            $inputan['subtotal'] = ($harga * $qty);
            $itemdetail = CartDetail::create($inputan);
            $itemdetail->cart->updatetotal($itemdetail->cart, $subtotal);            
        }
        //disini pindah ke halaman redirect
    }

    /**
     * Display the specified resource.
     */
    public function show(CartDetail $cartDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartDetail $cartDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $itemdetail = CartDetail::findOrFail($id);
        $param = $request->param;
        
        if ($param == 'tambah') {
            // update detail cart
            $qty = 1;
            $itemdetail->updatedetail($itemdetail, $qty, $itemdetail->harga, $itemdetail->diskon);
            // update total cart
            $itemdetail->cart->updatetotal($itemdetail->cart, ($itemdetail->harga - $itemdetail->diskon));
            return back()->with('success', 'Item berhasil diupdate');
        }
        if ($param == 'kurang') {
            // update detail cart
            $qty = 1;
            $itemdetail->updatedetail($itemdetail, '-'.$qty, $itemdetail->harga, $itemdetail->diskon);
            // update total cart
            $itemdetail->cart->updatetotal($itemdetail->cart, '-'.($itemdetail->harga - $itemdetail->diskon));
            return back()->with('success', 'Item berhasil diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartDetail $cartDetail)
    {
        //
    }
}
