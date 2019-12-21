<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Order;
use App\Models\City;
use App\Models\Dealer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Login_log;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaceMail;

class WebService extends Model
{
    /* reqObject = {"task":"Login","taskData":{"email":"jinal@gmail.com","password":"123456"}} */
    public function login($TaskData)
    {
        if (isset($TaskData->email) && $TaskData->email != '' && isset($TaskData->password) && $TaskData->password != '') {

            $email = $TaskData->email;
            $password = $TaskData->password;
            $token = str_random(32);

            if ($email != '' && $password != '') {

                if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {

                    $user = Auth::user();
                    Login_log::updateOrCreate(['user_id' => $user->id], ['user_id' => $user->id, 'session_token' => $token]);

                    $user->session_token = $token;
                    $response["success"]=1;
                    $response["result"]=$user;
                    $response["message"]="Login Successfully.";

                } else {

                    $response["success"]=0;
                    $response["message"]="Invalid Credentials.";

                }

            } else {

                $response["success"]=0;
                $response["message"]="Some Fields Are Empty.";

            }

        } else {
            $response["success"]=0;
            $response["message"]="Some Fields Are Empty.";
        }

        return response()->json($response);
    }

    /* reqObject = {"task":"Logout","taskData":{"user_id":"2","session_token":"8hlNDj70iCjCaKOlpQnNoIkkQrMIsoyy"}} */
    public function logout($TaskData)
    {
        if (isset($TaskData->user_id) && $TaskData->user_id != '' && isset($TaskData->session_token) && $TaskData->session_token != '') {
            $userId = $TaskData->user_id;
            $session_token = $TaskData->session_token;

            Login_log::where('user_id', $userId)->update(['session_token' => null]);

            $response["success"]=1;
            $response["message"]="Logout Successfully.";
        } else {
            $response["success"]=0;
            $response["message"]="Some Fields Are Empty.";
        }
        return response()->json($response);
    }

    /* reqObject = {"task":"CityList","taskData":{"user_id":"2","session_token":"sMpISpKDc2PhwADk2f7QHIwu3rTycREJ", "dealer_id":"1"}} */
    public function CityList($TaskData)
    {
        $city = City::get();
        $cities = array();

        foreach($city as $key => $value){
            $cities[] = [
                'city_id' => $value->id,
                'name'    => $value->name,
            ];
        }

        if ($cities) {
            $response["success"]=1;
            $response["message"]= "Success";
            $response["result"]=$cities;
        } else {
            $response["success"]=0;
            $response["message"]="No Records.";
        }
        return response()->json($response);
    }

