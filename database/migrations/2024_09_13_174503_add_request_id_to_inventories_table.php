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
        Schema::table('inventories', function (Blueprint $table) {
            // Add only if the column does not exist
            if (!Schema::hasColumn('inventories', 'request_id')) {
                $table->unsignedBigInteger('request_id')->nullable()->after('id');
                $table->foreign('request_id')->references('id')->on('request_items')->onDelete('cascade');
            }

            if (!Schema::hasColumn('inventories', 'director_id')) {
                $table->foreignId('director_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();
            }

            if (!Schema::hasColumn('inventories', 'supervisor_id')) {
                $table->foreignId('supervisor_id')->nullable()->constrained('employees')->nullOnDelete()->cascadeOnUpdate();
            }

            if (!Schema::hasColumn('inventories', 'director_approved_at')) {
                $table->timestamp('director_approved_at')->nullable();
            }

            if (!Schema::hasColumn('inventories', 'supervisor_approved_at')) {
                $table->timestamp('supervisor_approved_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Cek dan hapus foreign key jika ada
            if (Schema::hasColumn('inventories', 'request_id')) {
                // Coba hapus foreign key berdasarkan nama yang benar
                $table->dropForeign(['request_id']);  // Hapus foreign key jika ada
                $table->dropColumn('request_id');    // Hapus kolom
            }

            if (Schema::hasColumn('inventories', 'director_id')) {
                $table->dropForeign(['director_id']); // Hapus foreign key jika ada
                $table->dropColumn('director_id');   // Hapus kolom
            }

            if (Schema::hasColumn('inventories', 'supervisor_id')) {
                $table->dropForeign(['supervisor_id']); // Hapus foreign key jika ada
                $table->dropColumn('supervisor_id');   // Hapus kolom
            }

            // Hapus kolom tanpa foreign key
            if (Schema::hasColumn('inventories', 'director_approved_at')) {
                $table->dropColumn('director_approved_at');
            }

            if (Schema::hasColumn('inventories', 'supervisor_approved_at')) {
                $table->dropColumn('supervisor_approved_at');
            }
        });
    }
};
