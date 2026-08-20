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
        Schema::table('work_sites', function (Blueprint $table) {
            $table->foreignId('project_engineer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('work_coordinator_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_sites', function (Blueprint $table) {
            $table->dropForeign(['project_engineer_id']);
            $table->dropForeign(['work_coordinator_id']);
            $table->dropColumn(['project_engineer_id', 'work_coordinator_id']);
        });
    }
};
