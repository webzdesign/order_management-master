<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Http\Request;
use Helper, DataTables;

class RoleController extends Controller
{
    public $route='role';
    public $view ='role';
    public $moduleName = 'Role';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;
        return view($this->view.'/index', compact('route', 'moduleName'));
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
                    $action =  "<a class='btn btn-success btn-xs'>Super Admin
                                </a>";
                } else {
                    if (auth()->user()->hasPermission('edit.roles')) {
                        $action =  "<a href='".$editUrl."'
                                    class='btn btn-warning btn-xs'>
                                    <i class='fa fa-pencil'></i> Edit</a>";
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
        //
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        //
    }
    
    public function update(Request $request, Role $role)
    {
        //
    }
    
    public function destroy(Role $role)
    {
        //
    }
}
