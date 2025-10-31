<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\HeroItem;

class HeroItemController extends Controller
{
    public function index()
    {
        return response()->json(HeroItem::all());
    }
}
