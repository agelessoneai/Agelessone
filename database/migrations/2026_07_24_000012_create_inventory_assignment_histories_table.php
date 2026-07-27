<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_assignment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_movement_id')->constrained()->cascadeOnDelete();
            $table->string('assigned_to');
            $table->string('used_for')->nullable();
            $table->foreignId('assigned_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at');
            $table->foreignId('returned_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('returned_at')->nullable();
            $table->string('return_condition', 30)->nullable();
            $table->text('return_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_assignment_histories');
    }
};
