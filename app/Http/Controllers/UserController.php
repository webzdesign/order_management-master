<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use App\User;
use Helper;
use DataTables, DB;

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
        $users = User::with('roles')->select('users.*');
        return DataTables::eloquent($users)
            ->addColumn('action', function ($user) {
                $action = "";
                if($user->name != 'Admin' && $user->name !='Super Admin'){
                    $editUrl = route('user.edit', encrypt($user->id));
                    if (auth()->user()->hasPermission('edit.users')) {
                        $action = "<a href='".$editUrl."' class='btn btn-warning  btn-xs'><i class='fa fa-pencil'></i> ".trans('user.btn.Edit')." </a>";
                    }

                    if (auth()->user()->hasPermission('activeinactive.users')) {
                        if ($user->status == '0') {
                            $activeUrl = url('useractivedeactive/active/'.$user->id);
                            $action .= "<a id='active' href='".$activeUrl."' class='btn btn-success btn-xs'><i class='fa fa-check'></i> ".trans('user.btn.Active')."</a>";
                        } else {
                            $deactiveUrl = url('useractivedeactive/deactive/'.$user->id);
                            $action .= "<a id='deactive' href='".$deactiveUrl."' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> ".trans('user.btn.Deactive')."</a>";
                        }
                    }
                    return $action;
                } else if ($user->name == 'Admin') {
                    $action .=  "<a class='btn btn-success btn-xs'>".trans('user.btn.Admin')."</a>";
                    return $action;
                } else if ($user->name == 'Super Admin') {
                    $action .=  "<a class='btn btn-success btn-xs'>".trans('user.btn.Super_Admin')."</a>";
                    return $action;
                }
            })
            ->editColumn('user.role', function($user){
                return $user->roles()->first()->name; 
            })
            ->editColumn('status', function($user) {
                if ($user->status == '0') {
                    $status = '<label class="label label-danger"> '.trans("user.deactive").'</label>';
                } else{
                    $status = '<label class="label label-success"> '.trans("user.active").'</label>';
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
            Helper::activeDeactiveMsg('active', trans('user.alert.activate'));
        } else {
            User::where('id', $id)->update(['status'=>'0']);
            Helper::activeDeactiveMsg('deactive', trans('user.alert.deactivate'));
        }
        return redirect($this->route);
    }


    public function create()
    {
        $role_details = Role::whereNotIn('id', [1,2])->get();
        $moduleName = $this->moduleName;
        $permissions = Permission::get()->groupBy('model');
        return view($this->view.'/form', compact('moduleName', 'role_details', 'permissions'));
    }


    public function store(Request $request)
    {
        $roles = Role::find($request->role);
        
        $user = new User();
        $user->name         = ucwords($request->name); 
        $user->email        = $request->email;
        $user->password     = bcrypt($request->password); 
        $user->status       = $request->status; 
        $user->save();
        $user->attachRole($roles);
        $user->attachPermission($request->permission);
             
        Helper::successMsg('custom', trans('user.alert.insert'));
        return redirect($this->route);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user = User::with('roles')->where('id',decrypt($id))->select('users.*')->first();
        $role_details = Role::whereNotIn('id', [1,2])->get();
        $moduleName = $this->moduleName;
        $permissions = Permission::get()->groupBy('model');
        $existPermission = DB::table('permission_user')
            ->where('user_id', decrypt($id))->pluck('permission_id')->toArray();
        
        return view($this->view.'/_form', compact('user', 'moduleName', 'role_details', 'permissions', 'existPermission'));
    }


    public function update(Request $request, $id)
    {
        $roles = Role::find($request->role);

        $user = User::find($id);
        $user->name         = ucwords($request->name); 
        $user->email        = $request->email;
        $user->password     = bcrypt($request->password); 
        $user->status       = $request->status; 
        $user->save();
        $user->syncPermissions($roles);
        $user->syncPermissions($request->permission);

        Helper::successMsg('custom', trans('user.alert.update'));
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
