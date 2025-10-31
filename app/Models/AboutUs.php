<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AboutUs extends Model 
{
    use HasFactory;

    protected $fillable = [
        'company_description',
        'why_choose_us',
        
        'additional_text',
        'experience_years',
        'company_images',
        'why_choose_us_bullets',
        'key_strengths',
        'expertise_areas',
        'leaders',
    ];

    protected $casts = [
        'company_images' => 'array',
        'why_choose_us_bullets' => 'array',
        'key_strengths' => 'array',
        'expertise_areas' => 'array',
        'leaders' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('company_images')
            ->useDisk('public')
            ->singleFile();

        $this->addMediaCollection('experience_image')
            ->useDisk('public')
            ->singleFile();

        $this->addMediaCollection('leaders_images')
            ->useDisk('public');
    }
}