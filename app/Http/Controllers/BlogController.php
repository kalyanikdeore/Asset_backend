<?php

namespace App\Http\Controllers\api;

use App\Models\BlogPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = BlogPost::where('is_published', true)
            ->latest('published_date')
            ->paginate($request->input('per_page', 4));

        return response()->json($posts);
    }

    public function recent()
    {
        $posts = BlogPost::where('is_published', true)
            ->latest('published_date')
            ->limit(3)
            ->get(['id', 'title', 'slug', 'published_date', 'image_url']);

        return response()->json($posts);
    }

    public function byCategory($category = null)
    {
        $query = BlogPost::where('is_published', true)
            ->latest('published_date');
        
        if ($category) {
            $query->where('category', $category);
        }
        
        return response()->json($query->paginate(4));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
      
        return response()->json([
            'post' => $post,
            'related' => BlogPost::where('category', $post->category)
                ->where('id', '!=', $post->id)
                ->where('is_published', true)
                ->latest('published_date')
                ->limit(3)
                ->get(['id', 'title', 'slug', 'published_date', 'image_url'])
        ]);
    }
}