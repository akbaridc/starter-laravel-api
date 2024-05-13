<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Posts extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'excerpt',
        'description',
    ];
}
