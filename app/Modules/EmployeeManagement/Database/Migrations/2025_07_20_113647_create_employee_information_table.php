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
        Schema::create('employee_information', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->unique(); // Custom EmployeeCode
            $table->integer("display_order")->default(0);

            $table->string('full_name');
            $table->tinyInteger('gender');  // enum
            $table->date('date_of_birth');
            $table->tinyInteger('marital_status'); // enum

            $table->string('nationality');
            $table->string('citizenship_no')->unique();
            $table->string('issued_district');

            $table->string('pan_no')->unique();
            $table->tinyInteger('blood_group');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
