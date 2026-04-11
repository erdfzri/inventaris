<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Item::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Category',
            'Name',
            'Total Stock',
            'Lending Total',
            'Repair',
            'Available',
            'Created At',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->category->name,
            $item->name,
            $item->total_stock,
            $item->lending_total,
            $item->repair_stock == 0 ? '-' : $item->repair_stock,
            $item->available_stock,
            $item->created_at->format('F d, Y'),
        ];
    }
}
