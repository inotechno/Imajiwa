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
        Schema::create('board_connectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('from_card_id')->constrained('board_cards')->cascadeOnDelete();
            $table->foreignId('to_card_id')->constrained('board_cards')->cascadeOnDelete();
            $table->string('style')->default('line'); // line, arrow, curve
            $table->string('color')->default('#000000');
            $table->float('thickness')->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_connectors');
    }
};
