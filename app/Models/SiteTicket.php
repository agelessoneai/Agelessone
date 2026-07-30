<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteTicket extends Model
{
    protected $fillable = [
        'work_site_id', 'site_zone_id', 'assigned_to', 'created_by', 'work', 'note', 'status',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(WorkSite::class, 'work_site_id');
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(SiteZone::class, 'site_zone_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
