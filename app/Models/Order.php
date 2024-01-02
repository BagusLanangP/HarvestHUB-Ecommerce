<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    protected $table = 'order';
    use HasFactory;
    protected $fillable = [
        'cart_id',
        'nama_penerima',
        'no_tlp',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'kodepos',
    ];

    public function cart() {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
