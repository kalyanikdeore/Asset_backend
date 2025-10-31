<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('why_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('highlighted_name');
            $table->json('features'); // Store features as JSON array
            $table->text('description_1');
            $table->text('description_2');
            $table->string('cta_text');
            $table->string('investment_title');
            $table->json('investment_features');
            $table->string('investment_cta_text');
            $table->string('image_path');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('why_us');
    }
};
