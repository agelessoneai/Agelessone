<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();

            $table->string('worker_code')->unique();
            $table->string('name');
            $table->string('photo')->nullable();

            $table->string('mobile')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('id_proof')->nullable();

            $table->string('trade');
            $table->string('skill_level')->nullable();
            $table->string('contractor_name')->nullable();

            $table->decimal('daily_wage', 10, 2)->default(0);
            $table->decimal('hourly_rate', 10, 2)->default(0);
            $table->decimal('overtime_rate', 10, 2)->default(0);

            $table->string('blood_group')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('address')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};