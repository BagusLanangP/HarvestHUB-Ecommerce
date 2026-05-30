<?php

namespace App\Models;
use App\Models\User;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->hasMany(Product::class);
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-shop.png');
    }

    public function getOverallRatingAttribute()
    {
        $average = \App\Models\Review::whereIn('product_id', $this->produk()->pluck('id'))->avg('rating');
        return $average ? round($average, 1) : 0;
    }

    public function getTotalProductsAttribute()
    {
        return $this->produk()->count();
    }

    public function getBestSellingProductAttribute()
    {
        return $this->produk()
            ->select('products.*')
            ->selectRaw('COALESCE(SUM(cart_details.qty), 0) as total_sold')
            ->join('cart_details', 'products.id', '=', 'cart_details.produk_id')
            ->join('carts', 'cart_details.cart_id', '=', 'carts.id')
            ->join('orders', 'carts.id', '=', 'orders.cart_id')
            ->join('transactions', 'orders.id', '=', 'transactions.order_id')
            ->where('transactions.status', 'Completed')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->first();
    }
}

