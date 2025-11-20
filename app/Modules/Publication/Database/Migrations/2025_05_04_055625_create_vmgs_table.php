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
        Schema::create('vmgs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('subtitle')->nullable();
            $table->json('features')->nullable();
            $table->text('video_url')->nullable();
            $table->unsignedBigInteger('front_image_id')->nullable();
            $table->foreign('front_image_id')->references('id')->on('media_library')->onDelete('set null');
            $table->unsignedBigInteger('back_image_id')->nullable();
            $table->foreign('back_image_id')->references('id')->on('media_library')->onDelete('set null');
            $table->boolean('status')->default(true);
            $table->string('language')->default('en');
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vmgs');
    }
};
