<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\WorkSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryMovement::with(['item.category', 'user', 'workSite']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('item_id')) {
            $query->where('inventory_item_id', $request->item_id);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('reference_no', 'like', "%{$search}%")
                    ->orWhere('warehouse', 'like', "%{$search}%")
                    ->orWhere('note', 'like', "%{$search}%")
                    ->orWhereHas('item', function ($itemQuery) use ($search) {
                        $itemQuery
                            ->where('item_name', 'like', "%{$search}%")
                            ->orWhere('item_code', 'like', "%{$search}%");
                    });
            });
        }

        $movements = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $items = InventoryItem::where('active', true)
            ->orderBy('item_name')
            ->get();

        return view('admin.inventory_movements.index', compact(
            'movements',
            'items'
        ));
    }

    public function createStockIn()
    {
        $items = InventoryItem::with('category')
            ->where('active', true)
            ->orderBy('item_name')
            ->get();

        return view('admin.inventory_movements.stock_in', compact('items'));
    }

    public function storeStockIn(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'reference_no' => 'nullable|string|max:100',
            'warehouse' => 'nullable|string|max:150',
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $item = InventoryItem::lockForUpdate()
                ->findOrFail($validated['inventory_item_id']);

            $previousStock = $item->stock;
            $newStock = $previousStock + $validated['quantity'];

            $item->update([
                'stock' => $newStock,
                'warehouse' => $validated['warehouse'] ?: $item->warehouse,
            ]);

            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'user_id' => Auth::id(),
                'type' => 'stock_in',
                'quantity' => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'reference_no' => $validated['reference_no'] ?? null,
                'warehouse' => $validated['warehouse'] ?? $item->warehouse,
                'note' => $validated['note'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.inventory-movements')
            ->with('success', 'Stock added successfully.');
    }

    public function createStockOut()
    {
        $items = InventoryItem::with('category')
            ->where('active', true)
            ->orderBy('item_name')
            ->get();

        $sites = WorkSite::whereIn('status', ['planning', 'active', 'on_hold'])
            ->orderBy('site_name')
            ->get();

        return view('admin.inventory_movements.stock_out', compact('items', 'sites'));
    }

    public function storeStockOut(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'reference_no' => 'nullable|string|max:100',
            'warehouse' => 'nullable|string|max:150',
            'work_site_id' => 'nullable|exists:work_sites,id',
            'used_for' => 'nullable|required_with:work_site_id|string|max:255',
            'issued_to' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $item = InventoryItem::lockForUpdate()
                ->findOrFail($validated['inventory_item_id']);

            if ($validated['quantity'] > $item->stock) {
                abort(422, 'Stock out quantity cannot exceed available stock.');
            }

            $previousStock = $item->stock;
            $newStock = $previousStock - $validated['quantity'];

            $item->update([
                'stock' => $newStock,
            ]);

            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'user_id' => Auth::id(),
                'type' => 'stock_out',
                'quantity' => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'reference_no' => $validated['reference_no'] ?? null,
                'warehouse' => $validated['warehouse'] ?? $item->warehouse,
                'work_site_id' => $validated['work_site_id'] ?? null,
                'used_for' => $validated['used_for'] ?? $item->usage_purpose,
                'issued_to' => $validated['issued_to'] ?? null,
                'note' => $validated['note'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.inventory-movements')
            ->with('success', 'Stock issued successfully.');
    }
}