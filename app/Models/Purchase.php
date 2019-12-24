<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['purchase_id', 'date', 'product_id', 'qty', 'added_by', 'updated_by'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','added_by');
    }
}
