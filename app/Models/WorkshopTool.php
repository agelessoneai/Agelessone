<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopTool extends Model
{
    protected $fillable = [
        'workshop_id',
        'tool_name',
        'condition',
        'quality',
        'last_used_by',
        'photo'
    ];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }
}
