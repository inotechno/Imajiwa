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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes')->nullable();
            $table->integer('total_days')->unsigned();
            $table->integer('current_total_leave')->unsigned();
            $table->integer('total_leave_after_request')->unsigned();
            $table->foreignId('director_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('supervisor_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('director_approved_at')->nullable();
            $table->timestamp('supervisor_approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
