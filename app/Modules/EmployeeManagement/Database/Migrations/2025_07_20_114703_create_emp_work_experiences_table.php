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
        Schema::create('emp_work_experiences', function (Blueprint $table) {
            $table->id();
            // Foreign key to personal_information
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employee_information')
                ->onDelete('cascade');

            $table->string('organization_name');
            $table->string('designation');
            $table->date('from_date');
            $table->date('to_date');
            $table->text('reason_for_leaving');
            $table->string('experience_letter'); // Just the filename
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
