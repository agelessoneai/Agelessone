<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteAsset extends Model
{
    protected $fillable = [
        'work_site_id',
        'asset_name',
        'asset_code',
        'category',
        'brand',
        'model',
        'registration_number',
        'serial_number',
        'operator_name',
        'operator_mobile',
        'current_meter',
        'meter_unit',
        'purchase_date',
        'purchase_price',
        'last_service_date',
        'next_service_date',
        'status',
        'image',
        'description',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'last_service_date' => 'date',
        'next_service_date' => 'date',
        'purchase_price' => 'decimal:2',
        'current_meter' => 'decimal:2',
    ];

    public function workSite()
    {
        return $this->belongsTo(WorkSite::class);
    }
}