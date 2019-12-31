<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Http\Request;
use Helper, DataTables, DB;


class RoleController extends Controller
{
    public $route='role';
    public $view ='role';
    public $moduleName = 'Role';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;
        $roles = Role::find(1);
        return view($this->view.'/index', compact('route', 'moduleName', 'roles'));
    }

    public function getRoleData()
    {
        return DataTables::eloquent(Role::query())
        ->addColumn(
            'action',
            function ($role) {
                $editUrl = route('role.edit', encrypt($role->id));
                $action = '';

                if ($role->id == 1) {
                    $action =  "<a class='btn btn-success btn-xs'>".trans('role.btn.Super_Admin')."</a>";
                } else if ($role->id == 2) {
                    $action =  "<a class='btn btn-success btn-xs'>".trans('role.btn.Admin')."</a>";
                } else {
                    if (auth()->user()->hasPermission('edit.roles')) {
                        $action =  "<a href='".$editUrl."'
                                    class='btn btn-warning btn-xs'>
                                    <i class='fa fa-pencil'></i>".trans('role.btn.Edit')." </a>";
                    }
                }
                return $action;
            }
        )
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        $permissions = Permission::get()->groupBy('model');
        

        return view($this->view.'/form', compact('moduleName', 'permissions'));
    }
    
    public function store(Request $request)
    {
        $role = Role::create(
            [
                'name' => ucwords($request->name),
                'slug' => str_slug($request->name),
                'description' => $request->description,
                'level' => 1
            ]
        );

        $role->attachPermission($request->permission);

        Helper::successMsg('custom', trans('role.alert.insert'));
        return redirect($this->route);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $role = Role::find(decrypt($id));
        $permissions = Permission::get()->groupBy('model');
        $existPermission = DB::table('permission_role')
            ->where('role_id', decrypt($id))->pluck('permission_id')->toArray();

                
        return view($this->view.'/_form', compact('role', 'moduleName', 'permissions', 'existPermission'));
    }
    
    public function update(Request $request, $id)
    {
        Role::find($id)->update(
            [
                'name' => ucwords($request->name),
                'slug' => str_slug($request->name),
                'description' => $request->description,
                'level' => 1
            ]
        );

        $role = Role::findOrFail($id);
        $role->syncPermissions($request->permission);

        Helper::successMsg('custom', trans('role.alert.update'));
        
        return redirect($this->route);   
    }
    
    public function destroy($id)
    {
        //
    }

    public function checkRoleName(Request $request)
    {
        if (!isset($request->id)) {
            $checkRole = Role::where('name', trim($request->name))->count();
        } else {
            $checkRole = Role::where('name', trim($request->name))
            ->where('id', '!=', $request->id)->count();
        }

        if ($checkRole > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
}
