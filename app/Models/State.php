<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'status', 'added_by', 'updated_by'];
}
