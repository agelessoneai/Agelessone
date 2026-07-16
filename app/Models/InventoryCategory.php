<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    protected $fillable = [
        'name',
        'code',
        'image',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(InventoryItem::class);
    }
}