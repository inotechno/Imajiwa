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
        Schema::create('absent_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->enum('type_absent', ['sakit', 'izin', 'lainnya'])->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->foreignId('director_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('supervisor_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();

            $table->timestamp('director_approved_at')->nullable();
            $table->timestamp('supervisor_approved_at')->nullable();

            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absent_requests');
    }
};
