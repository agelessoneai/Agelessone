<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('work_sites', function (Blueprint $table) {
            if (!Schema::hasColumn('work_sites', 'project_coordinator_id')) {
                $table->foreignId('project_coordinator_id')->nullable()->after('project_manager_id')->constrained('users')->nullOnDelete();
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'punch_in_photo')) $table->string('punch_in_photo')->nullable()->after('punch_in');
            if (!Schema::hasColumn('attendances', 'punch_out_photo')) $table->string('punch_out_photo')->nullable()->after('punch_out');
            if (!Schema::hasColumn('attendances', 'work_site_id')) $table->foreignId('work_site_id')->nullable()->after('user_id')->constrained('work_sites')->nullOnDelete();
        });

        Schema::table('worker_attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('worker_attendances', 'approved_at')) $table->timestamp('approved_at')->nullable()->after('approved_by');
            if (!Schema::hasColumn('worker_attendances', 'rejection_reason')) $table->text('rejection_reason')->nullable()->after('approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('worker_attendances', function (Blueprint $table) {
            if (Schema::hasColumn('worker_attendances', 'rejection_reason')) $table->dropColumn('rejection_reason');
            if (Schema::hasColumn('worker_attendances', 'approved_at')) $table->dropColumn('approved_at');
        });
        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'work_site_id')) $table->dropConstrainedForeignId('work_site_id');
            if (Schema::hasColumn('attendances', 'punch_out_photo')) $table->dropColumn('punch_out_photo');
            if (Schema::hasColumn('attendances', 'punch_in_photo')) $table->dropColumn('punch_in_photo');
        });
        Schema::table('work_sites', function (Blueprint $table) {
            if (Schema::hasColumn('work_sites', 'project_coordinator_id')) $table->dropConstrainedForeignId('project_coordinator_id');
        });
    }
};
