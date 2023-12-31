<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function produk () {
        return $this->belongsTo(Product::class, 'produk_id');
    }
    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }
}
