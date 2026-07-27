<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_zone_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('worker_id')
                ->constrained('workers')
                ->cascadeOnDelete();

            $table->foreignId('work_site_id')
                ->constrained('work_sites')
                ->cascadeOnDelete();

            $table->foreignId('site_zone_id')
                ->constrained('site_zones')
                ->cascadeOnDelete();

            $table->foreignId('supervisor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('assigned_date');

            $table->string('status')->default('active');

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->unique(
                ['worker_id', 'site_zone_id'],
                'unique_worker_zone_assignment'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_zone_assignments');
    }
};