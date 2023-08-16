<?php

namespace App\Imports;

use App\Models\Purchase;
use App\Models\PurchaseImports;
use Maatwebsite\Excel\Concerns\ToModel;

class PurchaseImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Purchase([
            'no_purchase' => $row[1],
            'customer' => $row[2],
            'type' => $row[3],
            'order_title' => $row[4],
            'status' => $row[5],
            'category' => $row[6],
            'total_price' => $row[7],
            'deadline' => $row[8],
        ]);
    }
}
