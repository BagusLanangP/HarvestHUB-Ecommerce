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


    public function scopeFilter($query, array $filters)
    {
      $query->when($filters['cari'] ?? false, function($query, $cari){
        return $query->where('name', 'like', '%'. $cari.'%');
        });
    }

    public function getImageUrlAttribute()
    {
        if ($this->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }
        
        // Fallback default image
        return asset('img/default-product.png'); 
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute() {
        if ($this->reviews()->count() == 0) return 0;
        return round($this->reviews()->avg('rating'), 1);
    }
}
