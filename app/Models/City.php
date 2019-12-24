<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'state_id', 'status', 'added_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo('App\User', 'added_by');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
