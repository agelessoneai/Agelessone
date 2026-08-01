<?php

namespace App\Http\Controllers;

use App\Models\Park;
use App\Models\User;
use App\Models\ComplaintTicket;
use App\Models\SiteTicket;
use App\Models\TicketUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ComplaintTicketController extends Controller
{
    // ==========================
    // ADMIN - Ticket List
    // ==========================
    public function index()
    {
        $tickets = ComplaintTicket::with(['park', 'staff', 'creator'])
            ->latest()
            ->paginate(15);

        return view('admin.tickets.index', [
            'tickets' => $tickets,
            'pending' => ComplaintTicket::where('status', 'pending')->count(),
            'accepted' => ComplaintTicket::where('status', 'accepted')->count(),
            'working' => ComplaintTicket::where('status', 'work_started')->count(),
            'spare' => ComplaintTicket::where('status', 'need_spare_parts')->count(),
            'completed' => ComplaintTicket::where('status', 'completed')->count(),
        ]);
    }

    // ==========================
    // ADMIN - Create Ticket
    // ==========================
    public function create()
    {
        $parks = Park::latest()->get();
        $staff = User::query()
            ->whereIn('role', ['office_staff', 'project_manager', 'project_head', 'project_coordinator', 'site_manager', 'supervisor'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.tickets.create', compact('parks', 'staff'));
    }

    // ==========================
    // ADMIN - Save Ticket
    // ==========================
    public function store(Request $request)
    {
        $request->validate([
            'park_id' => 'required|exists:parks,id',
            'assigned_to' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->whereIn('role', ['office_staff', 'project_manager', 'project_head', 'project_coordinator', 'site_manager', 'supervisor'])
                        ->where('status', 'active');
                }),
            ],
            'item_name' => 'required|string|max:255',
            'complaint_title' => 'required|string|max:255',
            'complaint_description' => 'nullable|string',
            'priority' => 'required|in:low,normal,high,urgent',
        ]);

        ComplaintTicket::create([
            'ticket_no' => 'TKT-' . date('Ymd') . '-' . rand(1000, 9999),
            'park_id' => $request->park_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
            'item_name' => $request->item_name,
            'complaint_title' => $request->complaint_title,
            'complaint_description' => $request->complaint_description,
            'priority' => $request->priority,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.tickets')
            ->with('success', 'Complaint ticket assigned successfully.');
    }

    // ==========================
    // USER - My Tickets
    // ==========================
    public function myTickets(Request $request)
    {
        $query = ComplaintTicket::with([
            'park',
            'updates.user'
        ])
        ->where('assigned_to', Auth::id());

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->get();
        $siteTickets = SiteTicket::with(['site', 'zone'])
            ->where('assigned_to', Auth::id())
            ->when($request->status, fn ($siteQuery, $status) => $siteQuery->where('status', $status))
            ->latest()
            ->get();

        return view('user.tickets.index', compact('tickets', 'siteTickets'));
    }

    // ==========================
    // ADMIN - Ticket Details
    // ==========================
    public function adminShow(ComplaintTicket $ticket)
    {
        $ticket->load([
            'park',
            'staff',
            'creator',
            'updates.user'
        ]);

        return view('admin.tickets.show', compact('ticket'));
    }

    // ==========================
    // USER - Accept Ticket
    // ==========================
    public function accept(ComplaintTicket $ticket)
    {
        $this->authorizeStaff($ticket);

        $ticket->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return back()->with('success', 'Ticket accepted.');
    }

    // ==========================
    // USER - Start Work
    // ==========================
    public function startWork(ComplaintTicket $ticket)
    {
        $this->authorizeStaff($ticket);

        $ticket->update([
            'status' => 'work_started',
            'work_started_at' => now(),
        ]);

        return back()->with('success', 'Work started.');
    }

    // ==========================
    // USER - Progress Update
    // ==========================
    public function updateWork(Request $request, ComplaintTicket $ticket)
    {
        $this->authorizeStaff($ticket);

        $request->validate([
            'note' => 'nullable|string',
            'spare_parts' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'update_type' => 'required|in:progress,spare_parts',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ticket-images', 'public');
        }

        TicketUpdate::create([
            'complaint_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'update_type' => $request->update_type,
            'note' => $request->note,
            'spare_parts' => $request->spare_parts,
            'image' => $imagePath,
        ]);

        if ($request->update_type == 'spare_parts') {
            $ticket->update([
                'status' => 'need_spare_parts'
            ]);
        }

        return back()->with('success', 'Ticket updated.');
    }

    // ==========================
    // USER - Complete Ticket
    // ==========================
    public function complete(Request $request, ComplaintTicket $ticket)
    {
        $this->authorizeStaff($ticket);

        $request->validate([
            'note' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ticket-images', 'public');
        }

        TicketUpdate::create([
            'complaint_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'update_type' => 'completed',
            'note' => $request->note,
            'image' => $imagePath,
        ]);

        $ticket->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Ticket completed successfully.');
    }

    // ==========================
    // SECURITY
    // ==========================

// =====================================
// STAFF - Start Travel
// =====================================
public function startTravel(ComplaintTicket $ticket)
{
    $this->authorizeStaff($ticket);

    $ticket->update([
        'travel_status' => 'travelling',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Travel started.'
    ]);
}

// =====================================
// STAFF - Update Live GPS
// =====================================
public function updateLiveLocation(Request $request, ComplaintTicket $ticket)
{
    $this->authorizeStaff($ticket);

    $request->validate([
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $ticket->update([
        'live_latitude' => $request->latitude,
        'live_longitude' => $request->longitude,
        'live_location_updated_at' => now(),
    ]);

    return response()->json([
        'success' => true
    ]);
}

// =====================================
// STAFF - Arrived at Park
// =====================================
public function markArrived(ComplaintTicket $ticket)
{
    $this->authorizeStaff($ticket);

    $ticket->update([
        'travel_status' => 'arrived',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Arrived at destination.'
    ]);
}

// =====================================
// ADMIN - View Live Location
// =====================================
public function liveLocation(ComplaintTicket $ticket)
{
    return response()->json([
        'latitude' => $ticket->live_latitude,
        'longitude' => $ticket->live_longitude,
        'status' => $ticket->travel_status,
        'updated_at' => $ticket->live_location_updated_at,
    ]);
}

    private function authorizeStaff(ComplaintTicket $ticket)
    {
        if ($ticket->assigned_to != Auth::id()) {
            abort(403);
        }
    }

    // =====================================
    // USER - Accept Site Ticket
    // =====================================
    public function acceptSiteTicket(SiteTicket $siteTicket)
    {
        if ($siteTicket->assigned_to != Auth::id()) {
            abort(403);
        }
        $siteTicket->update(['status' => 'accepted']);
        return back()->with('success', 'Site ticket accepted.');
    }

    // =====================================
    // USER - Reject Site Ticket
    // =====================================
    public function rejectSiteTicket(SiteTicket $siteTicket)
    {
        if ($siteTicket->assigned_to != Auth::id()) {
            abort(403);
        }
        $siteTicket->update(['status' => 'rejected']);
        return back()->with('success', 'Site ticket rejected.');
    }
}
