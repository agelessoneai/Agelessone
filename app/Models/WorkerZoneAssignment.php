<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerZoneAssignment extends Model
{
    protected $fillable = [
        'worker_id',
        'work_site_id',
        'site_zone_id',
        'supervisor_id',
        'assigned_date',
        'status',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'assigned_date' => 'date',
        ];
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function workSite(): BelongsTo
    {
        return $this->belongsTo(WorkSite::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(SiteZone::class, 'site_zone_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
