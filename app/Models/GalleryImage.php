<?php
// app/Models/GalleryImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryImage extends Model
{
    protected $fillable = [
        'gallery_category_id', 
        'title', 
        'image_path', 
        'sort_order', 
        'is_active'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }

    // Accessor for full image URL
    public function getImageUrlAttribute(): string
    {
        return asset('uploads/gallery/' . $this->image_path);
    }
}