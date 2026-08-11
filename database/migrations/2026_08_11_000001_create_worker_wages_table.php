<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add standard_hours to workers table
        Schema::table('workers', function (Blueprint $table) {
            $table->unsignedTinyInteger('standard_hours')->default(8)->after('overtime_rate');
        });

        // Create worker_wages table
        Schema::create('worker_wages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained()->cascadeOnDelete();
            $table->foreignId('work_site_id')->constrained()->cascadeOnDelete();
            $table->foreignId('worker_attendance_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date');
            $table->decimal('hours_worked', 5, 2)->default(0);
            $table->decimal('overtime_hours', 5, 2)->default(0);
            $table->decimal('base_wage', 10, 2)->default(0);   // snapshot of daily_wage
            $table->decimal('overtime_rate', 10, 2)->default(0); // snapshot of overtime_rate
            $table->decimal('overtime_pay', 10, 2)->default(0);
            $table->decimal('total_wage', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_wages');
        Schema::table('workers', function (Blueprint $table) {
            $table->dropColumn('standard_hours');
        });
    }
};
