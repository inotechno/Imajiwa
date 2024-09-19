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
            // Ubah nama kolom supervisor_id menjadi commissioner_id
            $table->renameColumn('supervisor_id', 'commissioner_id');

            // Ubah nama kolom supervisor_approved_at menjadi commissioner_approved_at
            $table->renameColumn('supervisor_approved_at', 'commissioner_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Kembalikan nama kolom commissioner_id menjadi supervisor_id
            $table->renameColumn('commissioner_id', 'supervisor_id');

            // Kembalikan nama kolom commissioner_approved_at menjadi supervisor_approved_at
            $table->renameColumn('commissioner_approved_at', 'supervisor_approved_at');
        });
    }
};
