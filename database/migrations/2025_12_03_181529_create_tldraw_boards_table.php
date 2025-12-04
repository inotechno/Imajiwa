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
        Schema::create('tldraw_boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->longText('state')->nullable(); // snapshot JSON TLDraw

            $table->timestamps();

            // Foreign key
            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');

            // Index
            $table->index('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tldraw_boards');
    }
};
