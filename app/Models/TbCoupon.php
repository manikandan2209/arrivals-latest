<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbCoupon extends Model
{
    //
    protected $fillable = [
        'coupon','expires', 'min_purchase', 'type' ,'is_active' , 'msg_applied','msg_not_applied','loyalty_points','influence_reward_rule_id', 'loyalty_points_type','loyalty_points_tier2', 'loyalty_points_tier3', 'min_order_tier2', 'min_order_tier3'
    ];              
}
