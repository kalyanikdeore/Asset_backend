<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()->ordered()->get();
        return response()->json($faqs);
    }

    // Add other methods as needed
    public function show($id)
    {
        $faq = Faq::findOrFail($id);
        return response()->json($faq);
    }
}