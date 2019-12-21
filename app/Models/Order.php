<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'order_no', 'date', 'product_id','qty', 'dealer_id', 'city_id', 'instruction', 'dispatch_qty', 'remaining_qty', 'user_id', 'status', 'transporter'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function dealer()
    {
        return $this->belongsTo('App\Models\Dealer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
