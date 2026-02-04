<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    //
    protected $fillable = [
        'site','client_id', 'access_token','store_hash'
    ];
}
