<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // Relationship
            $table->unsignedBigInteger('blog_category_id')->nullable();
            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('set null');

            // Basic Info
            $table->string('title');
            $table->string('slug')->unique();

            // Content
            $table->text('excerpt')->nullable(); // short summary
            $table->longText('content')->nullable(); // full blog content
            $table->json('tags')->nullable(); // multiple tags like ["child","education","awareness"]

            // Media
            $table->string('featured_image')->nullable(); // main banner image
            $table->string('thumbnail_image')->nullable(); // small card image
            $table->string('video_url')->nullable(); // optional embedded video link

            // SEO Meta Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('meta_og_image')->nullable();

            // Author Info
            $table->unsignedBigInteger('author_id')->nullable(); // users table reference
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->string('author_name')->nullable(); // fallback in case author_id null

            // Publication Info
            $table->date('published_date')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('views_count')->default(0);

            // Display Control
            $table->integer('display_order')->default(1);
            $table->boolean('status')->default(true);

            // Localization
          $table->string('language')->default('en');

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
