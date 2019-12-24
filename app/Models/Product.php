<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'image', 'op_stock', 'price', 'added_by', 'updated_by', 'status'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'added_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
