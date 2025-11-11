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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
              $table->string('language')->default('en');
            $table->string('title');
            $table->string('menu_icon')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('position')->default(0);
            $table->string('type')->default('link'); // Optional for categorizing
            $table->integer('status')->default(1);
            $table->string('menu_type_id');
            $table->string('image')->nullable();
            $table->boolean('is_mega_menu')->default(0);
            $table->text('description')->nullable();
            $table->text('blockquote')->nullable();
            $table->integer('is_display_web')->default(0); // New field to track web display status
            $table->integer('is_thematic')->default(0);
            $table->integer('page_id')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
