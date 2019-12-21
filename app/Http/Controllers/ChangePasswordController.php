<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Helper;

class ChangePasswordController extends Controller
{
    public $route='changepassword';
    public $moduleName ='Change Password';
    public $view ='changePassword';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;

        return view($this->view.'.index', compact('route', 'moduleName'));
    }

    public function changePassword(Request $request)
    {
        User::findorFail(1)->update(['password' => Hash::make($request->password)]);

        Helper::successMsg('update', 'Password');
        return redirect($this->route);
    }

    public function checkOldPassword(Request $request)
    {
        $oldpassword = $request->old_password;
        $user = User::findorFail(1);

        if (!Hash::check($oldpassword, $user->password)) {
            echo(json_encode(false));
        } else {
            echo(json_encode(true));
        }
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
