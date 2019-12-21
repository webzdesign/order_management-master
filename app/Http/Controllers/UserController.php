<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Helper;
use DataTables;

class UserController extends Controller
{
    public $route='user';
    public $view ='user';
    public $moduleName = 'User';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;

        return view($this->view.'/index', compact('route', 'moduleName'));
    }

    public function getUserData()
    {
        return DataTables::eloquent(User::query())
            ->addColumn('action', function ($user) {
                if($user->name != 'Admin'){
                    $editUrl = route('user.edit', encrypt($user->id));
                    $action = "<a href='".$editUrl."' class='btn btn-warning  btn-xs'><i class='fa fa-pencil'></i> Edit</a>";

                    if ($user->status == '0') {
                        $activeUrl = url('useractivedeactive/active/'.$user->id);
                        $action .= "<a id='active' href='".$activeUrl."' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Activate</a>";
                    } else {
                        $deactiveUrl = url('useractivedeactive/deactive/'.$user->id);
                        $action .= "<a id='deactive' href='".$deactiveUrl."' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> Deactivate</a>";
                    }
                    return $action;
                }
            })

            ->editColumn('status', function($user) {
                if ($user->status == '0') {
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

    public function useractivedeactive($type,$id)
    {
        if ($type == 'active') {
            User::where('id', $id)->update(['status'=>'1']);
            Helper::activeDeactiveMsg('active', $this->moduleName);
        } else {
            User::where('id', $id)->update(['status'=>'0']);
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
        if(isset($request->display))
        {
            User::create(['name'=> ucwords($request->name), 'email'=>$request->email, 'password'=> bcrypt($request->password), 'status'=>$request->status, 'display'=>$request->display ]);
        }
        else {
            User::create(['name'=> ucwords($request->name), 'email'=>$request->email, 'password'=> bcrypt($request->password), 'status'=>$request->status, 'display'=> 0 ]);
        }
        Helper::successMsg('insert', $this->moduleName);
        return redirect($this->route);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $user = User::find(decrypt($id));

        return view($this->view.'/_form', compact('user', 'moduleName'));
    }


    public function update(Request $request, $id)
    {
        if(isset($request->display))
        {
            User::find($id)->update(['name' => ucwords($request->name), 'email' => $request->email, 'password' => bcrypt($request->password), 'status' => $request->status,  'display'=>$request->display ]);
        }
        else {
            User::find($id)->update(['name' => ucwords($request->name), 'email' => $request->email, 'password' => bcrypt($request->password), 'status' => $request->status,  'display'=> 0 ]);
        }
        

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

    public function checkUserEmail(Request $request)
    {
        if (!isset($request->id)) {
            $checkUser = User::where('email', trim($request->email))->count();
        } else {
            $checkUser = User::where('email', trim($request->email))->where('id', '!=', $request->id)->count();
        }

        if ($checkUser > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

}
