<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->string('assignment_status', 20)->default('available')->after('issued_to');
            $table->timestamp('assigned_at')->nullable()->after('assignment_status');
            $table->timestamp('returned_at')->nullable()->after('assigned_at');
            $table->foreignId('returned_by_user_id')->nullable()->after('returned_at')
                ->constrained('users')->nullOnDelete();
            $table->string('return_condition', 30)->nullable()->after('returned_by_user_id');
            $table->text('return_note')->nullable()->after('return_condition');
        });

        DB::table('inventory_movements')->whereNotNull('issued_to')->update([
            'assignment_status' => 'using',
            'assigned_at' => DB::raw('created_at'),
        ]);
    }

    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('returned_by_user_id');
            $table->dropColumn([
                'assignment_status', 'assigned_at', 'returned_at',
                'return_condition', 'return_note',
            ]);
        });
    }
};
