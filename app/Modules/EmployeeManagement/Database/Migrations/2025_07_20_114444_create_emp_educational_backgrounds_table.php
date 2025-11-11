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
        Schema::create('emp_educational_backgrounds', function (Blueprint $table) {
            $table->id();
            // Foreign key to personal_information
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employee_information')
                ->onDelete('cascade');

            $table->string('degree');
            $table->string('institution_name');
            $table->year('year_of_passing');
            $table->string('grade_percentage');
            $table->string('certificate'); // Just the filename
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_backgrounds');
    }
};
