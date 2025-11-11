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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('language')->default('en');
            $table->string('title')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('thumbnail_image_id')->nullable();
            $table->json('meta_data')->nullable();
            $table->integer('display_order')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
