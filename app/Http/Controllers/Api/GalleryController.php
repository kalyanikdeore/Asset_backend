<?php
// app/Http/Controllers/API/GalleryController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    public function getCategories(): JsonResponse
    {
        $categories = GalleryCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug']);

        return response()->json($categories);
    }

    public function getImages(): JsonResponse
    {
        $images = GalleryImage::with('category:id,name')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'gallery_category_id', 'title', 'image_path']);

        $images->each(function ($image) {
            $image->image_url = $image->image_url;
        });

        return response()->json($images);
    }

    public function getImagesByCategory($categorySlug): JsonResponse
    {
        $category = GalleryCategory::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $images = $category->activeImages()
            ->get(['id', 'title', 'image_path']);

        $images->each(function ($image) {
            $image->image_url = $image->image_url;
        });

        return response()->json([
            'category' => $category->name,
            'images' => $images
        ]);
    }
}