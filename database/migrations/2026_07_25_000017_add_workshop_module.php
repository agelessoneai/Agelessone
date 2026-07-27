<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','sales','project_manager','project_head','project_coordinator','site_manager','site_supervisor','supervisor','security','office_staff','inventory_manager','workshop_manager') NOT NULL DEFAULT 'office_staff'");

        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->foreignId('in_charge_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('workshop_inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->string('item_code')->nullable();
            $table->string('category')->nullable();
            $table->decimal('quantity', 12, 2)->default(0);
            $table->string('unit')->default('Nos');
            $table->decimal('minimum_stock', 12, 2)->default(0);
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('workshop_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('client')->nullable();
            $table->foreignId('in_charge_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('worker_count')->default(0);
            $table->unsignedTinyInteger('progress')->default(0);
            $table->date('start_date')->nullable();
            $table->date('expected_completion_date')->nullable();
            $table->enum('status', ['planned','in_progress','on_hold','completed'])->default('planned');
            $table->text('work_details')->nullable();
            $table->text('pending_work')->nullable();
            $table->timestamps();
        });

        Schema::create('workshop_project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_project_id')->constrained()->cascadeOnDelete();
            $table->enum('file_type', ['photo','drawing']);
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshop_project_files');
        Schema::dropIfExists('workshop_projects');
        Schema::dropIfExists('workshop_inventory_items');
        Schema::dropIfExists('workshops');
        DB::table('users')->where('role', 'workshop_manager')->update(['role' => 'office_staff']);
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','sales','project_manager','project_head','project_coordinator','site_manager','site_supervisor','supervisor','security','office_staff','inventory_manager') NOT NULL DEFAULT 'office_staff'");
    }
};
