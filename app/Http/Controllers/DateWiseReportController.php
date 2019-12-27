<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Helper, DataTables;
use DB, PDF;

class DateWiseReportController extends Controller
{
    public $route = 'datewisereport';
    public $view = 'datewisereport';
    public $moduleName = 'Date Wise Report';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view.'/index', compact('moduleName'));
    }

    public function getDateWiseReportData(Request $request)
    {
        $productreport = Order::with(['party']);
        $productreport->where('date', '>=', date('Y-m-d', strtotime($request->from)))->where('date', '<=', date('Y-m-d',strtotime($request->to)));
     
        return DataTables::eloquent($productreport)
            ->editColumn('date', function($productreport){
                return date('d-m-Y', strtotime($productreport->date));
            })
            ->editColumn('grand_total', function($productreport){
                return number_format($productreport->grand_total,2); 
            })
            ->rawColumns(['date', 'grand_total'])
            ->addIndexColumn()
            ->make(true);
    }

    public function printDateWiseReport(Request $request)
    {
        $productreport = Order::with(['party']);
        $productreport->where('date', '>=', date('Y-m-d', strtotime($request->from)))->where('date', '<=', date('Y-m-d',strtotime($request->to)));
        $productreport = $productreport->get();

        $html = view($this->view.'.print', compact('productreport'))->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
    
}
