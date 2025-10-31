<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class InsuranceSolution extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'sort_order',
        'is_active',
    ];

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? Storage::url($this->image) : null,
        );
    }
}