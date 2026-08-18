<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WorkshopInventoryItem extends Model {
    protected $fillable=[
        'workshop_id','item_name','item_code','category',
        'quantity','unit','minimum_stock','location','notes',
        'photo','purchased_from','vendor_contact',
    ];
    protected $casts=['quantity'=>'decimal:2','minimum_stock'=>'decimal:2'];
    public function workshop(): BelongsTo { return $this->belongsTo(Workshop::class); }
}
