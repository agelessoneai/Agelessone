<?php

namespace App\Http\Controllers;

use App\Models\SiteZone;
use App\Models\WorkSite;
use Illuminate\Http\Request;

class SiteZoneController extends Controller
{
    public function index()
    {
        $zones = SiteZone::with('site')
            ->latest()
            ->paginate(15);

        return view('admin.site_zones.index', compact('zones'));
    }

    public function create()
    {
        $sites = WorkSite::orderBy('site_name')->get();

        return view('admin.site_zones.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_site_id' => 'required|exists:work_sites,id',
            'zone_name' => 'required|string|max:255',
            'work_type' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        SiteZone::create($validated);

        return redirect()
            ->route('admin.site-zones.index')
            ->with('success', 'Site zone created successfully.');
    }

    public function edit(SiteZone $siteZone)
    {
        $sites = WorkSite::orderBy('site_name')->get();

        return view('admin.site_zones.edit', compact('siteZone', 'sites'));
    }

    public function update(Request $request, SiteZone $siteZone)
    {
        $validated = $request->validate([
            'work_site_id' => 'required|exists:work_sites,id',
            'zone_name' => 'required|string|max:255',
            'work_type' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $siteZone->update($validated);

        return redirect()
            ->route('admin.site-zones.index')
            ->with('success', 'Site zone updated successfully.');
    }

    public function destroy(SiteZone $siteZone)
    {
        $siteZone->delete();

        return back()->with('success', 'Site zone deleted successfully.');
    }
}