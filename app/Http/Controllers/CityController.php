<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use Helper;
use DataTables;

class CityController extends Controller
{
    public $route = 'city';
    public $view = 'city';
    public $moduleName = 'City';

    public function index()
    {
        $moduleName = $this->moduleName;

        return view($this->view.'/index', compact('moduleName'));
    }

    public function getCityData()
    {
        $city = City::with(['state', 'user'])->select('cities.*');
        return DataTables::eloquent($city)
        ->addColumn('action', function ($city) {

            $action = '';
            if (auth()->user()->hasPermission('edit.cities')) {
                $editUrl = route('city.edit', encrypt($city->id));
                $action .=  "<a href='".$editUrl."' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> ".trans('state.btn.Edit')."</a>";
            }

            if (auth()->user()->hasPermission('activeinactive.cities')) {
                if ($city->status == '0') {
                    $activeUrl = url('cityActiveInactive/active/'.$city->id);
                    $action .= "<a id='active' href='".$activeUrl."' class='btn btn-success btn-xs'><i class='fa fa-check'></i> ".trans('state.btn.Active')."</a>";
                } else {
                    $deactiveUrl = url('cityActiveInactive/deactive/'.$city->id);
                    $action .= "<a id='deactive' href='".$deactiveUrl."' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> ".trans('state.btn.Deactive')."</a>";
                }
            }

            return $action;
        })
        ->editColumn('status', function ($city) {
            if ($city->status == 1) {
                return "<span class='label label-success' style='font-size: 12px;'>Activate</span>";
            } else {
                return "<span class='label label-danger' style='font-size: 12px;'>Deactivate</span>";
            }
        })
        ->rawColumns(['action', 'status'])
        ->addIndexColumn()
        ->make(true);
    }


    public function create()
    {
        $moduleName = $this->moduleName;
        $states = State::select('id', 'name')->active()->get();

        return view($this->view.'/form', compact('moduleName', 'states'));
    }


    public function store(Request $request)
    {
        City::create(['state_id' => $request->state_id, 'name'=> ucwords($request->name), 'status' => $request->status, 'added_by' => auth()->user()->id]);

        Helper::successMsg('custom', trans('city.message.insert'));
        return redirect($this->route);
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $city = City::find(decrypt($id));
        $states = State::select('id', 'name')->active()->get();

        return view($this->view.'/_form', compact('city', 'moduleName', 'states'));
    }

    public function update(Request $request, $id)
    {
        City::find($id)->update(['state_id' => $request->state_id, 'name' => ucwords($request->name), 'status' => $request->status, 'updated_by' => auth()->user()->id]);

        Helper::successMsg('custom', trans('city.message.update'));
        return redirect($this->route);
    }

    public function checkCityName(Request $request)
    {
        if (!isset($request->id)) {
            $checkCity = City::where('name', $request->name)->count();
        } else {
            $checkCity = City::where('name', $request->name)->where('id', '!=', $request->id)->count();
        }
        if ($checkCity > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function cityActiveInactive($type, $id)
    {
        if ($type == 'active') {
            City::where('id', $id)->update(['status' => 1]);
            Helper::activeDeactiveMsg('active', trans('city.message.active'));
        } else {
            City::where('id', $id)->update(['status' => 0]);
            Helper::activeDeactiveMsg('inactive', trans('city.message.deactive'));
        }
        return redirect($this->route);
    }
}
