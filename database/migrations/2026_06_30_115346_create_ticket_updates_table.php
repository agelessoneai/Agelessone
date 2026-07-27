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
    Schema::create('ticket_updates', function (Blueprint $table) {
        $table->id();

        $table->foreignId('complaint_ticket_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->string('update_type')->default('progress');
        $table->text('note')->nullable();
        $table->string('spare_parts')->nullable();
        $table->string('image')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_updates');
    }
};
