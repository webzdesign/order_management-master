<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Dealer;
use Helper;
use DataTables;

class CityController extends Controller
{
    public $route='city';
    public $view ='city';
    public $moduleName = 'City';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;

        return view($this->view.'/index', compact('route', 'moduleName'));
    }

    public function getCityData()
    {
        return DataTables::eloquent(City::query())
        ->addColumn('action', function ($city) {

            $editUrl = route('city.edit', encrypt($city->id));
            return "<a href='".$editUrl."' class='btn btn-warning  btn-xs'><i class='fa fa-pencil'></i> Edit</a><a class='btn btn-danger  btn-xs confirm-delete' data-id='$city->id' ><i class='fa fa-trash'></i> Delete</a>";
        })
        ->addIndexColumn()
        ->make(true);
    }


    public function create()
    {
        $moduleName = $this->moduleName;

        return view($this->view.'/form', compact('moduleName'));
    }


    public function store(Request $request)
    {
        City::create(['name'=> ucwords($request->name)]);

        Helper::successMsg('insert', $this->moduleName);
        return redirect($this->route);
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $city = City::find(decrypt($id));

        return view($this->view.'/_form', compact('city', 'moduleName'));
    }

    public function update(Request $request, $id)
    {
        City::find($id)->update(['name' => ucwords($request->name)]);

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

    public function destroy($id)
    {
        $dealercount = Dealer::where('city_id', $id)->count();
        if($dealercount > 0){
            echo json_encode(false);
        }
        else{
            if (City::findOrFail($id)->delete()) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }
    }

    public function checkCityName(Request $request)
    {
        $name =$request->name;

        if(!isset($request->id)){
            $cnt=City::where('name',$name)->count();
        } else {
            $cnt=City::where('name',$name)->where('id','!=',$request->id)->count();
        }
        if($cnt>0)
        {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
}
