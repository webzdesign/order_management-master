<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Order;
use App\Models\Party;
use Helper, DataTables;
use DB, PDF;
class PartyReportController extends Controller
{
    public $route = 'partywisereport';
    public $view = 'partywisereport';
    public $moduleName = 'Party Wise Report';

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
            ->editColumn('grand_total', function($partyreport){
                return number_format($partyreport->grand_total,2); 
            })
            ->rawColumns(['date', 'grand_total'])
            ->addIndexColumn()
            ->make(true);
    }

    public function printPartyReport(Request $request)
    {
        $partyreport = Order::with(['party']);
        if ($party = $request->party) {
            if ($party != '') {
                $partyreport->where('party_id', $party);
            }
        } 
        $partyreport->where('date', '>=', date('Y-m-d', strtotime($request->from)))->where('date', '<=', date('Y-m-d',strtotime($request->to)));
        $partyreport = $partyreport->get();

        $html = view($this->view.'.print', compact('partyreport'))->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
    
}
