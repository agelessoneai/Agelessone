<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SparePartController extends Controller
{
    public function index()
    {
        $parts = SparePart::latest()->paginate(15);

        return view('admin.spare_parts.index', compact('parts'));
    }

    public function create()
    {
        return view('admin.spare_parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_name' => 'required|string|max:255',
            'part_code' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('spare-parts', 'public');
        }

        SparePart::create([
            'part_name' => $request->part_name,
            'part_code' => $request->part_code,
            'category' => $request->category,
            'stock' => $request->stock,
            'minimum_stock' => $request->minimum_stock,
            'unit_price' => $request->unit_price,
            'unit' => $request->unit,
            'description' => $request->description,
            'image' => $image,
        ]);

        return redirect()->route('admin.spare-parts')
            ->with('success', 'Spare part added successfully.');
    }

    public function edit(SparePart $sparePart)
    {
        return view('admin.spare_parts.edit', compact('sparePart'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $request->validate([
            'part_name' => 'required|string|max:255',
            'part_code' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $data = [
            'part_name' => $request->part_name,
            'part_code' => $request->part_code,
            'category' => $request->category,
            'stock' => $request->stock,
            'minimum_stock' => $request->minimum_stock,
            'unit_price' => $request->unit_price,
            'unit' => $request->unit,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($sparePart->image) {
                Storage::disk('public')->delete($sparePart->image);
            }

            $data['image'] = $request->file('image')->store('spare-parts', 'public');
        }

        $sparePart->update($data);

        return redirect()->route('admin.spare-parts')
            ->with('success', 'Spare part updated successfully.');
    }

    public function destroy(SparePart $sparePart)
    {
        if ($sparePart->image) {
            Storage::disk('public')->delete($sparePart->image);
        }

        $sparePart->delete();

        return redirect()->route('admin.spare-parts')
            ->with('success', 'Spare part deleted successfully.');
    }
}