<?php

namespace App\Http\Controllers;

use App\Models\SiteZone;
use App\Models\User;
use App\Models\WorkSite;
use Illuminate\Http\Request;

class SiteZoneController extends Controller
{
    public function index(Request $request)
    {
        $zones = SiteZone::with(['site', 'supervisor'])
            ->when($request->filled('work_site_id'), fn ($query) =>
                $query->where('work_site_id', $request->integer('work_site_id'))
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.site_zones.index', compact('zones'));
    }

    public function create(Request $request)
    {
        $sites = WorkSite::orderBy('site_name')->get();
        $supervisors = User::whereIn('role', ['site_supervisor', 'supervisor'])
            ->orderBy('name')->get();
        $selectedSiteId = $request->integer('work_site_id') ?: null;

        return view('admin.site_zones.create', compact('sites', 'supervisors', 'selectedSiteId'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        SiteZone::create($validated);

        return redirect()
            ->route('admin.work-sites.show', $validated['work_site_id'])
            ->with('success', 'Site work added successfully.');
    }

    public function edit(SiteZone $siteZone)
    {
        $sites = WorkSite::orderBy('site_name')->get();
        $supervisors = User::whereIn('role', ['site_supervisor', 'supervisor'])
            ->orderBy('name')->get();

        return view('admin.site_zones.edit', compact('siteZone', 'sites', 'supervisors'));
    }

    public function update(Request $request, SiteZone $siteZone)
    {
        $validated = $this->validated($request);
        $siteZone->update($validated);

        return redirect()
            ->route('admin.work-sites.show', $siteZone->work_site_id)
            ->with('success', 'Site work updated successfully.');
    }

    public function destroy(SiteZone $siteZone)
    {
        $siteId = $siteZone->work_site_id;
        $siteZone->delete();

        return redirect()
            ->route('admin.work-sites.show', $siteId)
            ->with('success', 'Site work deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'work_site_id' => ['required', 'exists:work_sites,id'],
            'zone_name' => ['required', 'string', 'max:255'],
            'work_type' => ['required', 'string', 'max:255'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:not_started,in_progress,on_hold,completed'],
            'progress' => ['required', 'integer', 'min:0', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'expected_end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'color' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
