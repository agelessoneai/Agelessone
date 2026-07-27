<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WorkshopProjectFile extends Model {
    protected $fillable=['workshop_project_id','file_type','file_path','original_name','uploaded_by'];
    public function project(): BelongsTo { return $this->belongsTo(WorkshopProject::class,'workshop_project_id'); }
}
