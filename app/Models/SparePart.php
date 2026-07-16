<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
 protected $fillable = [
    'part_name',
    'part_code',
    'category',
    'stock',
    'minimum_stock',
    'unit_price',
    'unit',
    'description',
    'image',
    'detected_model',
];
}
