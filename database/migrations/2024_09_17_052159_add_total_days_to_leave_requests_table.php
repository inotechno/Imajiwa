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
        Schema::table('leave_requests', function (Blueprint $table) {
            if (Schema::hasColumn('leave_requests', 'total_days')) {
                $table->integer('total_days')->unsigned();
            }
            if (Schema::hasColumn('leave_requests', 'hrd_id')) {
                $table->foreignId('hrd_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();
            }
            if (Schema::hasColumn('leave_requests', 'hrd_approved_at')) {
                $table->timestamp('hrd_approved_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('leave_requests', 'total_days')) {
                $table->dropColumn('total_days');
            }
            if (!Schema::hasColumn('leave_requests', 'hrd_id')) {
                $table->unsignedBigInteger('hrd_id')->nullable();
            }
            if (!Schema::hasColumn('leave_requests', 'hrd_approved_at')) {
                $table->timestamp('hrd_approved_at')->nullable();
            }
        });
    }
};
