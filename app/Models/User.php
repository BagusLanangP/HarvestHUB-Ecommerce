<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\TenagaKerja;
use App\Models\Konsultan;
use App\Models\Toko;

class User extends Authenticatable
{
   
    use HasApiTokens, HasFactory, Notifiable,  Sluggable ;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

   
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function tenaga_kerja()
    {
        return $this->hasOne(TenagaKerja::class);
    }

    public function konsultan()
    {
        return $this->hasOne(Konsultan::class);
    }

    public function toko()
    {
        return $this->hasOne(Toko::class);
    }



}
