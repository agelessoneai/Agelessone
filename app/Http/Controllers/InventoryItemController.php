<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InventoryItemController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryItem::with('category');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('item_name', 'like', "%{$search}%")
                    ->orWhere('item_code', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('warehouse', 'like', "%{$search}%")
                    ->orWhere('rack', 'like', "%{$search}%")
                    ->orWhere('usage_purpose', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('inventory_category_id', $request->category_id);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->whereColumn('stock', '>', 'minimum_stock');
            }

            if ($request->stock_status === 'low_stock') {
                $query
                    ->where('stock', '>', 0)
                    ->whereColumn('stock', '<=', 'minimum_stock');
            }

            if ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            }
        }

        $items = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = InventoryCategory::where('active', true)
            ->orderBy('name')
            ->get();

        $summary = [
            'total_items' => InventoryItem::count(),

            'total_stock' => InventoryItem::sum('stock'),

            'low_stock' => InventoryItem::where('stock', '>', 0)
                ->whereColumn('stock', '<=', 'minimum_stock')
                ->count(),

            'out_of_stock' => InventoryItem::where('stock', '<=', 0)
                ->count(),

            'inventory_value' => InventoryItem::selectRaw(
                'COALESCE(SUM(stock * purchase_price), 0) as total'
            )->value('total'),
        ];

        return view('admin.inventory_items.index', compact(
            'items',
            'categories',
            'summary'
        ));
    }


    public function show(InventoryItem $inventoryItem)
    {
        $inventoryItem->load([
            'category',
            'movements' => fn ($query) => $query->with(['user', 'workSite'])->latest(),
        ]);

        return view('admin.inventory_items.show', compact('inventoryItem'));
    }

    public function create()
    {
        $categories = InventoryCategory::where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.inventory_items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_category_id' => 'required|exists:inventory_categories,id',
            'item_name' => 'required|string|max:255',
            'item_code' => 'required|string|max:100|unique:inventory_items,item_code',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'qr_code' => 'nullable|string|max:255',
            'warehouse' => 'required|string|max:150',
            'rack' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
            'description' => 'nullable|string',
            'usage_purpose' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('inventory-items', 'public');
        }

        $validated['active'] = $request->boolean('active');

        InventoryItem::create($validated);

        return redirect()
            ->route('admin.inventory-items')
            ->with('success', 'Inventory item added successfully.');
    }

    public function edit(InventoryItem $inventoryItem)
    {
        $categories = InventoryCategory::where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.inventory_items.edit', compact(
            'inventoryItem',
            'categories'
        ));
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'inventory_category_id' => 'required|exists:inventory_categories,id',
            'item_name' => 'required|string|max:255',

            'item_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('inventory_items', 'item_code')
                    ->ignore($inventoryItem->id),
            ],

            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'qr_code' => 'nullable|string|max:255',
            'warehouse' => 'required|string|max:150',
            'rack' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
            'description' => 'nullable|string',
            'usage_purpose' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($inventoryItem->image) {
                Storage::disk('public')->delete($inventoryItem->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('inventory-items', 'public');
        }

        $validated['active'] = $request->boolean('active');

        $inventoryItem->update($validated);

        return redirect()
            ->route('admin.inventory-items')
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventoryItem)
    {
        if ($inventoryItem->image) {
            Storage::disk('public')->delete($inventoryItem->image);
        }

        $inventoryItem->delete();

        return redirect()
            ->route('admin.inventory-items')
            ->with('success', 'Inventory item deleted successfully.');
    }
}