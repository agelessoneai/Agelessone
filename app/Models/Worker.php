<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public const ROLES = [
        'worker' => 'Worker',
        'helper' => 'Helper',
        'supervisor' => 'Supervisor',
        'security' => 'Security',
    ];
    protected $fillable = [
        'work_site_id',
        'worker_code',
        'name',
        'photo',
        'mobile',
        'aadhaar_number',
        'id_proof',
        'trade',
        'role',
        'skill_level',
        'contractor_name',
        'daily_wage',
        'hourly_rate',
        'overtime_rate',
        'blood_group',
        'emergency_contact',
        'address',
        'active',
        'standard_hours',
    ];

    public static function roles(): array
    {
        return self::ROLES;
    }

    public function workSite()
    {
        return $this->belongsTo(WorkSite::class);
    }

    protected $casts = [
        'daily_wage' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'overtime_rate' => 'decimal:2',
        'active' => 'boolean',
    ];
}