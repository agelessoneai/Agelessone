<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DailyWorkUpdate;
use App\Models\SiteZone;
use App\Models\User;
use App\Models\Worker;
use App\Models\WorkerAttendance;
use App\Models\WorkerWorkSession;
use App\Models\WorkSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiteSupervisorController extends Controller
{
    private function siteFor(Request $request): ?WorkSite
    {
        abort_unless($request->user()?->role === 'site_supervisor', 403);
        return WorkSite::where('site_supervisor_id', $request->user()->id)->first();
    }

    public function dashboard(Request $request)
    {
        $site = $this->siteFor($request);
        if (!$site) return view('supervisor.no-site');

        $site->load(['security','projectManager','projectCoordinator','siteManager','zones.supervisor','workers']);
        $attendance = Attendance::where('user_id', $request->user()->id)->whereDate('date', today())->first();
        $pending = WorkerAttendance::with(['worker','recordedBy','workSessions.siteZone'])->where('work_site_id', $site->id)->where('status', 'pending')->latest('attendance_date')->get();
        $today = WorkerAttendance::with(['worker','workSessions.siteZone'])->where('work_site_id', $site->id)->whereDate('attendance_date', today())->get()->keyBy('worker_id');
        $assignableSupervisors = User::whereIn('role', ['site_supervisor','supervisor'])->where('status', 'active')->orderBy('name')->get();
        $dailyUpdates = DailyWorkUpdate::with('user')->where('work_site_id', $site->id)->latest()->take(20)->get();

        return view('supervisor.dashboard', compact('site','attendance','pending','today','assignableSupervisors','dailyUpdates'));
    }

    public function storeWorker(Request $request)
    {
        $site = $this->siteFor($request);
        abort_unless($site, 403);
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'mobile' => ['nullable','string','max:30'],
            'trade' => ['required','string','max:100'],
            'photo' => ['required','image','max:5120'],
        ]);
        $data['photo'] = $request->file('photo')->store('workers/photos', 'public');
        $data['work_site_id'] = $site->id;
        $data['worker_code'] = $this->nextWorkerCode($site);
        $data['role'] = 'worker';
        $data['active'] = true;
        Worker::create($data);
        return back()->with('success', 'Worker added successfully.');
    }

    public function punchInWorker(Request $request, Worker $worker)
    {
        $site = $this->siteFor($request);
        abort_unless($site && $worker->work_site_id === $site->id && $worker->active, 403);
        $data = $request->validate([
            'photo' => ['required','image','max:5120'],
            'site_zone_id' => ['nullable','exists:site_zones,id'],
            'work_name' => ['required','string','max:255'],
            'notes' => ['nullable','string','max:500'],
        ]);
        if (!empty($data['site_zone_id'])) abort_unless(SiteZone::where('id',$data['site_zone_id'])->where('work_site_id',$site->id)->exists(), 422);
        $exists = WorkerAttendance::where('worker_id',$worker->id)->whereDate('attendance_date',today())->whereNotNull('punch_in')->exists();
        if ($exists) return back()->withErrors(['attendance' => $worker->name.' has already started today.']);
        $photo = $request->file('photo')->store('workers/attendance', 'public');
        $record = WorkerAttendance::create([
            'worker_id'=>$worker->id,'work_site_id'=>$site->id,'site_zone_id'=>$data['site_zone_id'] ?? null,
            'supervisor_id'=>$request->user()->id,'work_description'=>$data['work_name'],'recorded_by'=>$request->user()->id,
            'attendance_date'=>today(),'punch_in'=>now()->format('H:i:s'),'punch_in_photo'=>$photo,'status'=>'pending',
            'remarks'=>$data['notes'] ?? null,
        ]);
        WorkerWorkSession::create([
            'worker_attendance_id'=>$record->id,'worker_id'=>$worker->id,'work_site_id'=>$site->id,
            'site_zone_id'=>$data['site_zone_id'] ?? null,'work_name'=>$data['work_name'],'started_at'=>now(),
            'changed_by'=>$request->user()->id,'notes'=>$data['notes'] ?? null,
        ]);
        return back()->with('success', $worker->name.' started work.');
    }

    public function changeWorkerWork(Request $request, WorkerAttendance $workerAttendance)
    {
        $site = $this->siteFor($request);
        abort_unless($site && $workerAttendance->work_site_id === $site->id && !$workerAttendance->punch_out, 403);
        $data = $request->validate([
            'site_zone_id' => ['nullable','exists:site_zones,id'],
            'work_name' => ['required','string','max:255'],
            'notes' => ['nullable','string','max:500'],
        ]);
        if (!empty($data['site_zone_id'])) abort_unless(SiteZone::where('id',$data['site_zone_id'])->where('work_site_id',$site->id)->exists(), 422);
        $workerAttendance->workSessions()->whereNull('ended_at')->update(['ended_at'=>now()]);
        WorkerWorkSession::create([
            'worker_attendance_id'=>$workerAttendance->id,'worker_id'=>$workerAttendance->worker_id,'work_site_id'=>$site->id,
            'site_zone_id'=>$data['site_zone_id'] ?? null,'work_name'=>$data['work_name'],'started_at'=>now(),
            'changed_by'=>$request->user()->id,'notes'=>$data['notes'] ?? null,
        ]);
        $workerAttendance->update(['site_zone_id'=>$data['site_zone_id'] ?? null,'work_description'=>$data['work_name']]);
        return back()->with('success', 'Worker moved to the new work.');
    }

    public function punchOutWorker(Request $request, WorkerAttendance $workerAttendance)
    {
        $site = $this->siteFor($request);
        abort_unless($site && $workerAttendance->work_site_id === $site->id && !$workerAttendance->punch_out, 403);
        $request->validate(['photo'=>['required','image','max:5120']]);
        $photo = $request->file('photo')->store('workers/attendance', 'public');
        $out = now();
        $workerAttendance->workSessions()->whereNull('ended_at')->update(['ended_at'=>$out]);
        $in = Carbon::parse($workerAttendance->attendance_date->format('Y-m-d').' '.$workerAttendance->punch_in);
        $workerAttendance->update([
            'punch_out'=>$out->format('H:i:s'),'punch_out_photo'=>$photo,
            'working_minutes'=>$in->diffInMinutes($out),'status'=>'pending',
        ]);
        return back()->with('success', $workerAttendance->worker->name.' ended work.');
    }

    private function nextWorkerCode(WorkSite $site): string
    {
        $number = Worker::where('work_site_id',$site->id)->count()+1;
        do { $code='W-'.str_pad((string)$number++,4,'0',STR_PAD_LEFT); }
        while (Worker::where('work_site_id',$site->id)->where('worker_code',$code)->exists());
        return $code;
    }

    public function storeWorkCase(Request $request)
    {
        $site = $this->siteFor($request); abort_unless($site,403);
        $data=$request->validate(['zone_name'=>['required','string','max:255'],'work_type'=>['required','string','max:255'],'supervisor_id'=>['nullable','exists:users,id'],'status'=>['required','in:not_started,in_progress,on_hold,completed'],'progress'=>['required','integer','min:0','max:100'],'start_date'=>['nullable','date'],'expected_end_date'=>['nullable','date','after_or_equal:start_date'],'description'=>['nullable','string']]);
        $data['work_site_id']=$site->id; $data['color']='#3f6fe0'; SiteZone::create($data);
        return back()->with('success','Work case added successfully.');
    }

    public function updateWorkCase(Request $request, SiteZone $siteZone)
    {
        $site=$this->siteFor($request); abort_unless($site&&$siteZone->work_site_id===$site->id,403);
        $siteZone->update($request->validate(['supervisor_id'=>['nullable','exists:users,id'],'status'=>['required','in:not_started,in_progress,on_hold,completed'],'progress'=>['required','integer','min:0','max:100']]));
        return back()->with('success','Work case updated.');
    }

    public function approveAttendance(Request $request, WorkerAttendance $workerAttendance)
    {
        $site=$this->siteFor($request); abort_unless($site&&$workerAttendance->work_site_id===$site->id,403);
        $workerAttendance->update(['status'=>'approved','approved_by'=>$request->user()->id,'approved_at'=>now(),'rejection_reason'=>null]);
        return back()->with('success','Attendance approved.');
    }

    public function rejectAttendance(Request $request, WorkerAttendance $workerAttendance)
    {
        $site=$this->siteFor($request); abort_unless($site&&$workerAttendance->work_site_id===$site->id,403);
        $data=$request->validate(['rejection_reason'=>['required','string','max:500']]);
        $workerAttendance->update(['status'=>'rejected','approved_by'=>$request->user()->id,'approved_at'=>now(),'rejection_reason'=>$data['rejection_reason']]);
        return back()->with('success','Attendance rejected.');
    }

    /** Store a daily work update (photo + optional note) from the supervisor dashboard. */
    public function storeDailyUpdate(Request $request)
    {
        $site = $this->siteFor($request);
        abort_unless($site, 403);

        $validated = $request->validate([
            'photo' => ['nullable', 'image', 'max:10240'],
            'note'  => ['nullable', 'string', 'max:5000'],
            'date'  => ['required', 'date'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('daily-work-updates', 'public');
        }

        DailyWorkUpdate::create([
            'work_site_id' => $site->id,
            'user_id'      => Auth::id(),
            'photo'        => $photoPath,
            'note'         => $validated['note'] ?? null,
            'date'         => $validated['date'],
        ]);

        return back()->with('success', 'Daily work update posted successfully.');
    }
}
