<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('language')->default('en');
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('book_categories')->onDelete('set null');
            $table->unsignedBigInteger('thumbnail_image')->nullable();
            $table->unsignedBigInteger('pdf_file')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('display_order')->nullable();
            $table->string('public_pdf_pages')->nullable();
            $table->string('highlights')->default('normal')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};
