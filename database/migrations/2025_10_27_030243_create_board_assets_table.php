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
        Schema::create('board_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('board_card_id')->nullable()->constrained('board_cards')->nullOnDelete();
            $table->string('filename');     // nama asli file
            $table->string('path');         // path di storage
            $table->string('mime_type');    // image/png, application/pdf, dll
            $table->string('extension')->nullable(); // png, jpg, pdf, dll
            $table->integer('size')->nullable();     // byte size
            // Metadata tambahan
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_assets');
    }
};
