<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'location',
    ];

    public function tickets()
    {
        return $this->hasMany(ComplaintTicket::class);
    }
}