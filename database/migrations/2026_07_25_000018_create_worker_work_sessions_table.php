<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('worker_work_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_attendance_id')->constrained('worker_attendances')->cascadeOnDelete();
            $table->foreignId('worker_id')->constrained()->cascadeOnDelete();
            $table->foreignId('work_site_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_zone_id')->nullable()->constrained()->nullOnDelete();
            $table->string('work_name');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['worker_id', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_work_sessions');
    }
};
