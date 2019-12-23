<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'image', 'status', 'added_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo('App\User', 'added_by');
    }
}
