<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponsPage extends Model
{
    //
    protected $fillable = [
        'title','description', 'limit_text', 'coupon' ,'is_active' , 'site','sort'
    ]; 
}
