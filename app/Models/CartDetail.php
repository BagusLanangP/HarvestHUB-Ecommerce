<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function cart() {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function produk() {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    public function updatedetail($itemdetail, $qty, $harga){
        $this->qty = $itemdetail->qty + $qty;
        $this->subtotal = $itemdetail->subtotal + ($qty * $harga);
        $this->save();
    }
}

