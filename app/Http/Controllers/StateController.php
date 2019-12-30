<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use Helper;
use DataTables;

class StateController extends Controller
{
    public $route = 'state';
    public $view = 'state';
    public $moduleName = 'State';

    public function index()
    {
        $moduleName = $this->moduleName;

        return view($this->view.'/index', compact('moduleName'));
    }

    public function getStateData()
    {
        $state = State::with('user')->select('states.*');
        return DataTables::eloquent($state)
        ->addColumn('action', function ($state) {

            $action = '';
            if (auth()->user()->hasPermission('edit.states')) {
                $editUrl = route('state.edit', encrypt($state->id));
                $action .=  "<a href='".$editUrl."' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> ".trans('state.btn.Edit')." </a>";
            }

            if (auth()->user()->hasPermission('activeinactive.states')) {
                if ($state->status == '0') {
                    $activeUrl = url('stateActiveInactive/active/'.$state->id);
                    $action .= "<a id='active' href='".$activeUrl."' class='btn btn-success btn-xs'><i class='fa fa-check'></i> ".trans('state.btn.Active')."</a>";
                } else {
                    $deactiveUrl = url('stateActiveInactive/deactive/'.$state->id);
                    $action .= "<a id='deactive' href='".$deactiveUrl."' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> ".trans('state.btn.Deactive')."</a>";
                }
            }

            return $action;
        })
        ->editColumn('status', function ($state) {
            if ($state->status == 1) {
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

        return view($this->view.'/form', compact('moduleName'));
    }


    public function store(Request $request)
    {
        State::create(['name'=> ucwords($request->name), 'status' => $request->status, 'added_by' => auth()->user()->id]);
        Helper::successMsg('insert', $this->moduleName);

        return redirect($this->route);
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $state = State::find(decrypt($id));

        return view($this->view.'/_form', compact('state', 'moduleName'));
    }

    public function update(Request $request, $id)
    {
        State::find($id)->update(['name' => ucwords($request->name), 'status' => $request->status, 'updated_by' => auth()->user()->id]);

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

    public function checkStateName(Request $request)
    {
        if (!isset($request->id)) {
            $checkState = State::where('name', $request->name)->count();
        } else {
            $checkState = State::where('name', $request->name)->where('id', '!=', $request->id)->count();
        }
        if ($checkState > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function stateActiveInactive($type, $id)
    {
        if ($type == 'active') {
            State::where('id', $id)->update(['status' => 1]);
            Helper::activeDeactiveMsg('active', $this->moduleName);
        } else {
            State::where('id', $id)->update(['status' => 0]);
            Helper::activeDeactiveMsg('inactive', $this->moduleName);
        }
        return redirect($this->route);
    }
}
