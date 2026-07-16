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
    Schema::create('worker_attendances', function (Blueprint $table) {

        $table->id();

        $table->foreignId('worker_id')->constrained()->cascadeOnDelete();

        $table->foreignId('work_site_id')->constrained()->cascadeOnDelete();

        $table->foreignId('site_zone_id')->nullable()->constrained()->nullOnDelete();

        $table->date('attendance_date');

        $table->time('punch_in')->nullable();

        $table->time('punch_out')->nullable();

        $table->integer('working_minutes')->default(0);

        $table->string('punch_in_photo')->nullable();

        $table->string('punch_out_photo')->nullable();

        $table->enum('status',[
            'pending',
            'approved',
            'rejected'
        ])->default('pending');

        $table->foreignId('approved_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_attendances');
    }
};
