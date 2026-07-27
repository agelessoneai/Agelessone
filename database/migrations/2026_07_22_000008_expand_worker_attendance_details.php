<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('worker_attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('worker_attendances', 'supervisor_id')) {
                $table->foreignId('supervisor_id')->nullable()->after('site_zone_id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('worker_attendances', 'work_description')) {
                $table->string('work_description')->nullable()->after('supervisor_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('worker_attendances', function (Blueprint $table) {
            if (Schema::hasColumn('worker_attendances', 'work_description')) {
                $table->dropColumn('work_description');
            }
            if (Schema::hasColumn('worker_attendances', 'supervisor_id')) {
                $table->dropConstrainedForeignId('supervisor_id');
            }
        });
    }
};
