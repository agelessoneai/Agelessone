<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerWorkSession extends Model
{
    protected $fillable = [
        'worker_attendance_id','worker_id','work_site_id','site_zone_id',
        'work_name','started_at','ended_at','changed_by','notes',
    ];

    protected $casts = ['started_at' => 'datetime', 'ended_at' => 'datetime'];

    public function attendance() { return $this->belongsTo(WorkerAttendance::class, 'worker_attendance_id'); }
    public function worker() { return $this->belongsTo(Worker::class); }
    public function workSite() { return $this->belongsTo(WorkSite::class); }
    public function siteZone() { return $this->belongsTo(SiteZone::class); }
    public function changedBy() { return $this->belongsTo(User::class, 'changed_by'); }

    public function getMinutesAttribute(): int
    {
        return (int) $this->started_at->diffInMinutes($this->ended_at ?? now());
    }
}
