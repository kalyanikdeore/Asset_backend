<?php

namespace App\Http\Controllers;

use App\Models\InsuranceType;

class InsuranceController extends Controller
{
     public function index()
    {
        // Get all insurance types ordered by latest first
        $insuranceTypes = InsuranceType::orderBy('order')->get();
        
        return response()->json([
            'success' => true,
            'data' => $insuranceTypes
        ]);
    }
}