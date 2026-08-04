<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkSite extends Model
{
    protected $fillable = [
        'site_name',
        'client_name',
        'location',
        'site_security_id',
        'site_supervisor_id',
        'site_manager_id',
        'project_manager_id',
        'project_coordinator_id',
        'start_date',
        'expected_end_date',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'expected_end_date' => 'date',
        ];
    }

    public function security(): BelongsTo
    {
        return $this->belongsTo(User::class, 'site_security_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'site_supervisor_id');
    }

    public function siteManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'site_manager_id');
    }

    public function projectManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function projectCoordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_coordinator_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function workerAttendances(): HasMany
    {
        return $this->hasMany(WorkerAttendance::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function zones(): HasMany
    {
        return $this->hasMany(SiteZone::class, 'work_site_id');
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(VisitorEntry::class);
    }

    public function workerAssignments(): HasMany
    {
        return $this->hasMany(
            WorkerZoneAssignment::class,
            'work_site_id'
        );
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(SiteTicket::class);
    }

    public function dailyWorkUpdates(): HasMany
    {
        return $this->hasMany(DailyWorkUpdate::class);
    }
}
