<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'order_no', 'date', 'party_id', 'product_id', 'price', 'qty', 'amount', 'discount', 'gst_type', 'cgst', 'sgst', 'igst', 'grand_total', 'instruction', 'dispatch_qty', 'remaining_qty', 'status', 'lr_no', 'transporter', 'added_by', 'updated_by'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function party()
    {
        return $this->belongsTo('App\Models\Party');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'added_by');
    }
}
