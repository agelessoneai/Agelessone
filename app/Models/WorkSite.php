<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'start_date',
        'expected_end_date',
        'status',
        'description',
    ];

    public function security()
    {
        return $this->belongsTo(User::class, 'site_security_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'site_supervisor_id');
    }

    public function siteManager()
    {
        return $this->belongsTo(User::class, 'site_manager_id');
    }

    public function projectManager()
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }
}