<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'status', 'added_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo('App\User', 'added_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
