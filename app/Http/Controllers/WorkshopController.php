<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopInventoryItem;
use App\Models\WorkshopProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkshopController extends Controller
{
    private function managers()
    {
        return User::whereIn('role',['admin','workshop_manager'])->where('status','active')->orderBy('name')->get();
    }

    private function primaryWorkshop(): Workshop
    {
        return Workshop::query()->oldest('id')->firstOrCreate(
            [],
            [
                'name' => 'Main Workshop',
                'description' => 'Main workshop operations, inventory and projects.',
                'status' => 'active',
            ]
        );
    }

    public function index()
    {
        $workshop = $this->primaryWorkshop();
        $workshop->load(['inCharge','inventoryItems'=>fn($q)=>$q->orderBy('item_name'),'projects.inCharge']);

        return view('workshops.show',[
            'workshop'=>$workshop,
            'managers'=>$this->managers(),
        ]);
    }

    public function store(Request $request)
    {
        return redirect()->route('workshops.index')
            ->with('info','Only one workshop is used. Update the workshop details from this dashboard.');
    }

    public function show(Workshop $workshop)
    {
        $primary = $this->primaryWorkshop();

        if ($workshop->id !== $primary->id) {
            return redirect()->route('workshops.index');
        }

        return redirect()->route('workshops.index');
    }

    public function update(Request $request, Workshop $workshop)
    {
        $data=$request->validate([
            'name'=>'required|string|max:255','location'=>'nullable|string|max:255',
            'in_charge_user_id'=>'nullable|exists:users,id','description'=>'nullable|string','status'=>'required|in:active,inactive'
        ]);
        $workshop->update($data);
        return back()->with('success','Workshop updated.');
    }

    public function storeInventory(Request $request, Workshop $workshop)
    {
        $data=$request->validate([
            'item_name'=>'required|string|max:255','item_code'=>'nullable|string|max:100','category'=>'nullable|string|max:100',
            'quantity'=>'required|numeric|min:0','unit'=>'required|string|max:40','minimum_stock'=>'nullable|numeric|min:0',
            'location'=>'nullable|string|max:255','notes'=>'nullable|string'
        ]);
        $workshop->inventoryItems()->create($data);
        return back()->with('success','Workshop inventory item added.');
    }

    public function updateInventory(Request $request, Workshop $workshop, WorkshopInventoryItem $item)
    {
        abort_unless($item->workshop_id===$workshop->id,404);
        $data=$request->validate([
            'item_name'=>'required|string|max:255','item_code'=>'nullable|string|max:100','category'=>'nullable|string|max:100',
            'quantity'=>'required|numeric|min:0','unit'=>'required|string|max:40','minimum_stock'=>'nullable|numeric|min:0',
            'location'=>'nullable|string|max:255','notes'=>'nullable|string'
        ]);
        $item->update($data);
        return back()->with('success','Inventory item updated.');
    }

    public function storeProject(Request $request, Workshop $workshop)
    {
        $data=$request->validate($this->projectRules());
        $workshop->projects()->create($data);
        return back()->with('success','Workshop project added.');
    }

    public function project(Workshop $workshop, WorkshopProject $project)
    {
        abort_unless($project->workshop_id===$workshop->id,404);
        $project->load(['inCharge','files']);
        return view('workshops.project',['workshop'=>$workshop,'project'=>$project,'managers'=>$this->managers()]);
    }

    public function updateProject(Request $request, Workshop $workshop, WorkshopProject $project)
    {
        abort_unless($project->workshop_id===$workshop->id,404);
        $project->update($request->validate($this->projectRules()));
        return back()->with('success','Project details updated.');
    }

    public function uploadProjectFile(Request $request, Workshop $workshop, WorkshopProject $project)
    {
        abort_unless($project->workshop_id===$workshop->id,404);
        $data=$request->validate([
            'file_type'=>'required|in:photo,drawing',
            'file'=>'required|file|max:15360|mimes:jpg,jpeg,png,webp,pdf,dwg,dxf'
        ]);
        $file=$request->file('file');
        $path=$file->store('workshop-projects/'.$project->id,'public');
        $project->files()->create([
            'file_type'=>$data['file_type'],'file_path'=>$path,'original_name'=>$file->getClientOriginalName(),'uploaded_by'=>auth()->id()
        ]);
        return back()->with('success',ucfirst($data['file_type']).' uploaded.');
    }

    public function deleteProjectFile(Workshop $workshop, WorkshopProject $project, $file)
    {
        abort_unless($project->workshop_id===$workshop->id,404);
        $record=$project->files()->findOrFail($file);
        Storage::disk('public')->delete($record->file_path);
        $record->delete();
        return back()->with('success','File removed.');
    }

    private function projectRules(): array
    {
        return [
            'title'=>'required|string|max:255','client'=>'nullable|string|max:255','in_charge_user_id'=>'nullable|exists:users,id',
            'worker_count'=>'required|integer|min:0','progress'=>'required|integer|min:0|max:100','start_date'=>'nullable|date',
            'expected_completion_date'=>'nullable|date','status'=>'required|in:planned,in_progress,on_hold,completed',
            'work_details'=>'nullable|string','pending_work'=>'nullable|string'
        ];
    }
}
