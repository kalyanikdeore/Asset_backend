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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('category');
            $table->string('image_url');
            $table->date('published_date');
            $table->boolean('is_published')->default(true);
            $table->string('author_name');
            $table->string('author_avatar');
            $table->string('author_role');
            $table->json('related_products')->nullable();
            $table->timestamps();
             // Add indexes for better performance
            $table->index('is_published');
            $table->index('published_date');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
