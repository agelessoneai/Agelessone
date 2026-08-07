<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_zones', function (Blueprint $table) {
            $table->foreignId('work_coordinator_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->after('supervisor_id');
        });
    }

    public function down(): void
    {
        Schema::table('site_zones', function (Blueprint $table) {
            $table->dropForeign(['work_coordinator_id']);
            $table->dropColumn('work_coordinator_id');
        });
    }
};