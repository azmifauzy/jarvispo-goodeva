<?php

namespace App\Http\Controllers;

use App\Imports\PurchaseImport;
use App\Exports\PurchasesExport;
use App\Models\Purchase;
use App\Models\Reimburse;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class DashboardController extends Controller
{

    public function index()
    {

        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => [['/', 'Apps'], ['/', 'Dashboard']],
            "poAlltime" => Purchase::all(),
            "poInProgress" => Purchase::where('status', "In Progress")->get()->count(),
            "poDone" => Purchase::where('status', "Done")->get()->count(),
            "profits" => $this->countProfit(),
        ];

        return view('dashboard', $data);
    }

    public function edit(Purchase $purchase) {$data = [
        'title' => 'Dashboard',
        'breadcrumbs' => [['/', 'Apps'], ['/', 'Purchase Edit']],
        'purchase' => $purchase
    ];

        return view('edit', $data);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'no_purchase' => 'required',
            'customer' => 'required',
            'type' => 'required',
            'order_title' => 'required',
            'status' => 'required',
            'category' => 'required',
            'total_price' => 'required',
            'deadline' => 'required',
        ]);

        $validatedData["total_price"] = "Rp." . number_format($validatedData["total_price"]);

        Purchase::create($validatedData);
        return redirect('/')->with('success', 'Data Baru Berhasil di Tambahkan');
    }

    public function update(Purchase $purchase, Request $request) {
        $validatedData = $request->validate([
            'no_purchase' => 'required',
            'customer' => 'required',
            'type' => 'required',
            'order_title' => 'required',
            'status' => 'required',
            'category' => 'required',
            'total_price' => 'required',
            'deadline' => 'required',
        ]);

        $validatedData["total_price"] = "Rp." . number_format($validatedData["total_price"]);

        $purchase->update($validatedData);
        return redirect('/')->with('success', 'Data Berhasil di Perbarui');
    }

    public function destroy(Purchase $purchase) {
        $purchase->delete();
        return redirect('/')->with('success', 'Data Berhasil di Hapus');
    }

    public function countProfit() {
        $purchases = Purchase::all();
        $totalPrices = 0;
        foreach ($purchases as $po) {
            $total_price = explode('.', $po->total_price)[1];
            $stringTotalPrice = explode(',', $total_price);

            $totalPrice = '';
            for ($i=0; $i < count($stringTotalPrice); $i++) { 
                $totalPrice .= $stringTotalPrice[$i];
            }
            $totalPrices += (int) $totalPrice;
        }

        return $totalPrices;
    }

    public function import_excel(Request $request) 
    {
        // validasi
        $request->validate([
            'excel' => 'required|mimes:csv,xls,xlsx'
        ]);
    
        // menangkap file excel
        $file = $request->file('excel');
    
        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();
    
        // upload ke folder file_siswa di dalam folder public
        $file->move('purchases_import',$nama_file);
    
        // import data
        Excel::import(new PurchaseImport, public_path('/purchases_import/'.$nama_file));
    
        // notifikasi dengan session
    
        // alihkan halaman kembali
        return redirect('/')->with('success', 'Data Berhasil di Import');
    }

    public function export_excel()
    {
        $today = Carbon::now('Asia/Jakarta')->format('d-m-Y');
        return Excel::download(new PurchasesExport, "Purchase_orders_$today.xlsx");
    }

    public function getStatistik()
    {

        $allData = Purchase::all();

        $groupPurchases = $allData->groupBy(function ($item) {
            return $item->created_at->format('M');
        });

        $purchasesStatistik = $groupPurchases->map(function ($s) {
            return $s->count();
        });
        
        $purchaseByCategory = $allData->groupBy('category')->map(function ($s) {
            return $s->count();
        });

        $purchaseAllOfTime = $allData->count();
        $purchaseInProgress = $allData->where('status', "In Progress")->count();
        $purchaseDone = $allData->where('status', "Done")->count();
        

        $rpm = $allData->groupBy(function ($item) {
            return $item->created_at->format('M');
        });

        $rpmData = [
            "rpm_month" => $rpm,
            "in" => collect([]),
            "out" => collect([])
        ];
        foreach($rpm as $rp) {
            $in = $rp->where('type', 'In Order')->count();
            $out = $rp->where('type', 'Out Order')->count();

            $rpmData["in"]->push($in);
            $rpmData["out"]->push($out);

        }


        return response()->json([
            "purchasesStatistik" => $purchasesStatistik,
            "purchaseByCategory" => $purchaseByCategory,
            "purchaseHalfCircle" => [
                "purchase all of time" => $purchaseAllOfTime,
                "purchase in progress" => $purchaseInProgress,
                "purchase done" => $purchaseDone,
            ],
            "rpmData" => $rpmData
        ]);
    }
}
