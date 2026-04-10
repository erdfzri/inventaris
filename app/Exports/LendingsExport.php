<?php

namespace App\Exports;

use App\Models\LendingDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LendingsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LendingDetail::with(['lending.staff', 'item'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Item',
            'Quantity',
            'Borrower',
            'Staff (Edited By)',
            'Lending Date',
            'Return Date',
        ];
    }

    public function map($detail): array
    {
        return [
            $detail->id,
            $detail->item->name,
            $detail->quantity,
            $detail->lending->borrower_name,
            $detail->lending->staff->name,
            $detail->lending->created_at->format('d F, Y'),
            $detail->return_date ? $detail->return_date->format('d F, Y') : '-',
        ];
    }
}
