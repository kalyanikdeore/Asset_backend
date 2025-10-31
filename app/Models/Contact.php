<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'tagline',
        'phone_numbers',
        'emails',
        'whatsapp_number',
        'working_hours',
        'appointment_info',
        'address',
        'social_links',
    ];

    protected $casts = [
        'phone_numbers' => 'array',
        'emails' => 'array',
        'working_hours' => 'array',
        'social_links' => 'array',
    ];

    protected $attributes = [
    'phone_numbers' => '[]',
    'emails' => '[]',
    'working_hours' => '[]',
    'social_links' => '[]',
];
}