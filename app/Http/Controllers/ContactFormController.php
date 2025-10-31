<?php

namespace App\Http\Controllers\api;

use App\Models\ContactForm;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the contact form submissions.
     */
    public function index()
    {
        $submissions = ContactForm::all();
        
        return response()->json([
            'data' => $submissions,
            'message' => 'Contact form submissions retrieved successfully'
        ]);
    }

    /**
     * Store a newly created contact form submission.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'service' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        $submission = ContactForm::create($data);

        return response()->json([
            'message' => 'Form submitted successfully',
            'data' => $submission
        ], 201);
    }
}