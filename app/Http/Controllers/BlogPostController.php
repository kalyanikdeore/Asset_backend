<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a single blog post by slug
     */
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Load related products if needed
        $post->load('relatedProducts');

        // Format the response
        return response()->json([
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'content' => $post->content,
                'category' => $post->category,
                'image_url' => $post->image_url,
                'published_date' => $post->published_date,
                'author_name' => $post->author_name,
                'author_avatar' => $post->author_avatar_url,
                'author_role' => $post->author_role,
                'related_products' => $post->getDisplayableRelatedProducts(),
                'meta' => [
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                ]
            ]
        ]);
    }
}