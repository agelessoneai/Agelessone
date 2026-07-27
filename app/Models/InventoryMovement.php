<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $casts = [
        'assigned_at' => 'datetime',
        'returned_at' => 'datetime',
    ];
    protected $fillable = [
        'inventory_item_id',
        'user_id',
        'work_site_id',
        'type',
        'quantity',
        'previous_stock',
        'new_stock',
        'reference_no',
        'warehouse',
        'used_for',
        'issued_to',
        'assignment_status',
        'assigned_at',
        'returned_at',
        'returned_by_user_id',
        'return_condition',
        'return_note',
        'note',
    ];

    public function workSite()
    {
        return $this->belongsTo(WorkSite::class);
    }

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by_user_id');
    }

    public function assignmentHistories()
    {
        return $this->hasMany(InventoryAssignmentHistory::class)->latest('assigned_at');
    }
}