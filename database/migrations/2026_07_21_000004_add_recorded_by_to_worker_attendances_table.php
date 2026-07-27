<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('worker_attendances', function (Blueprint $table) {
            $table->foreignId('recorded_by')->nullable()->after('site_zone_id')->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable()->after('approved_by');
            $table->unique(['worker_id', 'attendance_date'], 'worker_attendance_daily_unique');
        });
    }

    public function down(): void
    {
        Schema::table('worker_attendances', function (Blueprint $table) {
            $table->dropUnique('worker_attendance_daily_unique');
            $table->dropConstrainedForeignId('recorded_by');
            $table->dropColumn('remarks');
        });
    }
};
