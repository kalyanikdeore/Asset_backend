<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'highlighted_name',
        'features',
        'description_1',
        'description_2',
        'cta_text',
        'investment_title',
        'investment_features',
        'investment_cta_text',
        'image_path',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'investment_features' => 'array',
    ];
}