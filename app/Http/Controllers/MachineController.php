<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of machines.
     */
    public function index()
    {
        $machines = Machine::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.machines.index', compact('machines'));
    }

    /**
     * Show the form for creating a new machine.
     */
    public function create()
    {
        return view('admin.machines.create');
    }

    /**
     * Store a newly created machine in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'components' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'warranty' => 'nullable|string|max:255',
            'warranty_ending_date' => 'nullable|date',
        ]);

        $machine = Machine::create($validated);

        return redirect()->route('admin.machines.qr', $machine->id)
            ->with('success', 'Machine registered successfully! QR Code generated.');
    }

    /**
     * Display the QR code for a specific machine.
     */
    public function qr(Machine $machine)
    {
        return view('admin.machines.qr', compact('machine'));
    }

    /**
     * Display the machine details (public access).
     */
    public function show(Machine $machine)
    {
        return view('machines.show', compact('machine'));
    }
}
