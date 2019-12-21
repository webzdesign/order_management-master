<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login_log extends Model
{
    protected $fillable = ['user_id', 'session_token'];
}
