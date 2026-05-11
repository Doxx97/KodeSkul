<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // Izinkan kolom-kolom ini diisi manual
    protected $fillable = ['title', 'slug', 'category', 'excerpt', 'content', 'file_materi'];
}