<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'work_site_id',
        'date',
        'punch_in',
        'punch_in_photo',
        'punch_out',
        'punch_out_photo',
        'total_minutes',
        'status',
        'location',
        'punch_out_location',
        'punch_in_verification_status',
        'punch_in_match_score',
        'punch_in_verification_note',
        'punch_out_verification_status',
        'punch_out_match_score',
        'punch_out_verification_note'
    ];

    protected $casts = [
        'date' => 'date',
        'punch_in' => 'datetime',
        'punch_out' => 'datetime',
        'punch_in_match_score' => 'decimal:2',
        'punch_out_match_score' => 'decimal:2',
    ];

    public function workSite()
    {
        return $this->belongsTo(WorkSite::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}