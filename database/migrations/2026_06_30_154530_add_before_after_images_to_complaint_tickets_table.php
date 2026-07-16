<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
{
    Schema::table('complaint_tickets', function (Blueprint $table) {
        $table->string('before_image')->nullable()->after('completed_at');
        $table->string('after_image')->nullable()->after('before_image');
    });
}

public function down(): void
{
    Schema::table('complaint_tickets', function (Blueprint $table) {
        $table->dropColumn([
            'before_image',
            'after_image'
        ]);
    });
}


};
