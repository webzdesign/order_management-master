<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebService;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaceMail;

class WebServiceController extends Controller
{
    public function __construct(){
        $this->WebService = new WebService();
    }

    public function index(Request $request)
    {
        $Data = json_decode(stripslashes(htmlspecialchars_decode(urldecode($request->reqObject))));

        $Task     = $Data->task;
        $TaskData = $Data->taskData;
        if ($Task != "") {
            switch ($Task) {
                case 'Login':
                    return $this->WebService->login($TaskData);
                    break;
                case 'Logout':
                    return $this->WebService->logout($TaskData);
                    break;
                case 'CityList':
                    return $this->WebService->CityList($TaskData);
                    break;
                case 'Dealer':
                    return $this->WebService->Dealer($TaskData);
                    break;
                case 'AddOrder':
                    return $this->WebService->AddOrder($TaskData);
                    break;
                case 'OrderStatus':
                    return $this->WebService->OrderStatus($TaskData);
                    break;
                case 'Category':
                    return $this->WebService->Category($TaskData);
                    break;
                case 'Product':
                    return $this->WebService->Product($TaskData);
                    break;
                case 'SearchDealer':
                    return $this->WebService->SearchDealer($TaskData);
                    break;
                case 'OrderDetail':
                    return $this->WebService->OrderDetail($TaskData);
                    break;
            }
        } else {
            echo "No task Found";
        }
    }
}
