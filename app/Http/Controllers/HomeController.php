<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $moduleName = 'Dashboard';
        $userCount = User::where('status',1)->count();
        $dealerCount = Dealer::where('status',1)->count();
        $productCount = Product::where('status',1)->count();
        $orderCount = Order::count();
        return view('home', compact('moduleName', 'userCount', 'dealerCount', 'productCount', 'orderCount'));
    }
}
