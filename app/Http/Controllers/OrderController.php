<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use App\Models\City;
use App\Models\Dealer;
use Helper;
use DataTables;

class OrderController extends Controller
{
    public $route='order';
    public $view ='order';
    public $moduleName = 'Order';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;

        return view($this->view.'/index', compact('route', 'moduleName'));
    }

    public function getOrderData()
    {
        $order = Order::with(['product', 'city', 'dealer'])->groupBy('order_no');
        return DataTables::eloquent($order)
            ->addColumn('action', function ($order) {
            $name = 'status'.$order->order_id;

            $action =  '<label style="margin-right:20px;">
                        <input type="radio" class="dispatch-confirm status" data-id="'.$order->order_id.'" value="0" name="'.$name.'" ';
            if($order->status == 0) {
                $action .= 'checked';
            }
            $action .='> Pending
                    </label>
                    <label  style="margin-right:20px;">
                        <input type="radio" value="1" class="dispatch-confirm status" data-id="'.$order->order_id.'" name="'.$name.'" ';
            if($order->status == 1) {
                $action .= 'checked';
            }
            $action .='> Partial Dispatch
                    </label>
                    <label style="margin-right:20px;">
                        <input type="radio" value="2" class="dispatch-confirm status" data-id="'.$order->order_id.'" name="'.$name.'" ';
            if($order->status == 2) {
                $action .= 'checked';
            }
            $action .='> Dispatch
                    </label>';
            $viewUrl = route('order.show', ($order->order_id));
            $action .= "<a href='".$viewUrl."' class='btn btn-primary  btn-xs'><i class='fa fa-eyes'></i> View</a>";

            return $action;
            })

            ->editColumn('date', function ($order) {
                return date("d-m-Y", strtotime($order->date));
            })
            ->rawColumns(['action', 'date', 'status'])
            ->addIndexColumn()
            ->make(true);
    }

    public function orderdispatch($type,$id)
    {
        if ($type == 'dispatch') {
            Order::where('id', $id)->update(['status'=>'1']);
            Helper::activeDeactiveMsg('dispatch', $this->moduleName);
        } else {
            Order::where('id', $id)->update(['status'=>'0']);
            Helper::activeDeactiveMsg('partial_dispatch', $this->moduleName);
        }
        return redirect($this->route);
    }

    public function getDispatchQty(Request $request)
    {
        $dispatch_qty = $request->dispatch_qty;
        $id = $request->id;

        $old_order = Order::where('id', $id)->first();
        $remaining_qty = ($old_order->remaining_qty) - ($request->dispatch_qty);

        $dispatch =  ($old_order->dispatch_qty) + ($request->dispatch_qty);
        $qty= Order::where('id', $id)->update(['dispatch_qty'=>$dispatch, 'remaining_qty'=>$remaining_qty]);


        $response[0]="success";
		$response[1]=$request->id;
        $response[2]=$remaining_qty;

        return response()->json($response);
    }

    public function checkDispatchQty(Request $request)
    {
        $dispatch_qty = $request->dispatch_qty;
        $id = $request->id;

        $getQty = Order::where('id', $id)->first();

        if($getQty->remaining_qty >= $dispatch_qty){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }


    public function statusAll(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        Order::where('order_id', $id)->update(['status'=> $status]);

        return response()->json(true);
    }


    public function show($id)
    {
        $moduleName = $this->moduleName;
        $order = Order::with('product')->where('order_id', $id)->get();
        $category = Category::get();
        $product = Product::get();
        $city = City::get();
        $dealer = Dealer::get();
        return view($this->view.'/view', compact('product', 'moduleName', 'category', 'city', 'dealer', 'order'));
    }

}
