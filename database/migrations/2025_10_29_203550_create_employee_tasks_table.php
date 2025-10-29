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
        Schema::create('employee_tasks', function (Blueprint $table) {
            // Sesuaikan dengan tipe employees.id (bigint)
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('project_task_id');
            $table->timestamps();

            $table->foreign('employee_id')
                ->references('id')->on('employees')
                ->cascadeOnDelete();

            $table->foreign('project_task_id')
                ->references('id')->on('project_tasks')
                ->cascadeOnDelete();

            $table->primary(['employee_id', 'project_task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_tasks');
    }
};
