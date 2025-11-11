<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // add this

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('helpline')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('google_map')->nullable();
            $table->json('locations')->nullable();
            $table->json('field_offices')->nullable();
            $table->string('default_image')->nullable();
            $table->integer('language_id')->default(1);
            $table->integer('show_all_page')->default(1);
            $table->integer('accept_multiple')->default(1);
            $table->timestamps();
        });

        // Insert default data
        DB::table('settings')->insert([
            'site_name'     => 'Company Name',
            'logo'          => 'default-logo.png',
            'favicon'       => 'default-favicon.ico',
            'address'       => 'Kathmandu, Nepal',
            'phone'         => '+977-9812345678',
            'email'         => 'info@example.com',
            'facebook'      => 'https://facebook.com',
            'twitter'       => 'https://twitter.com',
            'instagram'     => 'https://instagram.com',
            'youtube'       => 'https://youtube.com',
            'tiktok'        => 'https://tiktok.com',
            'whatsapp'      => '+977-9812345678',
            'google_map'    => '<iframe src="https://maps.google.com/..."></iframe>',
            'default_image' => 'default-image.jpg',
            'show_all_page' => 1,
            'accept_multiple' => 1,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
