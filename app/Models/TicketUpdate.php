<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketUpdate extends Model
{
    protected $fillable = [
        'complaint_ticket_id',
        'user_id',
        'update_type',
        'note',
        'spare_parts',
        'image',
    ];

    public function ticket()
    {
        return $this->belongsTo(ComplaintTicket::class, 'complaint_ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}