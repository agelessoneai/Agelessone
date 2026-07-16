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
    Schema::create('workers', function (Blueprint $table) {

        $table->id();

        $table->string('employee_code')->unique();

        $table->string('photo')->nullable();

        $table->string('name');

        $table->string('mobile')->nullable();

        $table->string('aadhaar')->nullable();

        $table->date('dob')->nullable();

        $table->enum('gender',['Male','Female','Other'])->default('Male');

        $table->string('address')->nullable();

        $table->string('trade');

        $table->string('contractor')->nullable();

        $table->decimal('daily_wage',10,2)->default(0);

        $table->decimal('hourly_rate',10,2)->default(0);

        $table->string('blood_group')->nullable();

        $table->string('emergency_contact')->nullable();

        $table->boolean('active')->default(true);

        $table->timestamps();

    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
