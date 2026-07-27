<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','sales','project_manager','project_head','project_coordinator','site_manager','site_supervisor','supervisor','security','office_staff','inventory_manager') NOT NULL DEFAULT 'office_staff'");
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'inventory_manager')->update(['role' => 'office_staff']);
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','sales','project_manager','project_head','project_coordinator','site_manager','site_supervisor','supervisor','security','office_staff') NOT NULL DEFAULT 'office_staff'");
    }
};
