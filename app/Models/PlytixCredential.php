<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlytixCredential extends Model
{
    //
    protected $fillable = [
        'used_for','api_key', 'password'
    ];
}
