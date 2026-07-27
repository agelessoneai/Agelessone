<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_zones', function (Blueprint $table) {
            $table->foreignId('supervisor_id')
                ->nullable()
                ->after('work_type')
                ->constrained('users')
                ->nullOnDelete();

            $table->string('status')
                ->default('not_started')
                ->after('supervisor_id');

            $table->unsignedTinyInteger('progress')
                ->default(0)
                ->after('status');

            $table->date('start_date')
                ->nullable()
                ->after('progress');

            $table->date('expected_end_date')
                ->nullable()
                ->after('start_date');
        });
    }

    public function down(): void
    {
        Schema::table('site_zones', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);

            $table->dropColumn([
                'supervisor_id',
                'status',
                'progress',
                'start_date',
                'expected_end_date',
            ]);
        });
    }
};