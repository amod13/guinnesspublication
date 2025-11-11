<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('language')->default('en');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('image_media_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('features')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('happy_clients')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();

            // Foreign keys
            $table->foreign('image_media_id')->references('id')->on('media_library')->onDelete('set null');

            // Indexes
            $table->index(['status', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
