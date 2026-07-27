<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('work_site_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('asset_name');
            $table->string('asset_code')->unique();
            $table->string('category');

            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('serial_number')->nullable();

            $table->string('operator_name')->nullable();
            $table->string('operator_mobile')->nullable();

            $table->decimal('current_meter', 12, 2)->default(0);
            $table->string('meter_unit')->default('hours');

            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 14, 2)->default(0);

            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();

            $table->enum('status', [
                'available',
                'working',
                'maintenance',
                'breakdown',
                'inactive'
            ])->default('available');

            $table->string('image')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_assets');
    }
};