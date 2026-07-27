<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','sales','project_manager','project_head','project_coordinator','site_manager','site_supervisor','supervisor','security','office_staff') NOT NULL DEFAULT 'office_staff'");
        }

        Schema::create('sales_leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_code')->unique();
            $table->string('customer_name');
            $table->string('company_name')->nullable();
            $table->string('phone', 30);
            $table->string('alternate_phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->enum('call_type', ['incoming', 'outgoing', 'walk_in', 'other'])->default('incoming');
            $table->string('lead_source')->nullable();
            $table->enum('temperature', ['hot', 'warm', 'cold'])->default('warm');
            $table->enum('status', ['new', 'contacted', 'qualified', 'proposal_sent', 'site_visit', 'negotiation', 'won', 'lost', 'follow_up'])->default('new');
            $table->string('enquiry_for')->nullable();
            $table->text('enquiry_details')->nullable();
            $table->dateTime('call_at')->nullable();
            $table->dateTime('next_follow_up_at')->nullable();
            $table->boolean('proposal_given')->default(false);
            $table->date('proposal_date')->nullable();
            $table->decimal('proposal_amount', 14, 2)->nullable();
            $table->boolean('site_visit_done')->default(false);
            $table->date('site_visit_date')->nullable();
            $table->boolean('is_customer')->default(false);
            $table->date('converted_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'temperature']);
            $table->index('next_follow_up_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_leads');
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','project_manager','project_head','project_coordinator','site_manager','site_supervisor','supervisor','security','office_staff') NOT NULL DEFAULT 'office_staff'");
        }
    }
};
