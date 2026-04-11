<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Category;
use App\Models\LendingDetail;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->latest()->get();
        $categories = Category::all();
        return view('admin.items.index', compact('items', 'categories'));
    }

    public function lendingDetails(Item $item)
    {
        $lendingDetails = LendingDetail::with(['lending.staff', 'item'])
            ->where('item_id', $item->id)
            ->latest()
            ->get();
        return view('admin.items.lending_details', compact('item', 'lendingDetails'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'total_stock' => 'required|integer|min:0',
        ]);

        $item = Item::where('category_id', $request->category_id)
            ->where('name', $request->name)
            ->first();

        if ($item) {
            $item->increment('total_stock', $request->total_stock);
        } else {
            Item::create($request->all());
        }

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil disimpan.');
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'total_stock' => 'required|integer|min:0',
            'new_broke_item' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        if ($request->filled('new_broke_item')) {
            $data['repair_stock'] = $item->repair_stock + $request->new_broke_item;
        }

        $item->update($data);
        return redirect()->route('admin.items.index')->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('admin.items.index')->with('success', 'Item berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new \App\Exports\ItemsExport, 'items.xlsx');
    }
}
