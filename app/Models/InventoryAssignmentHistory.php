<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryAssignmentHistory extends Model
{
    protected $fillable = [
        'inventory_movement_id', 'assigned_to', 'used_for',
        'assigned_by_user_id', 'assigned_at', 'returned_by_user_id',
        'returned_at', 'return_condition', 'return_note',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function movement() { return $this->belongsTo(InventoryMovement::class, 'inventory_movement_id'); }
    public function assignedBy() { return $this->belongsTo(User::class, 'assigned_by_user_id'); }
    public function returnedBy() { return $this->belongsTo(User::class, 'returned_by_user_id'); }
}
