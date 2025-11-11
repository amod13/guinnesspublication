<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->string('language')->default('en');
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('display_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_categories');
    }
};
