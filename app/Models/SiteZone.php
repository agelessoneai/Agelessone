<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteZone extends Model
{
    protected $fillable = [
        'work_site_id',
        'zone_name',
        'work_type',
        'supervisor_id',
        'status',
        'progress',
        'start_date',
        'start_time',
        'expected_end_date',
        'end_time',
        'color',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'expected_end_date' => 'date',
            'progress' => 'integer',
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(
            WorkSite::class,
            'work_site_id'
        );
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'supervisor_id'
        );
    }

    public function workerAssignments(): HasMany
    {
        return $this->hasMany(
            WorkerZoneAssignment::class,
            'site_zone_id'
        );
    }
}