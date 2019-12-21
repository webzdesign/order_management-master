<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\User;
use App\Models\Dealer;
use Helper;
use DataTables;

class DealerController extends Controller
{
    public $route='dealer';
    public $view ='dealer';
    public $moduleName = 'Dealer';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;

        return view($this->view.'/index', compact('route', 'moduleName'));
    }

    public function getDealerData()
    {
        $dealer = Dealer::with(['city','user']);
        
        return DataTables::eloquent($dealer)
            ->addColumn('action', function ($dealer) {
                $editUrl = route('dealer.edit', encrypt($dealer->id));
                $action = "<a href='".$editUrl."' class='btn btn-warning  btn-xs'><i class='fa fa-pencil'></i> Edit</a>";

                if ($dealer->status == '0') {
                    $activeUrl = url('dealeractivedeactive/active/'.$dealer->id);
                    $action .= "<a id='active' href='".$activeUrl."' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Activate</a>";
                } else {
                    $deactiveUrl = url('dealeractivedeactive/deactive/'.$dealer->id);
                    $action .= "<a id='deactive' href='".$deactiveUrl."' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> Deactivate</a>";
                }
                return $action;
            })

            ->editColumn('status', function($dealer) {
                if ($dealer->status == '0') {
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

    public function dealeractivedeactive($type,$id)
    {
        if ($type == 'active') {
            Dealer::where('id', $id)->update(['status'=>'1']);
            Helper::activeDeactiveMsg('active', $this->moduleName);
        } else {
            Dealer::where('id', $id)->update(['status'=>'0']);
            Helper::activeDeactiveMsg('deactive', $this->moduleName);
        }
        return redirect($this->route);
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        $city = City::get();
        $user = User::where('email','!=','admin@admin.com')->get();
        return view($this->view.'/form', compact('moduleName', 'city', 'user'));
    }


    public function store(Request $request)
    {
        Dealer::create(['city_id'=>$request->city_id, 'user_id'=>$request->user_id, 'name'=> ucwords($request->name), 'status'=>$request->status]);

        Helper::successMsg('insert', $this->moduleName);
        return redirect($this->route);
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $dealer = Dealer::find(decrypt($id));
        $city = City::get();
        $user = User::where('email','!=','admin@admin.com')->get();
        return view($this->view.'/_form', compact('dealer', 'moduleName', 'city', 'user'));
    }


    public function update(Request $request, $id)
    {
        Dealer::find($id)->update(['city_id'=>$request->city_id, 'user_id'=>$request->user_id, 'name' => ucwords($request->name), 'status'=>$request->status]);

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

}
