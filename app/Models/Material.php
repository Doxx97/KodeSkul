<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    // Tambahkan video_url dan interactive_quiz ke dalam array fillable
    protected $fillable = [
        'title', 
        'category', 
        'description', 
        'content', 
        'video_url', 
        'interactive_quiz',
        'post_test'
    ];

    protected $casts = [
        'interactive_quiz' => 'array',
    ];
}
