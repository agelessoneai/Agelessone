<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->string('punch_out_location')->nullable()->after('location');

        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->dropColumn('punch_out_location');

        });
    }
};