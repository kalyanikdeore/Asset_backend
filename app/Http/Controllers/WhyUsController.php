<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\WhyUs;
use Illuminate\Http\Request;

class WhyUsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/why-us",
     *     summary="Get active Why Us content",
     *     tags={"Why Us"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/WhyUs")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function index()
    {
        $whyUs = WhyUs::with([]) // Add relationships if needed
            ->where('is_active', true)
            ->first();
        
        if (!$whyUs) {
            return response()->json([
                'success' => false,
                'message' => 'No active Why Us section found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $whyUs
        ]);
    }
}