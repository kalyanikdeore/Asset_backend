<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display the active About Us content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
{
    try {
        // Remove the is_active condition
        $aboutUs = AboutUs::first();

        if (!$aboutUs) {
            return response()->json([
                'success' => false,
                'message' => 'No About Us content found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $aboutUs
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error retrieving content',
            'error' => $e->getMessage()
        ], 500);
    }
}
    
}