    /* reqObject = {"task":"AddOrder","taskData":{"user_id":"2","session_token":"Z5RWNqsHK4C7EQdVJumZI1pwYc7rOOur","product_id":[1,2],"qty":[10,20],"dealer_id":"1","city_id":"1","instruction":"Testing", "transporter":"Test Transporter"}} */
    public function AddOrder($TaskData)
    {
        if (isset($TaskData->user_id) && $TaskData->user_id != '' && isset($TaskData->session_token) && $TaskData->session_token != '' && isset($TaskData->dealer_id) && $TaskData->dealer_id != '' && isset($TaskData->city_id) && $TaskData->city_id != '' && isset($TaskData->instruction) && $TaskData->instruction != '' && isset($TaskData->qty) && !empty($TaskData->qty) && isset($TaskData->product_id) && !empty($TaskData->product_id) && isset($TaskData->transporter) && !empty($TaskData->transporter)) {

            $user_id = $TaskData->user_id;
            $session_token = $TaskData->session_token;
            $dealer_id = $TaskData->dealer_id;
            $city_id = $TaskData->city_id;
            $instruction = $TaskData->instruction;
            $qty = $TaskData->qty;
            $product_id = $TaskData->product_id;
            $transporter = $TaskData->transporter;

            $get_order = Order::orderBy('order_id', 'desc')->first();
            if(!$get_order) {
                $order_no = 'OR_'.'1';
                $order_id = 1;
            } else {
                $order_no = 'OR_'.($get_order->order_id + 1);
                $order_id = $get_order->order_id + 1;
            }

            for($j=0; $j<count($product_id); $j++){
                $addorder = new Order();
                $addorder->order_no = $order_no;
                $addorder->order_id = $order_id;
                $addorder->date = date('Y-m-d');
                $addorder->dealer_id = $dealer_id;
                $addorder->city_id = $city_id;
                $addorder->instruction = $instruction;
                $addorder->qty = $qty[$j];
                $addorder->remaining_qty = $qty[$j];
                $addorder->product_id = $product_id[$j];
                $addorder->user_id = $user_id;
                $addorder->transporter = $transporter;
                $addorder->save();
            }

            $productName = Product::whereIn('id', $product_id)->pluck('name')->toArray();
            $dealerName = Dealer::with('city')->where('id', $dealer_id)->first();
            $order_detail = Order::with(['user', 'city'])->where('order_id', $order_id)->get();

            $order = $order_no;
            $dealer = $dealerName->name;
            $city = $dealerName->city->name;
            $date = date('Y-m-d');
            $productName = implode(", ", $productName);
            $subject = 'Order Place';
            $description = 'Order Placed Successfully.. !';
           // order@saralgroup.com
            Mail::to('jinalgajera.ap@gmail.com')->cc(['saral@angelspearlinfotech.com'])->send(new OrderPlaceMail($order, $dealer, $city, $date, $productName, $subject, $description, $order_detail));

            $response["success"]=1;
            $response["message"]="Order Insert Successfully.";

        }else{
            $response["success"]=0;
			$response["message"]="Some Fields Are Empty.";
        }

        return response()->json($response);

    }

    /* reqObject = {"task":"OrderStatus","taskData":{"user_id":"2","session_token":"X31Iu3j2sOOEn1R7nH7bMmP2JN26ccTM"}} */
    public function OrderStatus($TaskData)
    {
        $order = Order::with(['user', 'product', 'city', 'dealer'])->groupBy('order_id')->orderby('order_id', 'DESC')->get();
        $orders = array();

        foreach($order as $key => $value){
            $orders[] = [
                'order_no'       => $value->order_no,
                'date'           => $value->date,
                'dealer_name'    => $value->dealer->name,
                'city_name'      => $value->city->name,
                'status'         => $value->status,
            ];
        }

        if ($orders) {
            $response["success"]=1;
            $response["message"]= "Success";
            $response["result"]=$orders;
        } else {
            $response["success"]=0;
            $response["message"]="No Records.";
        }

        return response()->json($response);
    }


    /* reqObject = {"task":"Dealer","taskData":{"user_id":"2","session_token":"8hlNDj70iCjCaKOlpQnNoIkkQrMIsoyy","city_id":"1"}} */
    public function Dealer($TaskData)
    {
        if (isset($TaskData->city_id) && $TaskData->city_id != '') {

            $dealers = Dealer::where('city_id', $TaskData->city_id)->get();

            $result = array();

            foreach($dealers as $key => $value){
                $result[] = [
                    'dealer_id' => $value->id,
                    'dealer_name'      => $value->name,
                ];
            }

            if ($result) {
                $response["success"]=1;
                $response["message"]= "Success";
                $response["result"]=$result;
            } else {
                $response["success"]=0;
                $response["message"]="No Records.";
            }
        } else {
            $response["success"]=0;
			$response["message"]="Some Fields Are Empty.";
        }

        return response()->json($response);
    }

    /* reqObject = {"task":"Category","taskData":{"user_id":"2","session_token":"X31Iu3j2sOOEn1R7nH7bMmP2JN26ccTM"}} */
    public function Category($TaskData)
    {
        $category = Category::where('status', 1)->get();
        $categories = array();

        foreach($category as $key => $value){
            $categories[] = [
                'category_id' => $value->id,
                'name'  => $value->name,
            ];
        }

        if ($categories) {
            $response["success"]=1;
            $response["message"]= "Success";
            $response["result"]=$categories;
        } else {
            $response["success"]=0;
            $response["message"]="No Records.";
        }

        return response()->json($response);
    }

