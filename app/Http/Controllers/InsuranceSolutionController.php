<?php

namespace App\Http\Controllers;

use App\Models\InsuranceSolution;

class InsuranceSolutionController extends Controller
{
    public function index()
    {
        $solutions = InsuranceSolution::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'title', 'description', 'image']);

        // Add full URL for images
        $solutions->transform(function ($solution) {
            $solution->image_url = $solution->image
                ? asset('storage/' . $solution->image)
                : null;
                
            return $solution;
        });

        return response()->json([
            'success' => true,
            'data' => $solutions
        ]);
    }
}
