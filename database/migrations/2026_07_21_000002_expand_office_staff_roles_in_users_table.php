<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Normalize old role values
        |--------------------------------------------------------------------------
        */

        DB::table('users')
            ->whereNull('role')
            ->orWhere('role', '')
            ->update([
                'role' => 'office_staff',
            ]);

        DB::table('users')
            ->whereIn('role', [
                'user',
                'staff',
                'employee',
                'office',
            ])
            ->update([
                'role' => 'office_staff',
            ]);

        DB::table('users')
            ->whereIn('role', [
                'manager',
                'project manager',
                'project-manager',
            ])
            ->update([
                'role' => 'project_manager',
            ]);

        DB::table('users')
            ->whereIn('role', [
                'project head',
                'project-head',
            ])
            ->update([
                'role' => 'project_head',
            ]);

        DB::table('users')
            ->whereIn('role', [
                'site supervisor',
                'site-supervisor',
            ])
            ->update([
                'role' => 'site_supervisor',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Any remaining unknown role becomes office_staff
        |--------------------------------------------------------------------------
        */

        DB::table('users')
            ->whereNotIn('role', [
                'admin',
                'project_manager',
                'project_head',
                'site_supervisor',
                'supervisor',
                'security',
                'office_staff',
            ])
            ->update([
                'role' => 'office_staff',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Expand role enum
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role ENUM(
                'admin',
                'project_manager',
                'project_head',
                'site_supervisor',
                'supervisor',
                'security',
                'office_staff'
            )
            NOT NULL DEFAULT 'office_staff'
        ");
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Convert new roles before restoring old enum
        |--------------------------------------------------------------------------
        */

        DB::table('users')
            ->whereIn('role', [
                'project_manager',
                'project_head',
                'site_supervisor',
                'supervisor',
                'security',
                'office_staff',
            ])
            ->update([
                'role' => 'staff',
            ]);

        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role ENUM(
                'admin',
                'staff'
            )
            NOT NULL DEFAULT 'staff'
        ");
    }
};