<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropUnique('workers_worker_code_unique');
            $table->unique(['work_site_id', 'worker_code'], 'workers_site_code_unique');
        });
    }

    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropUnique('workers_site_code_unique');
            $table->unique('worker_code');
        });
    }
};
