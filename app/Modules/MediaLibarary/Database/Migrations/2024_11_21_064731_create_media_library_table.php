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
        Schema::create('media_library', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('filename'); // stored filename (unique-ish)
            $table->string('original_filename')->nullable(); // user-uploaded name
            $table->string('file_path'); // relative path like storage/media-library/xyz.png
            $table->string('mime_type')->nullable(); // e.g. image/png
            $table->string('file_type')->nullable(); // image, video, audio, document
            $table->unsignedBigInteger('file_size')->default(0);
            $table->json('metadata')->nullable(); // extra info like dimensions, duration, etc.
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();
            $table->text('description')->nullable();
            $table->integer('uploaded_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_library');
    }
};
