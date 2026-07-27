<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('id');
            $table->string('mobile', 20)->nullable()->after('email');
            $table->string('department')->nullable()->after('role');
            $table->string('status')->default('active')->after('department');
            $table->text('address')->nullable()->after('status');
            $table->text('remarks')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'photo',
                'mobile',
                'department',
                'status',
                'address',
                'remarks',
            ]);
        });
    }
};