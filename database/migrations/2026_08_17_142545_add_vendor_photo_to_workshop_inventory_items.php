<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('workshop_inventory_items', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('notes');
            $table->string('purchased_from')->nullable()->after('photo');
            $table->string('vendor_contact')->nullable()->after('purchased_from');
        });
    }

    public function down(): void
    {
        Schema::table('workshop_inventory_items', function (Blueprint $table) {
            $table->dropColumn(['photo', 'purchased_from', 'vendor_contact']);
        });
    }
};
