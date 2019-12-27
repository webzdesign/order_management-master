<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Helper, DataTables;
use DB, PDF;

class ProductWiseReportController extends Controller
{
    public $route = 'productwisereport';
    public $view = 'productwisereport';
    public $moduleName = 'Product Wise Report';

    public function index()
    {
        $moduleName = $this->moduleName;
        $category = Category::select('id', 'name')->active()->get();
        $product = Product::select('id', 'name')->active()->get();
        return view($this->view.'/index', compact('moduleName', 'category', 'product'));
    }

    public function getProductWiseReportData(Request $request)
    {
        $productreport = Order::with(['party']);
        if ($product = $request->product) {
            if ($product != '') {
                $productreport->where('product_id', $product);
            }
        } 
        $productreport->where('date', '>=', date('Y-m-d', strtotime($request->from)))->where('date', '<=', date('Y-m-d',strtotime($request->to)));
     
        return DataTables::eloquent($productreport)
            ->editColumn('date', function($productreport){
                return date('d-m-Y', strtotime($productreport->date));
            })
            ->editColumn('amount', function($productreport){
                return number_format($productreport->amount,2); 
            })
            ->editColumn('grand_total', function($productreport){
                return number_format($productreport->grand_total,2); 
            })
            ->rawColumns(['date', 'amount', 'grand_total'])
            ->addIndexColumn()
            ->make(true);
    }

    public function printProductWiseReport(Request $request)
    {
        $productreport = Order::with(['party']);
        if ($product = $request->product) {
            if ($product != '') {
                $productreport->where('product_id', $product);
            }
        } 
        $productreport->where('date', '>=', date('Y-m-d', strtotime($request->from)))->where('date', '<=', date('Y-m-d',strtotime($request->to)));
        $productreport = $productreport->get();

        $html = view($this->view.'.print', compact('productreport'))->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }

    public function getCategoryProduct(Request $request)
    {
        $products = Product::active()->where('category_id', $request->category_id)->pluck('name', 'id');
        return json_encode($products);
    }
    
}
