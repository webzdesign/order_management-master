<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Helper;
use DataTables;

class CategoryController extends Controller
{
    public $route='category';
    public $view ='category';
    public $moduleName = 'Category';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view.'/index', compact('moduleName'));
    }

    public function getCategoryData()
    {
        $category = Category::with('user')->select('categories.*');
        return DataTables::eloquent($category)
            ->addColumn('action', function ($category) {
                $editUrl = route('category.edit', encrypt($category->id));
                if (auth()->user()->hasPermission('edit.category')) {
                    $action = "<a href='".$editUrl."' class='btn btn-warning  btn-xs'><i class='fa fa-pencil'></i> Edit</a>";
                }

                if (auth()->user()->hasPermission('activeinactive.category')) {
                    if ($category->status == '0') {
                        $activeUrl = url('categoryactivedeactive/active/'.$category->id);
                        $action .= "<a id='active' href='".$activeUrl."' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Activate</a>";
                    } else {
                        $deactiveUrl = url('categoryactivedeactive/deactive/'.$category->id);
                        $action .= "<a id='deactive' href='".$deactiveUrl."' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> Deactivate</a>";
                    }
                }
                return $action;
            })

            ->editColumn('status', function($category) {
                if ($category->status == '0') {
                    $status = '<label class="label label-danger">Deactivate</label>';
                } else{
                    $status = '<label class="label label-success">Activate</label>';
                }
                return $status;
            })

            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->make(true);
    }

    public function categoryactivedeactive($type,$id)
    {
        if ($type == 'active') {
            Category::where('id', $id)->update(['status'=>'1']);
            Helper::activeDeactiveMsg('active', $this->moduleName);
        } else {
            Category::where('id', $id)->update(['status'=>'0']);
            Helper::activeDeactiveMsg('deactive', $this->moduleName);
        }
        return redirect($this->route);
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        return view($this->view.'/form', compact('moduleName'));
    }

    public function store(Request $request)
    {
        if($request->hasFile('image')){
            $imageName =  $request->file('image')->store('category');
        } else {
            $imageName = '';
        }
        Category::create(['name'=> ucwords($request->name), 'image' => $imageName,'status'=>$request->status, 'added_by' => auth()->user()->id]);

        Helper::successMsg('insert', $this->moduleName);
        return redirect($this->route);
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $category = Category::find(decrypt($id));
        return view($this->view.'/_form', compact('category', 'moduleName'));
    }

    public function update(Request $request, $id)
    {
        if($request->hasFile('image'))
        {
            $oldfile_name = $request->input('old_filename');
            $image = $request->file('image');
            $imageName =  $request->file('image')->store('category');
            if($oldfile_name != NULL){
                unlink(storage_path('app/').$oldfile_name);
            }
        }else{
            $imageName = $request->input('old_filename');
        }

        Category::find($id)->update(['name'=> ucwords($request->name), 'image' => $imageName,'status'=>$request->status, 'updated_by' => auth()->user()->id]);

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

    public function checkCategoryName(Request $request)
    {
        if (!isset($request->id)) {
            $checkCategory = Category::where('name', trim($request->name))->count();
        } else {
            $checkCategory = Category::where('name', trim($request->name))->where('id', '!=', $request->id)->count();
        }

        if ($checkCategory > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

}
