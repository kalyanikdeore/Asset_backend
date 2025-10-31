<?php

namespace App\Http\Controllers;

use App\Models\ProductFaq;
use Illuminate\Http\Request;

class ProductFaqController extends Controller
{
    // API Endpoints
    public function index()
    {
        $faqs = ProductFaq::where('is_active', true)
                         ->orderBy('sort_order')
                         ->get(['question', 'answer', 'sort_order']);
        
        return response()->json($faqs);
    }

    public function show(ProductFaq $faq)
    {
        return response()->json($faq);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $faq = ProductFaq::create($validated);
        return response()->json($faq, 201);
    }

    public function update(Request $request, ProductFaq $faq)
    {
        $validated = $request->validate([
            'question' => 'sometimes|string|max:255',
            'answer' => 'sometimes|string',
            'sort_order' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean'
        ]);

        $faq->update($validated);
        return response()->json($faq);
    }

    public function destroy(ProductFaq $faq)
    {
        $faq->delete();
        return response()->json(null, 204);
    }
}