<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Workshop extends Model {
    protected $fillable=['name','location','in_charge_user_id','description','status'];
    public function inCharge(): BelongsTo { return $this->belongsTo(User::class,'in_charge_user_id'); }
    public function inventoryItems(): HasMany { return $this->hasMany(WorkshopInventoryItem::class); }
    public function projects(): HasMany { return $this->hasMany(WorkshopProject::class); }
    public function tools(): HasMany { return $this->hasMany(WorkshopTool::class); }
}
