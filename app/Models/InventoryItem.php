<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [

        'inventory_category_id',

        'item_name',

        'item_code',

        'brand',

        'model',

        'barcode',

        'qr_code',

        'warehouse',

        'rack',

        'stock',

        'minimum_stock',

        'maximum_stock',

        'unit',

        'purchase_price',

        'selling_price',

        'supplier',

        'image',

        'description',

        'active'

    ];

    protected $casts=[

        'active'=>'boolean',

        'purchase_price'=>'decimal:2',

        'selling_price'=>'decimal:2'

    ];

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class,'inventory_category_id');
    }
}