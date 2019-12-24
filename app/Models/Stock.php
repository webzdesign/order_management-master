<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['transaction_id', 'voucher', 'product_id', 'qty', 'type', 'added_by', 'updated_by'];
}
