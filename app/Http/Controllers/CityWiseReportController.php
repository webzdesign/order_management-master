<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Party;
use App\Models\Order;
use Helper, DataTables;
use DB, PDF;

class CityWiseReportController extends Controller
{
    public $route = 'citywisereport';
    public $view = 'citywisereport';
    public $moduleName = 'City Wise Report';

    public function index()
    {
        $moduleName = $this->moduleName;
        $state = State::select('id', 'name')->active()->get();
        return view($this->view.'/index', compact('moduleName', 'state'));
    }

    public function getCityWiseReportData(Request $request)
    {
        $cityreport = Order::with('party');
        if (($request->state) && ($request->city)) {
            $cityreport->whereHas('party', function($query) use ($request) {
                $query->where('state_id', $request->state);
                $query->where('city_id', $request->city);
            });
        } 
        if (($request->from) && ($request->to)){
            $cityreport->where('date', '>=', date('Y-m-d', strtotime($request->from)))->where('date', '<=', date('Y-m-d',strtotime($request->to)));
        }
     
        return DataTables::eloquent($cityreport)
            ->editColumn('date', function($cityreport){
                return date('d-m-Y', strtotime($cityreport->date));
            })
            ->editColumn('grand_total', function($cityreport){
                return number_format($cityreport->grand_total,2); 
            })
            ->rawColumns(['date', 'grand_total'])
            ->addIndexColumn()
            ->make(true);
    }

    public function printCityWiseReport(Request $request)
    {
        $cityreport = Order::with('party');
        
        if (($request->state) && ($request->city)) {
            $cityreport->whereHas('party', function($query) use ($request) {
                $query->where('state_id', $request->state);
                $query->where('city_id', $request->city);
            });
        } 
        if (($request->from) && ($request->to)){
            $cityreport->where('date', '>=', date('Y-m-d', strtotime($request->from)))->where('date', '<=', date('Y-m-d',strtotime($request->to)));
        }
        $cityreport = $cityreport->get();        

        $html = view($this->view.'.print', compact('cityreport'))->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }

    public function getReportStateCity(Request $request)
    {
        $city = City::active()->where('state_id', $request->state_id)->pluck('name', 'id');
        return json_encode($city);
    }

}
