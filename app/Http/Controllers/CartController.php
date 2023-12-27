<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemuser = Auth::user();
        $itemcart = Cart::where('user_id', $itemuser->id)->where('status_cart', 'cart')->first();

        if($itemcart){
            $data = array('itemcart' => $itemcart);
            return view('cart.index', $data);
        }

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        
    }

    public function update(Request $request, Cart $cart)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        
    }

    public function checkout(Request $request){
        $itemuser = $request->user();
        $itemcart = Cart::where('user_id', $itemuser->id)->where('status_cart', 'cart')->first();

        // $itemalamatpengiriman = AlamatPengiriman::where('user_id', $itemuser->id)
        //                                         ->where('status', 'utama')
        //                                         ->first();
        if($itemcart){
            $data = array('itemcart' => $itemcart,
            'itemalamatpengiriman' => $itemalamatpengiriman);

            // return view
        }else{
            
        }
    }

    public function kosongkan($id){
        $itemcart = Cart::findOrFail($id);
        //menghapus semau detail cart dari cart yang berdasarkan id
        $itemcart->detail()->delete();
        $itemcart->updatetotal($itemcart, '-'. $itemcart->subtotal);
        // return back



    }
}
