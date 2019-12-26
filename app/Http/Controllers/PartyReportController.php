<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Order;
use App\Models\Party;
use Helper, DataTables;
use DB;
class PartyReportController extends Controller
{
    public $route = 'partyreport';
    public $view = 'partyreport';
    public $moduleName = 'Party Report';

    public function index()
    {
        $moduleName = $this->moduleName;
        $party = Party::select('id', 'name', 'mobile_no')->active()->get();
        $states = State::select('id', 'name')->active()->get();
        $city = City::select('id', 'name')->active()->get();
        return view($this->view.'/index', compact('moduleName', 'party', 'states', 'city'));   
    }

    public function getPartyReportData(Request $request)
    {
        $partyreport = Order::with(['party']);
        if ($party = $request->party) {
            if ($party != '') {
                $partyreport->where('party_id', $party);
            }
        } 
        $partyreport->where('date', '>=', date('Y-m-d', strtotime($request->from)))->where('date', '<=', date('Y-m-d',strtotime($request->to)));
     
        return DataTables::eloquent($partyreport)
            ->editColumn('date', function($partyreport){
                return date('d-m-Y', strtotime($partyreport->date));
            })
            ->editColumn('amount', function($partyreport){
                return '₹'.number_format($partyreport->amount,2); 
            })
            ->rawColumns(['date', 'amount'])
            ->addIndexColumn()
            ->make(true);
    }

    function convertToObject($array) {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
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