    /* reqObject = {"task":"Product","taskData":{"user_id":"2","session_token":"X31Iu3j2sOOEn1R7nH7bMmP2JN26ccTM","category_id":"1"}} */
    public function Product($TaskData)
    {
        if (isset($TaskData->category_id) && $TaskData->category_id != '') {

            $products = Product::where('category_id', $TaskData->category_id)->where('status', 1)->get();

            $result = array();

            foreach($products as $key => $value){
                if($value->image == ''){
                    $image = asset('storage/app/product/saral_logo.jpg');
                } else {
                    $image = asset('storage/app/'. $value->image);
                }
                $result[] = [
                    'product_id'    => $value->id,
                    'product_name'  => $value->name,
                    'image'         => $image,
                ];
            }

            if ($result) {
                $response["success"]=1;
                $response["message"]= "Success";
                $response["result"]=$result;
            } else {
                $response["success"]=0;
                $response["message"]="No Records.";
            }
        } else {
            $response["success"]=0;
			$response["message"]="Some Fields Are Empty.";
        }

        return response()->json($response);
    }

    /* reqObject = {"task":"SearchDealer","taskData":{"user_id":"2","session_token":"sMpISpKDc2PhwADk2f7QHIwu3rTycREJ", "search":"pratik", "city_id":"1"}} */
    public function SearchDealer($TaskData){

        if (isset($TaskData->search) && $TaskData->search != '' && isset($TaskData->city_id) && $TaskData->city_id != '') {

            $user = User::where('id',$TaskData->user_id)->first();
            if($user->display == 1)
            {
                $dealerSearch = Dealer::where('city_id', $TaskData->city_id)->where('name', 'like', '%' . $TaskData->search. '%')->get();
            }
            else {
                $dealerSearch = Dealer::where('city_id', $TaskData->city_id)->where('name', 'like', '%' . $TaskData->search. '%')->where('user_id',$TaskData->user_id)->get();
            }

            $result = array();

            foreach($dealerSearch as $key => $value){
                $result[] = [
                    'dealer_id'    => $value->id,
                    'dealer_name'  => $value->name,
                ];
            }

            if ($result) {
                $response["success"]=1;
                $response["message"]= "Success";
                $response["result"]=$result;
            } else {
                $response["success"]=0;
                $response["message"]="No Records.";
            }
        } else {
            $response["success"]=0;
			$response["message"]="Some Fields Are Empty.";
        }

        return response()->json($response);
    }

    /* reqObject = {"task":"OrderDetail","taskData":{"user_id":"9","session_token":"Z5RWNqsHK4C7EQdVJumZI1pwYc7rOOur","order_id":"1"}} */
    public function OrderDetail($TaskData)
      {
        if (isset($TaskData->order_id) && $TaskData->order_id != '') {

            $orderDetail = Order::with('city', 'dealer', 'product')->where('order_no', $TaskData->order_id)->get();


            $productDetail = array();
            foreach($orderDetail as $key => $value){
                if($value->product->image == ''){
                    $image = asset('storage/app/product/saral_logo.jpg');
                } else {
                    $image = asset('storage/app/'. $value->product->image);
                }

                $productDetail[] = [
                    'product_name'    => $value->product->name,
                    'qty'             => $value->qty,
                    'image'           => $image,
                ];
            }

            $result[] = [
                'dealer_name'     => $orderDetail[0]->dealer->name,
                'city_name'       => $orderDetail[0]->city->name,
                'productDetail'   => $productDetail,
                'instruction'     => $orderDetail[0]->instruction,
                'transporter'     => $orderDetail[0]->transporter
            ];

            if ($result) {
                $response["success"]=1;
                $response["message"]= "Success";
                $response["result"]=$result;
            } else {
                $response["success"]=0;
                $response["message"]="No Records.";
            }
        } else {
            $response["success"]=0;
            $response["message"]="Some Fields Are Empty.";
        }

        return response()->json($response);
    }


}
