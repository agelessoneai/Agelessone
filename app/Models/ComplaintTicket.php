<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintTicket extends Model
{
    protected $fillable = [
        'ticket_no',
        'park_id',
        'assigned_to',
        'created_by',
        'item_name',
        'complaint_title',
        'complaint_description',
        'priority',
        'status',
        'accepted_at',
        'work_started_at',
        'completed_at',
        'live_latitude',
        'live_longitude',
        'live_location_updated_at',
        'travel_status',
    ];

    public function park()
    {
        return $this->belongsTo(Park::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updates()
    {
        return $this->hasMany(TicketUpdate::class);
    }
}