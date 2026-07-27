<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('punch_in_verification_status', 30)->nullable()->after('punch_in_photo');
            $table->decimal('punch_in_match_score', 5, 2)->nullable()->after('punch_in_verification_status');
            $table->text('punch_in_verification_note')->nullable()->after('punch_in_match_score');
            $table->string('punch_out_verification_status', 30)->nullable()->after('punch_out_photo');
            $table->decimal('punch_out_match_score', 5, 2)->nullable()->after('punch_out_verification_status');
            $table->text('punch_out_verification_note')->nullable()->after('punch_out_match_score');
        });

        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type', 60)->default('attendance_photo_alert');
            $table->string('title');
            $table->text('message');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('attendance_id')->nullable()->constrained()->nullOnDelete();
            $table->json('data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'punch_in_verification_status', 'punch_in_match_score', 'punch_in_verification_note',
                'punch_out_verification_status', 'punch_out_match_score', 'punch_out_verification_note',
            ]);
        });
    }
};
