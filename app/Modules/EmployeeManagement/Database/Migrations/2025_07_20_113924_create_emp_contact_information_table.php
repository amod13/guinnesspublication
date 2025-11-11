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
        Schema::create('emp_contact_information', function (Blueprint $table) {
            $table->id();
            // Foreign key to employee)information
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employee_information')
                ->onDelete('cascade');

            $table->string('mobile_number')->unique();
            $table->string('email_address')->unique();
            $table->string('permanent_address');
            $table->string('temporary_address');

            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number')->unique();

            $table->tinyInteger('relationship'); //enum

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_information');
    }
};
