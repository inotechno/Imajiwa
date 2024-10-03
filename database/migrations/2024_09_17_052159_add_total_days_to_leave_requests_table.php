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
            // Tambahkan kolom jika tidak ada
            if (!Schema::hasColumn('leave_requests', 'total_days')) {
                $table->integer('total_days')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('leave_requests', 'hrd_id')) {
                $table->foreignId('hrd_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();
            }
            if (!Schema::hasColumn('leave_requests', 'hrd_approved_at')) {
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
            // Hapus kolom jika ada
            if (Schema::hasColumn('leave_requests', 'total_days')) {
                $table->dropColumn('total_days');
            }
            if (Schema::hasColumn('leave_requests', 'hrd_id')) {
                // Cek apakah foreign key ada sebelum menghapusnya
                $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'leave_requests' AND COLUMN_NAME = 'hrd_id' AND CONSTRAINT_SCHEMA = '" . env('DB_DATABASE') . "'");
                if (!empty($foreignKeys)) {
                    $table->dropForeign(['hrd_id']); // Hapus foreign key terlebih dahulu
                }
                $table->dropColumn('hrd_id');
            }
            if (Schema::hasColumn('leave_requests', 'hrd_approved_at')) {
                $table->dropColumn('hrd_approved_at');
            }
        });
    }
};
