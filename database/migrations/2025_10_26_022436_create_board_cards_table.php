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
        Schema::create('board_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('type')->default('text'); // text, image, file, note, etc.
            $table->string('path')->nullable(); // untuk tipe image/file
            $table->json('meta')->nullable(); // untuk menyimpan metadata tambahan dalam format JSON
            $table->text('content')->nullable();
            $table->float('x')->default(100);
            $table->float('y')->default(100);
            $table->float('w')->default(200);
            $table->float('h')->default(100);
            $table->integer('z_index')->default(1);
            $table->string('color')->nullable();
             $table->string('background')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_cards');
    }
};
