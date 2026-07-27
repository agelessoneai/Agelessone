<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('site_zones', function (Blueprint $table) {

        $table->id();

        $table->foreignId('work_site_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->string('zone_name');

        $table->string('work_type');

        $table->string('color')->default('#3f6fe0');

        $table->text('description')->nullable();

        $table->timestamps();

    });
}
};
