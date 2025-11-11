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
        Schema::create('emp_employment_details', function (Blueprint $table) {
            $table->id();

            // Foreign key to personal_information
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employee_information')
                ->onDelete('cascade');

            $table->date('date_of_joining');

            $table->date('date_of_leaving')->nullable();

            // Foreign key to departments
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')
                ->references('id')
                ->on('emp_departments')
                ->onDelete('restrict');
            // "Cannot delete department because employees are assigned to it."

            // Foreign key to sub_departments
            $table->unsignedBigInteger('sub_department_id')->nullable();
            $table->foreign('sub_department_id')
                ->references('id')
                ->on('emp_sub_departments')
                ->onDelete('set null');

            // Foreign key to designations
            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')
                ->references('id')
                ->on('emp_designations')
                ->onDelete('restrict');

            // Enums
            $table->tinyInteger('employment_type');
            $table->tinyInteger('job_category');
            $table->tinyInteger('employee_status');

            // Optional: keep as string or convert to FK if needed
            $table->string('reporting_manager');
            // $table->unsignedBigInteger("reporting_manger");
            // $table->foreign('reporting_manger')
            //     ->references('id')
            //     ->on('employee_information')
            //     ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_details');
    }
};
