<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_zones', function (Blueprint $table) {
            if (!Schema::hasColumn('site_zones', 'start_time')) {
                $table->time('start_time')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('site_zones', 'end_time')) {
                $table->time('end_time')->nullable()->after('expected_end_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_zones', function (Blueprint $table) {
            if (Schema::hasColumn('site_zones', 'end_time')) {
                $table->dropColumn('end_time');
            }
            if (Schema::hasColumn('site_zones', 'start_time')) {
                $table->dropColumn('start_time');
            }
        });
    }
};
