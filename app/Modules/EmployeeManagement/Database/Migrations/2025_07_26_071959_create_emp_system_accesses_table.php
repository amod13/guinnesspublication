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
        Schema::create('emp_system_accesses', function (Blueprint $table) {
            $table->id();

            // Foreign key to employee or personal info
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employee_information')
                ->onDelete('cascade');

            $table->tinyInteger("can_access")->default(0);

            // users table(employee_id, name(space/re 123/ nitesh (username)unique ), password(hash password), status(default 0));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_system_accesses');
    }
};
