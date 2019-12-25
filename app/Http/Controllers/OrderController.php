<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use App\Models\Party;
use Helper;
use DataTables;

class OrderController extends Controller
{
    public $route='order';
    public $view ='order';
    public $moduleName = 'Order';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view.'/index', compact('moduleName'));
    }

    public function getOrderData()
    {
        $order = Order::with(['party', 'user', 'product'])->groupBy('order_id')->orderBy('order_id', 'desc')->select('orders.*');
        return DataTables::eloquent($order)
        ->addColumn('action', function ($order) {
            $editUrl = route('order.edit', encrypt($order->order_id));

            $action =  "<a href='".$editUrl."' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Edit</a>";

            return $action;
        })

        ->editColumn('status', function ($order) {
            if ($order->status == 0) {
                return "<span class='label label-primary'>Pending</span>";
            } elseif($order->status == 1) {
                return "<span class='label label-warning'>Partial Pending</span>";
            } else {
                return "<span class='label label-success'>Dispatch</span>";
            }
        })

        ->editColumn('date', function ($order) {
            return date("d-m-Y", strtotime($order->date));
        })
        ->rawColumns(['action', 'status'])
        ->addIndexColumn()
        ->make(true);
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        $party = Party::select('id', 'name')->active()->get();
        $product = Product::select('id', 'name')->active()->get();

        return view($this->view.'/form', compact('moduleName', 'party', 'product'));
    }

    public function store(Request $request)
    {
        $get_order = Order::orderBy('order_id', 'desc')->first();
        if(!$get_order) {
            $order_no = 'OR_'.'1';
            $order_id = 1;
        } else {
            $order_no = 'OR_'.($get_order->order_id + 1);
            $order_id = $get_order->order_id + 1;
        }

        $productId = $request->product_id;
        $cnt = 0;

        foreach($productId as $key => $val) {

            Order::create(['order_id' => $order_id, 'order_no' => $order_no, 'date' => date('Y-m-d', strtotime($request->date)), 'party_id' => $request->party_id, 'product_id' => $request->product_id[$cnt], 'price' => $request->price[$cnt], 'qty' => $request->qty[$cnt], 'amount' => $request->amount[$cnt], 'discount' => $request->discount, 'gst_type' => $request->gst_type, 'cgst' => $request->cgst, 'sgst' => $request->sgst, 'igst' => $request->igst, 'grand_total' => $request->grand_total, 'instruction' => $request->instruction, 'dispatch_qty' => 0, 'remaining_qty' => 0, 'lr_no' => $request->lr_no, 'transporter' => $request->transporter,  'status' => 0, 'added_by' => auth()->user()->id]);

            $cnt++;
        }

        Helper::successMsg('insert', $this->moduleName);
        return redirect($this->route);
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $order = Order::where('order_id', decrypt($id))->get();
        $party = Party::select('id', 'name')->active()->get();
        $product = Product::select('id', 'name')->active()->get();

        return view($this->view.'/_form', compact('party', 'moduleName', 'order', 'product'));
    }

    public function update(Request $request, $id)
    {
        Party::find($id)->update(['state_id' => $request->state_id, 'city_id' => $request->city_id, 'name'=> ucwords($request->name), 'mobile_no' => $request->mobile_no, 'address' => $request->address, 'status' => $request->status, 'updated_by' => auth()->user()->id]);

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

    public function getProductPrice(Request $request){
        $productId = $request->product_id;
        $product = Product::find($productId);

        if($product) {
            return json_encode($product->price);
        } else {
            return json_encode(0);
        }

    }

}
