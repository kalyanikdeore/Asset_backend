<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Introduction extends Model
{
    
        protected $table = 'introduction_section';
        
        protected $fillable = [
            'intro_header',
            'intro_description',
            'intro_image',
            'intro_investment_insurance'
        ];
        
        protected $casts = [
            'intro_description' => 'array',
            'intro_investment_insurance' => 'array',
        ];
    
}
