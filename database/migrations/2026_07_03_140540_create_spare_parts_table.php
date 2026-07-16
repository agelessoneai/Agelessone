<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('spare_parts', function (Blueprint $table) {
        $table->id();
        $table->string('part_name');
        $table->string('part_code')->nullable();
        $table->string('category')->nullable();
        $table->integer('stock')->default(0);
        $table->integer('minimum_stock')->default(0);
        $table->decimal('unit_price', 10, 2)->default(0);
        $table->string('unit')->default('pcs');
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spare_parts');
    }
};
