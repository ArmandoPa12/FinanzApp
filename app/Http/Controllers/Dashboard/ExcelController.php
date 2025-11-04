<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\TransaccionesExport;
use App\Http\Controllers\Controller;
use App\Imports\TransaccionesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

// use Maatwebsite\Excel\Excel;

class ExcelController extends Controller
{
    public function export()
    {
        return Excel::download(new TransaccionesExport(),'transacciones.xlsx');
    }

    public function import(Request $request)
    {
        // dd($request);
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        Excel::import(new TransaccionesImport(),$request->file('file'));
        return back();
    }
}
