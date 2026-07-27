<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','project_manager','project_head','project_coordinator','site_manager','site_supervisor','supervisor','security','office_staff') NOT NULL DEFAULT 'office_staff'");
        }
    }
    public function down(): void {}
};
