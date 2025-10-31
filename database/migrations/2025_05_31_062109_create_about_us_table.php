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
       Schema::create('about_us', function (Blueprint $table) {
    $table->id();
    
    // Company Section
    $table->text('company_description');
    $table->json('company_images')->nullable();
    
    // Why Choose Us Section
    $table->text('why_choose_us');
    $table->text('why_choose_us_bullets')->nullable();
    
    // Additional Text
    $table->text('additional_text')->nullable();
    
    // Experience
    $table->string('experience_years');
    $table->string('experience_image')->nullable();
    
    // Key Strengths
    $table->json('key_strengths')->nullable(); // [{title: string, icon: string, description: text}]
    
    // Areas of Expertise
    $table->json('expertise_areas')->nullable(); // [{title: string, description: text}]
    
    // Visionary Leaders
    $table->json('leaders')->nullable(); // [{name: string, position: string, description: text, image: string}]
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
