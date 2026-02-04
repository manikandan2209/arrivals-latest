<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SsoLogin extends Model
{
    //
    protected $fillable = [
        'name','email', 'site', 'action', 'payload' , 'bc_login_token'
    ]; 
    protected $table = 'sso_login';
}
