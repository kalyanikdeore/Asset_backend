<?php
// app/Models/GalleryCategory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    protected $fillable = ['name', 'slug', 'is_active', 'sort_order'];

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order');
    }

    public function activeImages(): HasMany
    {
        return $this->hasMany(GalleryImage::class)
                    ->where('is_active', true)
                    ->orderBy('sort_order');
    }
}