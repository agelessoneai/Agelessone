<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorEntry extends Model
{
    protected $fillable = [
        'work_site_id','recorded_by','name','mobile','purpose','company',
        'photo','check_in_at','check_out_at','remarks',
    ];

    protected $casts = [
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
    ];

    public function workSite() { return $this->belongsTo(WorkSite::class); }
    public function recordedBy() { return $this->belongsTo(User::class, 'recorded_by'); }
}
