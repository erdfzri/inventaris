<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lending;
use App\Models\LendingDetail;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LendingController extends Controller
{
    public function index()
    {
        // Each row in the table represents a LendingDetail because the screenshot shows Item names per row
        // But usually, a Lending has many details. 
        // Screenshot shows #1 Komputer, #2 Leptop. These might be separate Lendings or details of one.
        // Given the "Add" button leads to one borrower name and multiple items:
        // We'll list all LendingDetail joined with Lending for the table to match screenshot
        $lendingDetails = LendingDetail::with(['lending.staff', 'item'])->latest()->get();
        $items = Item::all()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'available' => $item->available_stock
            ];
        });
        return view('staff.lendings.index', compact('lendingDetails', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.total' => 'required|integer|min:1',
            'notes' => 'nullable'
        ]);

        // Stock check
        foreach ($request->items as $itemData) {
            $item = Item::find($itemData['id']);
            if ($itemData['total'] > $item->available_stock) {
                return redirect()->back()->with('error', 'Jumlah item lebih banyak dari yang tersedia!')->withInput();
            }
        }

        DB::transaction(function() use ($request) {
            $lending = Lending::create([
                'staff_id' => auth()->id(),
                'borrower_name' => $request->borrower_name,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $itemData) {
                LendingDetail::create([
                    'lending_id' => $lending->id,
                    'item_id' => $itemData['id'],
                    'quantity' => $itemData['total']
                ]);
            }
        });

        return redirect()->route('staff.lendings.index')->with('success', 'Berhasil menambahkan item peminjaman!');
    }

    public function returnItem($id)
    {
        $detail = LendingDetail::findOrFail($id);
        $detail->update(['return_date' => now()]);

        return redirect()->back()->with('success', 'Item telah dikembalikan!');
    }

    public function destroy($id)
    {
        $lending = Lending::findOrFail($id);
        $lending->delete(); // This deletes it from DB. 
        // Available stock logic is automatic because available_stock accessor exclusion of non-returned items
        
        return redirect()->back()->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new \App\Exports\LendingsExport, 'lendings.xlsx');
    }
}
