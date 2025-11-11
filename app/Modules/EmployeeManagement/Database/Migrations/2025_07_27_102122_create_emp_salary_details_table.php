<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emp_salary_details', function (Blueprint $table) {
            $table->id();

            // Foreign key to employee or personal info
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employee_information')
                ->onDelete('cascade');

            $table->decimal('basic_salary', 10, 2);
            $table->decimal('allowances', 10, 2);
            $table->decimal('deductions', 10, 2); //polocy ma hunxa hai
            $table->string('bank_name');
            $table->string('bank_account_number')->unique();
            $table->string('provident_fund_no')->unique();
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_salary_details');
    }
};
