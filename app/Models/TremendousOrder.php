<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TremendousOrder extends Model
{
    //
    protected $fillable = [
        'redeem_id',
        'email',
        'amount',
        'tremendous_reward_order_id'
    ];
}
