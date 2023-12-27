<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\User;
use App\Models\CartDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(CartDetail::class, 'cart_id');
    }

    public function updatetotal($itemcart, $subtotal)
    {
        $this->subtotal = $itemcart->subtotal + $subtotal;
        $this->total =  $itemcart->total + $subtotal;
        $this->save();
    }
}
