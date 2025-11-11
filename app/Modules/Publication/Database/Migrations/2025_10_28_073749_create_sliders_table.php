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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('language')->default('en');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->text('video_url')->nullable();
            $table->unsignedBigInteger('background_image')->nullable();
            $table->foreign('background_image')->references('id')->on('media_library')->onDelete('set null');
            $table->unsignedBigInteger('background_image_1')->nullable();
            $table->foreign('background_image_1')->references('id')->on('media_library')->onDelete('set null');
            $table->unsignedBigInteger('background_image_2')->nullable();
            $table->foreign('background_image_2')->references('id')->on('media_library')->onDelete('set null');
            $table->boolean('status')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
