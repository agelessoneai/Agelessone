<?php

namespace App\Http\Controllers;

use App\Models\SalesLead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SalesLeadController extends Controller
{
    private array $statuses = [
        'new'=>'New','contacted'=>'Contacted','qualified'=>'Qualified','proposal_sent'=>'Proposal Sent',
        'site_visit'=>'Site Visit','negotiation'=>'Negotiation','won'=>'Won / Customer','lost'=>'Lost','follow_up'=>'Follow Up'
    ];
    private array $sources = ['Phone Call','Website','WhatsApp','Facebook','Instagram','Referral','Walk-in','Exhibition','Other'];

    public function dashboard(Request $request)
    {
        $query = $this->visibleQuery($request);
        $today = now()->startOfDay();
        $stats = [
            'total' => (clone $query)->count(),
            'incoming' => (clone $query)->where('call_type','incoming')->count(),
            'outgoing' => (clone $query)->where('call_type','outgoing')->count(),
            'hot' => (clone $query)->where('temperature','hot')->count(),
            'won' => (clone $query)->where('status','won')->count(),
            'followups' => (clone $query)->whereNotNull('next_follow_up_at')->whereDate('next_follow_up_at','<=',today())->whereNotIn('status',['won','lost'])->count(),
        ];
        $recent = (clone $query)->with('assignedUser')->latest()->limit(10)->get();
        $followUps = (clone $query)->with('assignedUser')->whereNotNull('next_follow_up_at')->whereDate('next_follow_up_at','<=',today()->addDays(7))->whereNotIn('status',['won','lost'])->orderBy('next_follow_up_at')->limit(10)->get();
        return view('sales.dashboard', compact('stats','recent','followUps'));
    }

    public function index(Request $request)
    {
        $leads = $this->filteredQuery($request)->with('assignedUser')->latest('call_at')->latest()->paginate(20)->withQueryString();
        return view('sales.index', ['leads'=>$leads,'statuses'=>$this->statuses,'sources'=>$this->sources]);
    }

    public function create()
    {
        return view('sales.create', ['lead'=>new SalesLead(),'statuses'=>$this->statuses,'sources'=>$this->sources,'salesUsers'=>$this->salesUsers()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['lead_code'] = $this->nextCode();
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        if (auth()->user()->role === 'sales') $data['assigned_to'] = auth()->id();
        $this->normalizeBooleans($request, $data);
        $lead = SalesLead::create($data);
        return redirect()->route('sales.leads.show',$lead)->with('success','Sales enquiry created successfully.');
    }

    public function show(Request $request, SalesLead $lead)
    {
        $this->authorizeLead($request,$lead);
        $lead->load(['assignedUser','creator']);
        return view('sales.show', compact('lead'));
    }

    public function edit(Request $request, SalesLead $lead)
    {
        $this->authorizeLead($request,$lead);
        return view('sales.edit', ['lead'=>$lead,'statuses'=>$this->statuses,'sources'=>$this->sources,'salesUsers'=>$this->salesUsers()]);
    }

    public function update(Request $request, SalesLead $lead)
    {
        $this->authorizeLead($request,$lead);
        $data = $this->validated($request);
        $data['updated_by'] = auth()->id();
        if (auth()->user()->role === 'sales') $data['assigned_to'] = auth()->id();
        $this->normalizeBooleans($request, $data);
        if (($data['status'] ?? null) === 'won') { $data['is_customer'] = true; $data['converted_at'] ??= today(); }
        $lead->update($data);
        return redirect()->route('sales.leads.show',$lead)->with('success','Sales enquiry updated successfully.');
    }

    public function import(Request $request)
    {
        $request->validate(['file'=>['required','file','mimes:csv,txt','max:5120']]);
        $handle = fopen($request->file('file')->getRealPath(),'r');
        $headers = array_map(fn($v)=>Str::snake(trim($v)), fgetcsv($handle) ?: []);
        $count=0;
        DB::transaction(function () use ($handle,$headers,&$count) {
            while (($row=fgetcsv($handle)) !== false) {
                if (count($row) !== count($headers)) continue;
                $r=array_combine($headers,$row);
                if (empty($r['customer_name']) || empty($r['phone'])) continue;
                SalesLead::create([
                    'lead_code'=>$this->nextCode(),'customer_name'=>$r['customer_name'],'company_name'=>$r['company_name']??null,
                    'phone'=>$r['phone'],'email'=>$r['email']??null,'location'=>$r['location']??null,
                    'call_type'=>in_array($r['call_type']??'', ['incoming','outgoing','walk_in','other'])?$r['call_type']:'incoming',
                    'lead_source'=>$r['lead_source']??null,'temperature'=>in_array($r['temperature']??'', ['hot','warm','cold'])?$r['temperature']:'warm',
                    'status'=>array_key_exists($r['status']??'', $this->statuses)?$r['status']:'new','enquiry_for'=>$r['enquiry_for']??null,
                    'enquiry_details'=>$r['enquiry_details']??null,'notes'=>$r['notes']??null,
                    'assigned_to'=>auth()->user()->role==='sales'?auth()->id():null,'created_by'=>auth()->id(),'updated_by'=>auth()->id(),
                ]); $count++;
            }
        });
        fclose($handle);
        return back()->with('success',"{$count} enquiries imported successfully.");
    }

    public function exportExcel(Request $request)
    {
        $leads=$this->filteredQuery($request)->get();
        $html='<table border="1"><tr><th>Lead Code</th><th>Customer</th><th>Company</th><th>Phone</th><th>Email</th><th>Location</th><th>Call Type</th><th>Source</th><th>Temperature</th><th>Status</th><th>Enquiry For</th><th>Follow Up</th><th>Proposal</th><th>Site Visit</th><th>Customer</th><th>Notes</th></tr>';
        foreach($leads as $l){$cells=[$l->lead_code,$l->customer_name,$l->company_name,$l->phone,$l->email,$l->location,$l->call_type,$l->lead_source,$l->temperature,$l->status,$l->enquiry_for,optional($l->next_follow_up_at)->format('Y-m-d H:i'),$l->proposal_given?'Yes':'No',$l->site_visit_done?'Yes':'No',$l->is_customer?'Yes':'No',$l->notes];$html.='<tr>'.implode('',array_map(fn($v)=>'<td>'.e($v).'</td>',$cells)).'</tr>';}
        $html.='</table>';
        return response("<html><meta charset='UTF-8'><body>{$html}</body></html>",200,['Content-Type'=>'application/vnd.ms-excel; charset=UTF-8','Content-Disposition'=>'attachment; filename="sales-enquiries-'.now()->format('Ymd-His').'.xls"']);
    }

    public function exportPdf(Request $request)
    {
        $leads=$this->filteredQuery($request)->limit(500)->get();
        return view('sales.pdf',compact('leads'));
    }

    private function visibleQuery(Request $request)
    {
        return SalesLead::query()->when($request->user()->role==='sales',fn($q)=>$q->where('assigned_to',$request->user()->id));
    }
    private function filteredQuery(Request $request)
    {
        return $this->visibleQuery($request)
            ->when($request->search,fn($q,$s)=>$q->where(fn($x)=>$x->where('customer_name','like',"%{$s}%")->orWhere('company_name','like',"%{$s}%")->orWhere('phone','like',"%{$s}%")->orWhere('lead_code','like',"%{$s}%")))
            ->when($request->status,fn($q,$v)=>$q->where('status',$v))->when($request->temperature,fn($q,$v)=>$q->where('temperature',$v))
            ->when($request->lead_source,fn($q,$v)=>$q->where('lead_source',$v))->when($request->call_type,fn($q,$v)=>$q->where('call_type',$v));
    }
    private function validated(Request $request): array
    {
        return $request->validate([
            'customer_name'=>['required','string','max:255'],'company_name'=>['nullable','string','max:255'],'phone'=>['required','string','max:30'],
            'alternate_phone'=>['nullable','string','max:30'],'email'=>['nullable','email','max:255'],'location'=>['nullable','string','max:255'],
            'call_type'=>['required',Rule::in(['incoming','outgoing','walk_in','other'])],'lead_source'=>['nullable','string','max:100'],
            'temperature'=>['required',Rule::in(['hot','warm','cold'])],'status'=>['required',Rule::in(array_keys($this->statuses))],
            'enquiry_for'=>['nullable','string','max:255'],'enquiry_details'=>['nullable','string'],'call_at'=>['nullable','date'],'next_follow_up_at'=>['nullable','date'],
            'proposal_date'=>['nullable','date'],'proposal_amount'=>['nullable','numeric','min:0'],'site_visit_date'=>['nullable','date'],'converted_at'=>['nullable','date'],
            'notes'=>['nullable','string'],'assigned_to'=>['nullable','exists:users,id'],
        ]);
    }
    private function normalizeBooleans(Request $request,array &$data): void { foreach(['proposal_given','site_visit_done','is_customer'] as $f)$data[$f]=$request->boolean($f); }
    private function salesUsers(){return User::where('role','sales')->where('status','active')->orderBy('name')->get();}
    private function authorizeLead(Request $request,SalesLead $lead): void { if($request->user()->role==='sales' && $lead->assigned_to!==$request->user()->id) abort(403); }
    private function nextCode(): string { do{$c='SL-'.now()->format('ym').'-'.str_pad((string)random_int(1,99999),5,'0',STR_PAD_LEFT);}while(SalesLead::where('lead_code',$c)->exists()); return $c; }
}
