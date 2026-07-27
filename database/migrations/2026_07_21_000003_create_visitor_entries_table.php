<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_site_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('mobile', 30)->nullable();
            $table->string('company')->nullable();
            $table->string('purpose')->nullable();
            $table->string('photo');
            $table->timestamp('check_in_at');
            $table->timestamp('check_out_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_entries');
    }
};
