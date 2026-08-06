<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_sites', function (Blueprint $table) {
            $table->foreignId('project_head_id')
                ->nullable()
                ->after('project_coordinator_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('project_engineer_id')
                ->nullable()
                ->after('project_head_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('work_coordinator_id')
                ->nullable()
                ->after('project_engineer_id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('work_sites', function (Blueprint $table) {
            $table->dropForeign(['work_coordinator_id']);
            $table->dropColumn('work_coordinator_id');

            $table->dropForeign(['project_engineer_id']);
            $table->dropColumn('project_engineer_id');

            $table->dropForeign(['project_head_id']);
            $table->dropColumn('project_head_id');
        });
    }
};