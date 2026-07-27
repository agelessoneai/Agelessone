<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class WorkshopProject extends Model {
    protected $fillable=['workshop_id','title','client','in_charge_user_id','worker_count','progress','start_date','expected_completion_date','status','work_details','pending_work'];
    protected $casts=['start_date'=>'date','expected_completion_date'=>'date'];
    public function workshop(): BelongsTo { return $this->belongsTo(Workshop::class); }
    public function inCharge(): BelongsTo { return $this->belongsTo(User::class,'in_charge_user_id'); }
    public function files(): HasMany { return $this->hasMany(WorkshopProjectFile::class); }
}
