<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\ProductCategory;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function kategori()
    {
        return $this->belongsTo(ProductCategory::class, 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}
