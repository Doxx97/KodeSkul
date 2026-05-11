<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_name',
        'certificate_code',
        'issued_at'
    ];

    // Opsional: Jika kamu ingin issued_at otomatis jadi objek Carbon/Tanggal
    protected $casts = [
        'issued_at' => 'datetime',
    ];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}