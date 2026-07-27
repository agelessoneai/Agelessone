<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_code','customer_name','company_name','phone','alternate_phone','email','location',
        'call_type','lead_source','temperature','status','enquiry_for','enquiry_details','call_at',
        'next_follow_up_at','proposal_given','proposal_date','proposal_amount','site_visit_done',
        'site_visit_date','is_customer','converted_at','notes','assigned_to','created_by','updated_by',
    ];

    protected function casts(): array
    {
        return [
            'call_at' => 'datetime',
            'next_follow_up_at' => 'datetime',
            'proposal_given' => 'boolean',
            'proposal_date' => 'date',
            'proposal_amount' => 'decimal:2',
            'site_visit_done' => 'boolean',
            'site_visit_date' => 'date',
            'is_customer' => 'boolean',
            'converted_at' => 'date',
        ];
    }

    public function assignedUser(): BelongsTo { return $this->belongsTo(User::class, 'assigned_to'); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
}
