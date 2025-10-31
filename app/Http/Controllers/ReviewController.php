<?php
namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
  
    {
        $reviews = Review::where('is_visible', true)
                         ->orderBy('created_at', 'desc')
                         ->get(['customer_name', 'review', 'video_url', 'rating']);

        return response()->json($reviews);
    }
} 