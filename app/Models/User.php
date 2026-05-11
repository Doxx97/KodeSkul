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
        // 'material_user' adalah nama tabel pivot kamu
        return $this->belongsToMany(Material::class, 'material_user')
                    ->withPivot('is_completed', 'score')
                    ->withTimestamps();
    }
    public function certificates()
    {
        return $this->hasMany(\App\Models\Certificate::class); // Pakai \App\Models langsung
    }
}