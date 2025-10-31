<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'category', 
        'image_url', 'published_date', 'is_published',
        'author_name', 'author_avatar', 'author_role',
        'related_products', 'views'
    ];

    protected $casts = [
        'published_date' => 'datetime',
        'is_published' => 'boolean',
        'related_products' => 'array'
    ];

    protected $attributes = [
        'is_published' => true,
        // 'views' => 0
    ];

   
    // Return relative paths for URLs
    public function getImageUrlAttribute($value)
    {
        return $value ? $value : null;
    }

    public function getAuthorAvatarAttribute($value)
    {
        return $value ? $value : null;
    }
 
}