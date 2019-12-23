<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = ['state_id', 'city_id', 'name', 'mobile_no', 'address', 'added_by', 'updated_by', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User', 'added_by');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }
}
