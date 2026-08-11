<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'name',
        'components',
        'purchase_date',
        'warranty',
        'warranty_ending_date',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_ending_date' => 'date',
    ];
}
