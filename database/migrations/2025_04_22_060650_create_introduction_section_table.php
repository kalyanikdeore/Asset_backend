<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
             
        Schema::create('introduction_section', function (Blueprint $table) {
            $table->id();
            $table->string('intro_header');
            $table->json('intro_description'); // For storing bullet points
            $table->string('intro_image');
            $table->json('intro_investment_insurance'); // For storing bullet points
            $table->timestamps();
        }); 
        
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('introduction_section');
    }
};
