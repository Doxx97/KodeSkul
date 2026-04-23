<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 👇 UPDATE DI SINI: Tambahkan withPivot agar kolom score ikut terbaca/tersimpan 👇
    public function completedMaterials()
    {
        return $this->belongsToMany(Material::class, 'material_progresses')
                    ->withPivot('is_completed', 'score')
                    ->withTimestamps();
    }
}