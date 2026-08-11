<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerWage extends Model
{
    protected $fillable = [
        'worker_id',
        'work_site_id',
        'worker_attendance_id',
        'date',
        'hours_worked',
        'overtime_hours',
        'base_wage',
        'overtime_rate',
        'overtime_pay',
        'total_wage',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'date'          => 'date',
        'hours_worked'  => 'decimal:2',
        'overtime_hours'=> 'decimal:2',
        'base_wage'     => 'decimal:2',
        'overtime_rate' => 'decimal:2',
        'overtime_pay'  => 'decimal:2',
        'total_wage'    => 'decimal:2',
    ];

    public function worker()     { return $this->belongsTo(Worker::class); }
    public function workSite()   { return $this->belongsTo(WorkSite::class); }
    public function attendance() { return $this->belongsTo(WorkerAttendance::class, 'worker_attendance_id'); }
    public function recordedBy() { return $this->belongsTo(User::class, 'recorded_by'); }
}
