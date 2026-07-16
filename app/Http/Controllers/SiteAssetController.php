<?php

namespace App\Http\Controllers;

use App\Models\SiteAsset;
use App\Models\WorkSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiteAssetController extends Controller
{
    public function index(Request $request)
    {
        $query = SiteAsset::with('workSite');

        if ($request->filled('site_id')) {
            $query->where('work_site_id', $request->site_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('asset_name', 'like', "%{$search}%")
                    ->orWhere('asset_code', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $assets = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $sites = WorkSite::orderBy('site_name')->get();

        $categories = SiteAsset::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $summary = [
            'total' => SiteAsset::count(),
            'available' => SiteAsset::where('status', 'available')->count(),
            'working' => SiteAsset::where('status', 'working')->count(),
            'maintenance' => SiteAsset::where('status', 'maintenance')->count(),
            'breakdown' => SiteAsset::where('status', 'breakdown')->count(),
        ];

        return view('admin.site_assets.index', compact(
            'assets',
            'sites',
            'categories',
            'summary'
        ));
    }

    public function create()
    {
        $sites = WorkSite::orderBy('site_name')->get();

        return view('admin.site_assets.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_site_id' => 'nullable|exists:work_sites,id',
            'asset_name' => 'required|string|max:255',
            'asset_code' => 'required|string|max:100|unique:site_assets,asset_code',
            'category' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'operator_name' => 'nullable|string|max:255',
            'operator_mobile' => 'nullable|string|max:30',
            'current_meter' => 'required|numeric|min:0',
            'meter_unit' => 'required|in:hours,kilometres',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date|after_or_equal:last_service_date',
            'status' => 'required|in:available,working,maintenance,breakdown,inactive',
            'image' => 'nullable|image|max:4096',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('site-assets', 'public');
        }

        SiteAsset::create($validated);

        return redirect()
            ->route('admin.site-assets')
            ->with('success', 'Site asset added successfully.');
    }

    public function edit(SiteAsset $siteAsset)
    {
        $sites = WorkSite::orderBy('site_name')->get();

        return view('admin.site_assets.edit', compact(
            'siteAsset',
            'sites'
        ));
    }

    public function update(Request $request, SiteAsset $siteAsset)
    {
        $validated = $request->validate([
            'work_site_id' => 'nullable|exists:work_sites,id',
            'asset_name' => 'required|string|max:255',

            'asset_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('site_assets', 'asset_code')
                    ->ignore($siteAsset->id),
            ],

            'category' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'operator_name' => 'nullable|string|max:255',
            'operator_mobile' => 'nullable|string|max:30',
            'current_meter' => 'required|numeric|min:0',
            'meter_unit' => 'required|in:hours,kilometres',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date|after_or_equal:last_service_date',
            'status' => 'required|in:available,working,maintenance,breakdown,inactive',
            'image' => 'nullable|image|max:4096',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($siteAsset->image) {
                Storage::disk('public')->delete($siteAsset->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('site-assets', 'public');
        }

        $siteAsset->update($validated);

        return redirect()
            ->route('admin.site-assets')
            ->with('success', 'Site asset updated successfully.');
    }

    public function destroy(SiteAsset $siteAsset)
    {
        if ($siteAsset->image) {
            Storage::disk('public')->delete($siteAsset->image);
        }

        $siteAsset->delete();

        return redirect()
            ->route('admin.site-assets')
            ->with('success', 'Site asset deleted successfully.');
    }
}