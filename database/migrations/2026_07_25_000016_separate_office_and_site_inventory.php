<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->string('inventory_type', 20)->default('office')->after('usage_purpose')->index();
        });

        DB::statement("UPDATE inventory_items SET inventory_type = 'site' WHERE inventory_category_id IN (SELECT id FROM inventory_categories WHERE name = 'Site Items') OR item_code LIKE 'SITE-%'");
    }

    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropIndex(['inventory_type']);
            $table->dropColumn('inventory_type');
        });
    }
};
