<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requested_role_id',
        'identity_id',
        'whatsapp',
        'email',
        'gender',
        'birth_date',
        'domicile',
        'metadata',
        'reason',
        'document_path',
        'status',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'requested_role_id');
    }
}
