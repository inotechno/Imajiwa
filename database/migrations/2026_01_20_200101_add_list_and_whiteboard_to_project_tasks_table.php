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
        Schema::table('project_tasks', function (Blueprint $table) {
            $table->foreignId('list_id')->nullable()->after('project_id')->constrained('task_lists')->nullOnDelete();
            $table->string('whiteboard_room_id')->nullable()->after('google_event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_tasks', function (Blueprint $table) {
            $table->dropForeign(['list_id']);
            $table->dropColumn(['list_id', 'whiteboard_room_id']);
        });
    }
};
