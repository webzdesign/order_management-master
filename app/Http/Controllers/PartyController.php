<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use Helper;
use DataTables;

class PartyController extends Controller
{
    public $route = 'party';
    public $view = 'party';
    public $moduleName = 'Party';

    public function index()
    {
        $moduleName = $this->moduleName;

        return view($this->view.'/index', compact('moduleName'));
    }

    public function getPartyData()
    {
        $party = Party::with(['user'])->select('parties.*');
        return DataTables::eloquent($party)
        ->addColumn('action', function ($party) {

            $action = '';
            if (auth()->user()->hasPermission('edit.parties')) {
                $editUrl = route('parties.edit', encrypt($party->id));
                $action .=  "<a href='".$editUrl."' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Edit</a>";
            }

            if (auth()->user()->hasPermission('activeinactive.parties')) {
                if ($party->status == '0') {
                    $activeUrl = url('partyActiveInactive/active/'.$party->id);
                    $action .= "<a id='active' href='".$activeUrl."' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Activate</a>";
                } else {
                    $deactiveUrl = url('partyActiveInactive/deactive/'.$party->id);
                    $action .= "<a id='deactive' href='".$deactiveUrl."' class='btn btn-danger btn-xs'><i class='fa fa-times'></i> Deactivate</a>";
                }
            }

            return $action;
        })
        ->editColumn('status', function ($party) {
            if ($party->status == 1) {
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
        Party::create(['state_id' => $request->state_id, 'city_id' => $request->city_id, 'name'=> ucwords($request->name), 'mobile_no' => $request->mobile_no, 'address' => $request->address, 'status' => $request->status, 'added_by' => auth()->user()->id]);

        Helper::successMsg('insert', $this->moduleName);
        return redirect($this->route);
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $party = Party::find(decrypt($id));
        $states = State::select('id', 'name')->active()->get();

        return view($this->view.'/_form', compact('party', 'moduleName', 'states'));
    }

    public function update(Request $request, $id)
    {
        Party::find($id)->update(['state_id' => $request->state_id, 'city_id' => $request->city_id, 'name'=> ucwords($request->name), 'mobile_no' => $request->mobile_no, 'address' => $request->address, 'status' => $request->status, 'updated_by' => auth()->user()->id]);

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

    public function checkPartyMobile(Request $request)
    {
        if (!isset($request->id)) {
            $checkParty = Party::where('mobile_no', $request->mobile_no)->count();
        } else {
            $checkParty = Party::where('mobile_no', $request->mobile_no)->where('id', '!=', $request->id)->count();
        }
        if ($checkParty > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function partyActiveInactive($type, $id)
    {
        if ($type == 'active') {
            Party::where('id', $id)->update(['status' => 1]);
            Helper::activeDeactiveMsg('active', $this->moduleName);
        } else {
            Party::where('id', $id)->update(['status' => 0]);
            Helper::activeDeactiveMsg('inactive', $this->moduleName);
        }
        return redirect($this->route);
    }
}
