<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('inventory_category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('item_name');

            $table->string('item_code')->unique();

            $table->string('brand')->nullable();

            $table->string('model')->nullable();

            $table->string('barcode')->nullable();

            $table->string('qr_code')->nullable();

            $table->string('warehouse')->default('Main Warehouse');

            $table->string('rack')->nullable();

            $table->integer('stock')->default(0);

            $table->integer('minimum_stock')->default(5);

            $table->integer('maximum_stock')->default(100);

            $table->string('unit')->default('PCS');

            $table->decimal('purchase_price',12,2)->default(0);

            $table->decimal('selling_price',12,2)->default(0);

            $table->string('supplier')->nullable();

            $table->string('image')->nullable();

            $table->text('description')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};