<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Stock;
use Helper;
use DataTables;
use DB;

class PurchaseController extends Controller
{
    public $route='purchase';
    public $view ='purchase';
    public $moduleName = 'Purchase';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;

        return view($this->view.'/index', compact('route', 'moduleName'));
    }

    public function getPurchaseData()
    {
        $purchase = Purchase::with(['product', 'user'])->select('purchases.*')->groupBy('purchase_id')->orderBy('purchase_id', 'desc');
        return DataTables::eloquent($purchase)
            ->editColumn('date', function($purchase){
                return date('d-m-Y', strtotime($purchase->date));
            })
            ->editColumn('purchase_id', function($purchase){
                return 'Purchase_No '.$purchase->purchase_id;
            })
            ->addColumn('action', function ($purchase) {
                $action = "";
                $editUrl = route('purchase.edit', encrypt($purchase->purchase_id));
                if (auth()->user()->hasPermission('edit.purchases')) {
                    $action = "<a href='".$editUrl."' class='btn btn-warning  btn-xs'><i class='fa fa-pencil'></i> ".trans('stockpurchase.btn.Edit')." </a>";                
                }
                if (auth()->user()->hasPermission('delete.purchases')) {
                    $deleteUrl = url('purchaseDelete/'. encrypt($purchase->purchase_id));
                    $action .= "<a id='deletepurchase' href='".$deleteUrl."' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> ".trans('stockpurchase.btn.Delete')."</a>";
                }
                return $action;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        $products = Product::where('status',1)->get();
        $moduleName = $this->moduleName;
        return view($this->view.'/form', compact('moduleName', 'products'));
    }

    public function store(Request $request)
    {
        $purchase_date = date("Y-m-d", strtotime($request->date));
        $purchaseProductId = $request->product_id;

        DB::beginTransaction();
        $getPurchaseNo = Purchase::orderBy('purchase_id', 'desc')
            ->lockForUpdate()->first();

        if ($getPurchaseNo) {
            $purchase_no = ($getPurchaseNo->purchase_id)+1;
        } else {
            $purchase_no = 1;
        }

        foreach ($purchaseProductId as $key => $val) {
            Purchase::create(['purchase_id' => $purchase_no, 'date' => $purchase_date, 'product_id' => $request->product_id[$key], 'qty' => $request->qty[$key], 'added_by' => auth()->user()->id,]);
            Stock::create(['transaction_id' => $purchase_no, 'voucher' => 2, 'product_id' => $request->product_id[$key], 'qty' => $request->qty[$key], 'type' => 0,'added_by' => auth()->user()->id,]);        
        }
        

        DB::commit();

        Helper::successMsg('custom', trans('stockpurchase.alert.insert'));

        return redirect($this->route);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {

        $moduleName = $this->moduleName;
        $purchase = Purchase::where('purchase_id',decrypt($id))->get();
        $products = Product::where('status',1)->get();
        
        return view($this->view.'/_form', compact('products', 'moduleName', 'purchase'));
    }

    public function update(Request $request, $id)
    {
        $purchase_date = date("Y-m-d", strtotime($request->date));
        $purchaseProductId = $request->product_id;
        DB::beginTransaction();
        $getExistingPurchase = Purchase::where('purchase_id', $id)->first();
        Purchase::where('purchase_id', $id)->delete();
        Stock::where('transaction_id', $id)->delete();
        foreach ($purchaseProductId as $key => $val) {
             Purchase::create(['purchase_id' => $id, 'date' => $purchase_date, 'product_id' => $request->product_id[$key], 'qty' => $request->qty[$key], 'added_by' => $getExistingPurchase->added_by, 'updated_by' => auth()->user()->id,]);
             Stock::create(['transaction_id' => $id, 'voucher' => 2, 'product_id' => $request->product_id[$key], 'qty' => $request->qty[$key], 'type' => 0,'added_by' => $getExistingPurchase->added_by,'updated_by' => auth()->user()->id,]);
        }
        

        DB::commit();

        Helper::successMsg('custom', trans('stockpurchase.alert.update'));
        return redirect($this->route);

    }

    public function destroy($id)
    {
        if (Purchase::where('purchase_id', decrypt($id))->delete()) {
            Stock::where('transaction_id', decrypt($id))->delete();
        } 
        //Helper::successMsg('delete', $this->moduleName);
        Helper::successMsg('custom', trans('stockpurchase.alert.delete'));
        return redirect($this->route);
    }
}
