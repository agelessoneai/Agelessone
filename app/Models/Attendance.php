<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'punch_in',
        'punch_out',
        'total_minutes',
        'status',
        'location',
        'punch_out_location'
    ];

    protected $casts = [
        'date' => 'date',
        'punch_in' => 'datetime',
        'punch_out' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}