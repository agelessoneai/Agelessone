<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OfficeInventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryItem::with('category')->where('inventory_type', 'office')->latest();

        if ($search = trim((string) $request->search)) {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                    ->orWhere('item_code', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%")
                    ->orWhere('warehouse', 'like', "%{$search}%")
                    ->orWhere('rack', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('inventory_category_id', $request->integer('category_id'));
        }

        if ($request->stock_status === 'available') {
            $query->whereColumn('stock', '>', 'minimum_stock');
        } elseif ($request->stock_status === 'low') {
            $query->where('stock', '>', 0)->whereColumn('stock', '<=', 'minimum_stock');
        } elseif ($request->stock_status === 'out') {
            $query->where('stock', '<=', 0);
        }

        $items = $query->paginate(15)->withQueryString();
        $categories = InventoryCategory::where('active', true)->orderBy('name')->get();
        $movements = InventoryMovement::with(['item', 'user'])
            ->whereNull('work_site_id')
            ->latest()->limit(40)->get();

        $summary = [
            'total_items' => InventoryItem::where('inventory_type', 'office')->where('active', true)->count(),
            'available_stock' => InventoryItem::where('inventory_type', 'office')->where('active', true)->sum('stock'),
            'low_stock' => InventoryItem::where('inventory_type', 'office')->where('active', true)->where('stock', '>', 0)->whereColumn('stock', '<=', 'minimum_stock')->count(),
            'out_of_stock' => InventoryItem::where('inventory_type', 'office')->where('active', true)->where('stock', '<=', 0)->count(),
        ];

        return view('office_inventory.index', compact('items', 'categories', 'movements', 'summary'));
    }

    public function storeItem(Request $request)
    {
        $data = $request->validate([
            'inventory_category_id' => ['required', 'exists:inventory_categories,id'],
            'item_name' => ['required', 'string', 'max:255'],
            'item_code' => ['required', 'string', 'max:100', 'unique:inventory_items,item_code'],
            'brand' => ['nullable', 'string', 'max:100'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'maximum_stock' => ['nullable', 'integer', 'min:0'],
            'warehouse' => ['required', 'string', 'max:150'],
            'rack' => ['nullable', 'string', 'max:100'],
            'supplier' => ['nullable', 'string', 'max:255'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);
        $data['maximum_stock'] = $data['maximum_stock'] ?? max((int) $data['stock'], 1);
        $data['inventory_type'] = 'office';
        $data['active'] = true;
        $item = InventoryItem::create($data);

        if ($item->stock > 0) {
            InventoryMovement::create([
                'inventory_item_id' => $item->id, 'user_id' => Auth::id(), 'type' => 'stock_in',
                'quantity' => $item->stock, 'previous_stock' => 0, 'new_stock' => $item->stock,
                'warehouse' => $item->warehouse, 'note' => 'Opening office stock',
            ]);
        }
        return back()->with('success', 'Office inventory item added successfully.');
    }

    public function updateItem(Request $request, InventoryItem $inventoryItem)
    {
        $data = $request->validate([
            'inventory_category_id' => ['required', 'exists:inventory_categories,id'],
            'item_name' => ['required', 'string', 'max:255'],
            'item_code' => ['required', 'string', 'max:100', Rule::unique('inventory_items', 'item_code')->ignore($inventoryItem->id)],
            'brand' => ['nullable', 'string', 'max:100'], 'unit' => ['required', 'string', 'max:50'],
            'minimum_stock' => ['required', 'integer', 'min:0'], 'maximum_stock' => ['required', 'integer', 'min:0'],
            'warehouse' => ['required', 'string', 'max:150'], 'rack' => ['nullable', 'string', 'max:100'],
            'supplier' => ['nullable', 'string', 'max:255'], 'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);
        $inventoryItem->update($data);
        return back()->with('success', 'Office inventory item updated successfully.');
    }

    public function stockIn(Request $request)
    {
        $data = $request->validate([
            'inventory_item_id' => ['required', 'exists:inventory_items,id'], 'quantity' => ['required', 'integer', 'min:1'],
            'reference_no' => ['nullable', 'string', 'max:100'], 'supplier' => ['nullable', 'string', 'max:255'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'], 'note' => ['nullable', 'string'],
        ]);
        DB::transaction(function () use ($data) {
            $item = InventoryItem::lockForUpdate()->findOrFail($data['inventory_item_id']);
            $previous = $item->stock; $new = $previous + $data['quantity'];
            $item->update(['stock' => $new, 'supplier' => $data['supplier'] ?: $item->supplier, 'purchase_price' => $data['purchase_price'] ?? $item->purchase_price]);
            InventoryMovement::create([
                'inventory_item_id' => $item->id, 'user_id' => Auth::id(), 'type' => 'stock_in', 'quantity' => $data['quantity'],
                'previous_stock' => $previous, 'new_stock' => $new, 'reference_no' => $data['reference_no'] ?? null,
                'warehouse' => $item->warehouse, 'note' => $data['note'] ?? null,
            ]);
        });
        return back()->with('success', 'Stock added successfully.');
    }

    public function stockOut(Request $request)
    {
        $data = $request->validate([
            'inventory_item_id' => ['required', 'exists:inventory_items,id'], 'quantity' => ['required', 'integer', 'min:1'],
            'issued_to' => ['required', 'string', 'max:255'], 'used_for' => ['nullable', 'string', 'max:255'],
            'reference_no' => ['nullable', 'string', 'max:100'], 'note' => ['nullable', 'string'],
        ]);
        DB::transaction(function () use ($data) {
            $item = InventoryItem::lockForUpdate()->findOrFail($data['inventory_item_id']);
            abort_if($data['quantity'] > $item->stock, 422, 'Quantity exceeds available office stock.');
            $previous = $item->stock; $new = $previous - $data['quantity']; $item->update(['stock' => $new]);
            InventoryMovement::create([
                'inventory_item_id' => $item->id, 'user_id' => Auth::id(), 'type' => 'stock_out', 'quantity' => $data['quantity'],
                'previous_stock' => $previous, 'new_stock' => $new, 'reference_no' => $data['reference_no'] ?? null,
                'warehouse' => $item->warehouse, 'issued_to' => $data['issued_to'], 'used_for' => $data['used_for'] ?? null,
                'note' => $data['note'] ?? null,
            ]);
        });
        return back()->with('success', 'Stock issued successfully.');
    }

    public function adjust(Request $request)
    {
        $data = $request->validate([
            'inventory_item_id' => ['required', 'exists:inventory_items,id'], 'direction' => ['required', Rule::in(['increase','decrease'])],
            'quantity' => ['required', 'integer', 'min:1'], 'reason' => ['required', 'string', 'max:255'], 'note' => ['nullable', 'string'],
        ]);
        DB::transaction(function () use ($data) {
            $item = InventoryItem::lockForUpdate()->findOrFail($data['inventory_item_id']); $previous = $item->stock;
            $new = $data['direction'] === 'increase' ? $previous + $data['quantity'] : $previous - $data['quantity'];
            abort_if($new < 0, 422, 'Adjustment cannot make stock negative.'); $item->update(['stock' => $new]);
            InventoryMovement::create([
                'inventory_item_id' => $item->id, 'user_id' => Auth::id(), 'type' => 'adjustment', 'quantity' => $data['quantity'],
                'previous_stock' => $previous, 'new_stock' => $new, 'warehouse' => $item->warehouse,
                'note' => $data['reason'].($data['note'] ? ': '.$data['note'] : ''),
            ]);
        });
        return back()->with('success', 'Stock adjustment saved successfully.');
    }
}
