<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerAttendance extends Model
{
    protected $fillable = [
        'worker_id','work_site_id','site_zone_id','supervisor_id','work_description','recorded_by','attendance_date',
        'punch_in','punch_out','working_minutes','punch_in_photo','punch_out_photo',
        'status','approved_by','approved_at','rejection_reason','remarks',
    ];

    protected $casts = ['attendance_date' => 'date', 'approved_at' => 'datetime'];

    public function worker() { return $this->belongsTo(Worker::class); }
    public function workSite() { return $this->belongsTo(WorkSite::class); }
    public function siteZone() { return $this->belongsTo(SiteZone::class); }
    public function supervisor() { return $this->belongsTo(User::class, 'supervisor_id'); }
    public function recordedBy() { return $this->belongsTo(User::class, 'recorded_by'); }
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); }
    public function workSessions() { return $this->hasMany(WorkerWorkSession::class)->orderBy('started_at'); }
}
