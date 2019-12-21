<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = ['city_id', 'user_id', 'name', 'status'];

    public function city(){
        return $this->belongsTo('App\Models\City');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
