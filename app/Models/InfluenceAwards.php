<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfluenceAwards extends Model
{
    //
    protected $fillable = [
        'email','name','coupon_code','externalId','rewardRuleId','rewardPoints', 'response',
    ];
}
