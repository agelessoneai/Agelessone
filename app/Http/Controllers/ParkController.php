<?php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Http\Request;

class ParkController extends Controller
{
    public function index()
    {
        $parks = Park::latest()->paginate(10);
        return view('admin.parks.index', compact('parks'));
    }

    public function create()
    {
        return view('admin.parks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'contact_person' => 'nullable|max:255',
            'phone' => 'nullable|max:30',
            'location' => 'nullable|max:255',
        ]);

        Park::create($request->only([
            'name',
            'contact_person',
            'phone',
            'location',
        ]));

        return redirect()->route('admin.parks')
            ->with('success', 'Park/client added successfully.');
    }
}