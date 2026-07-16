<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_sites', function (Blueprint $table) {
            $table->id();

            $table->string('site_name');
            $table->string('client_name')->nullable();
            $table->string('location')->nullable();

            $table->foreignId('site_security_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('site_supervisor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('site_manager_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('project_manager_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('start_date')->nullable();
            $table->date('expected_end_date')->nullable();

            $table->enum('status', [
                'planning',
                'active',
                'on_hold',
                'completed'
            ])->default('active');

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_sites');
    }
};