<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Helper;
use DataTables;

class ProductController extends Controller
{
    public $route='product';
    public $view ='product';
    public $moduleName = 'Product';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view.'/index', compact('moduleName'));
    }

    public function getProductData()
    {
        $product = Product::with(['category','user']);
        return DataTables::eloquent($product)
            ->addColumn('action', function ($product) {
                $editUrl = route('product.edit', encrypt($product->id));
                if (auth()->user()->hasPermission('edit.product')) {
                    $action = "<a href='".$editUrl."' class='btn btn-warning  btn-xs'><i class='fa fa-pencil'></i> Edit</a>";
                }
                if (auth()->user()->hasPermission('activeinactive.product')) {
                    if ($product->status == '0') {
                        $activeUrl = url('productactivedeactive/active/'.$product->id);
                        $action .= "<a id='active' href='".$activeUrl."' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Activate</a>";
                    } else {
                        $deactiveUrl = url('productactivedeactive/deactive/'.$product->id);
                        $action .= "<a id='deactive' href='".$deactiveUrl."' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> Deactivate</a>";
                    }
                }
                return $action;
            })

            ->editColumn('status', function($product) {
                if ($product->status == '0') {
                    $status = '<label class="label label-danger">Deactivate</label>';
                } else{
                    $status = '<label class="label label-success">Activate</label>';
                }
                return $status;
            })
            ->editColumn('image', function($product){
                if($product->image == ''){
                    return "<a href=".url('/storage/app/product/saral_logo.jpg')." target='_blank'><image src = ".url('/storage/app/product/saral_logo.jpg')." width='50px'></a>";
                } else {
                    return "<a href=".url('/storage/app/'.$product->image)." target='_blank'><image src = ".url('/storage/app/'.$product->image)." width='50px'></a>";
                }

            })

            ->rawColumns(['action', 'status', 'image'])
            ->addIndexColumn()
            ->make(true);
    }

    public function productactivedeactive($type,$id)
    {
        if ($type == 'active') {
            Product::where('id', $id)->update(['status'=>'1']);
            Helper::activeDeactiveMsg('active', $this->moduleName);
        } else {
            Product::where('id', $id)->update(['status'=>'0']);
            Helper::activeDeactiveMsg('deactive', $this->moduleName);
        }
        return redirect($this->route);
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        $category = Category::select('id', 'name')->active()->get();
        return view($this->view.'/form', compact('moduleName', 'category'));
    }

    public function store(Request $request)
    {
        if($request->hasFile('image')){
            $imageName =  $request->file('image')->store('product');
        } else {
            $imageName = '';
        }

        $productInsertedId = Product::create(['category_id'=>$request->category_id, 'name'=> ucwords($request->name), 'image'=>$imageName, 'op_stock' => $request->op_stock, 'price' => $request->price, 'added_by'=>auth()->user()->id, 'status'=>$request->status]);

        Stock::create(['transaction_id' => $productInsertedId->id, 'voucher'=> '0', 'product_id'  => $productInsertedId->id, 'qty'=> $request->op_stock, 'type'=>'0', 'added_by'=>auth()->user()->id]);

        Helper::successMsg('insert', $this->moduleName);
        return redirect($this->route);
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $product = Product::find(decrypt($id));
        $category = Category::select('id', 'name')->active()->get();
        return view($this->view.'/_form', compact('product', 'moduleName', 'category'));
    }

    public function update(Request $request, $id)
    {

        if($request->hasFile('image'))
        {
            $oldfile_name = $request->input('old_filename');
            $image = $request->file('image');
            $imageName =  $request->file('image')->store('product');
            if($oldfile_name != NULL){
                unlink(storage_path('app/').$oldfile_name);
            }

        }else{
            $imageName = $request->input('old_filename');
        }

        Product::find($id)->update(['category_id'=>$request->category_id, 'name'=> ucwords($request->name), 'image'=>$imageName, 'op_stock' => $request->op_stock, 'price' => $request->price, 'updated_by'=>auth()->user()->id, 'status'=>$request->status]);


        Stock::where('transaction_id', $id)->update(['transaction_id' => $id, 'voucher'=> '0', 'product_id'  => $id, 'qty'=> $request->op_stock, 'type'=>'0', 'updated_by'=>auth()->user()->id]);

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

    public function checkProductName(Request $request)
    {
        if (!isset($request->id)) {
            $checkProduct = Product::where('name', trim($request->name))->count();
        } else {
            $checkProduct = Product::where('name', trim($request->name))->where('id', '!=', $request->id)->count();
        }

        if ($checkProduct > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

}
