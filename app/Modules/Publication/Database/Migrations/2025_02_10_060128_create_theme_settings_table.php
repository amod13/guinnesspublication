<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key_name')->unique();   // example: amd-primary
            $table->string('label');               // human readable: Primary Color
            $table->string('value');               // #ffd20be5
            $table->string('type')->default('color'); // color, text, number etc
            $table->string('version')->nullable();
            $table->timestamps();
        });
        // Seed initial values with all columns (version included)
        DB::table('theme_settings')->insert([
            ['key_name' => 'amd-primary', 'label' => 'Primary Color', 'value' => '#ffd20be5', 'type' => 'color', 'version' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key_name' => 'amd-primary-hover', 'label' => 'Primary Hover Color', 'value' => '#008b16', 'type' => 'color', 'version' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key_name' => 'amd-primary-text', 'label' => 'Primary Text Color', 'value' => '#ffffff', 'type' => 'color', 'version' => null, 'created_at' => now(), 'updated_at' => now()],

            ['key_name' => 'amd-secondary', 'label' => 'Secondary Color', 'value' => '#00af1dab', 'type' => 'color', 'version' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key_name' => 'amd-secondary-hover', 'label' => 'Secondary Hover Color', 'value' => '#ffd20be5', 'type' => 'color', 'version' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key_name' => 'amd-secondary-text', 'label' => 'Secondary Text Color', 'value' => '#000000', 'type' => 'color', 'version' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
