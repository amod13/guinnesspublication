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
        Schema::create('emp_official_documents', function (Blueprint $table) {
            $table->id();
            // Foreign key to employee or personal information table
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employee_information')
                ->onDelete('cascade');

            // Document fields
            $table->string('resume_cv');
            $table->string('citizenship'); // double
            $table->string('pan_card');
            $table->string('appointment_letter');
            $table->string('employee_contract');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offical_documents');
    }
};
