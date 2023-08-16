<?php

namespace App\Exports;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchasesExport implements FromCollection, ShouldAutoSize, WithStyles, WithMultipleSheets, WithTitle
{
    public function title(): string
    {
        return 'In Progress';
    }

    public function styles(Worksheet $sheet)
    {
        // set border for all cells
        $sheet->getStyle('A1:I' . (Purchase::where('status', 'In Progress')->get()->count() + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [
            // Style the ten row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $row = new Collection();

        $row->push([
            'No.',
            'No. PO',
            'Customer',
            'Type',
            'Order Title',
            'Status',
            'Category',
            'Total Price',
            'Deadline',
        ]);

        $purchases = Purchase::where('status', 'In Progress')->get();

        foreach ($purchases as $key => $purchase) {
            $row->push([
                $key + 1,
                $purchase->no_purchase,
                $purchase->customer,
                $purchase->type,
                $purchase->order_title,
                $purchase->status,
                $purchase->category,
                $purchase->total_price,
                $purchase->deadline,
            ]);
        }

        return $row;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new PurchasesExport();
        $sheets[] = new PurchasesDoneExport();

        return $sheets;
    }
}
