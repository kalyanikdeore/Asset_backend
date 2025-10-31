<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('tagline');
            $table->json('phone_numbers')->nullable();
            $table->json('emails')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->json('working_hours')->nullable();
            $table->text('appointment_info')->nullable();
            $table->text('address');
            $table->json('social_links')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};