<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('spare_parts', function (Blueprint $table) {
        $table->string('image')->nullable()->after('description');
        $table->string('detected_model')->nullable()->after('image');
    });
}

public function down(): void
{
    Schema::table('spare_parts', function (Blueprint $table) {
        $table->dropColumn(['image', 'detected_model']);
    });
}
};
