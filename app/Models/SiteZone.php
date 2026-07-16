<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteZone extends Model
{
    protected $fillable=[
'work_site_id',
'zone_name',
'work_type',
'color',
'description'
];

public function site()
{
    return $this->belongsTo(WorkSite::class,'work_site_id');
}
}
