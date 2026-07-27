<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->foreignId('work_site_id')->nullable()->after('id')->constrained('work_sites')->cascadeOnDelete();
            $table->string('role')->default('worker')->after('trade');
        });
    }

    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropForeign(['work_site_id']);
            $table->dropColumn(['work_site_id', 'role']);
        });
    }
};
