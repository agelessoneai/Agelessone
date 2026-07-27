<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->text('usage_purpose')->nullable()->after('description');
        });

        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->foreignId('work_site_id')->nullable()->after('user_id')
                ->constrained('work_sites')->nullOnDelete();
            $table->string('used_for')->nullable()->after('warehouse');
            $table->string('issued_to')->nullable()->after('used_for');
        });
    }

    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('work_site_id');
            $table->dropColumn(['used_for', 'issued_to']);
        });

        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropColumn('usage_purpose');
        });
    }
};
