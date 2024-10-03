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
        Schema::table('absent_requests', function (Blueprint $table) {
            // Tambahkan kolom jika tidak ada
            if (!Schema::hasColumn('absent_requests', 'type_absent')) {
                $table->string('type_absent')->nullable();
            }
            if (!Schema::hasColumn('absent_requests', 'hrd_id')) {
                $table->foreignId('hrd_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();
            }
            if (!Schema::hasColumn('absent_requests', 'hrd_approved_at')) {
                $table->timestamp('hrd_approved_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absent_requests', function (Blueprint $table) {
            // Hapus kolom jika ada
            if (Schema::hasColumn('absent_requests', 'type_absent')) {
                $table->dropColumn('type_absent');
            }
            if (Schema::hasColumn('absent_requests', 'hrd_id')) {
                $table->dropForeign(['hrd_id']); // Hapus foreign key terlebih dahulu jika ada
                $table->dropColumn('hrd_id');
            }
            if (Schema::hasColumn('absent_requests', 'hrd_approved_at')) {
                $table->dropColumn('hrd_approved_at');
            }
        });
    }
};
