<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('insurance_types', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->default(0);
            $table->string('title');
            $table->text('short_description');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insurance_types');
    }
};
