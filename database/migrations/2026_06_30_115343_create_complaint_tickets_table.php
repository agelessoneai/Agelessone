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
    Schema::create('complaint_tickets', function (Blueprint $table) {
        $table->id();

        $table->foreignId('park_id')->constrained()->cascadeOnDelete();
        $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
        $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

        $table->string('ticket_no')->unique();
        $table->string('item_name');
        $table->string('complaint_title');
        $table->text('complaint_description')->nullable();

        $table->enum('priority', ['low','normal','high','urgent'])->default('normal');

        $table->enum('status', [
            'pending',
            'accepted',
            'rejected',
            'work_started',
            'need_spare_parts',
            'completed'
        ])->default('pending');

        $table->timestamp('accepted_at')->nullable();
        $table->timestamp('work_started_at')->nullable();
        $table->timestamp('completed_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_tickets');
    }
};
