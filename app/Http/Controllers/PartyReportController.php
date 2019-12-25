<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Order;
use App\Models\Party;
use Helper, DataTables;

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
        //$partyreport->get();
        echo "<pre>";
        print_r($partyreport->get()->toArray());
        echo "</pre>";
        exit;

        return DataTables::eloquent($partyreport)
            ->addColumn('stockitem.name', function ($inventorystocks) {
                    return $inventorystocks->name;
            })
            ->addColumn('stock_in', function ($inventorystocks) {
                    return $inventorystocks->qty;
            })
            ->addColumn('stock_out', function ($inventorystocks) {
                    return Helper::getStockOut(
                        $inventorystocks->stockcategory->id, $inventorystocks->id
                    );
            })
            ->addColumn('qty', function ($inventorystocks) {
                    return ($inventorystocks->qty - Helper::getStockOut(
                        $inventorystocks->stockcategory->id, $inventorystocks->id
                    )
                );
            })
            ->rawColumns(['stock_in', 'stock_out'])
            ->addIndexColumn()
            ->make(true);
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
