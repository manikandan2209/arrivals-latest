<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class CouponCartLog extends Model
{
    //
    protected $fillable = [
        'email','cart_id', 'site','coupon','is_success','reason','cart_total','is_ordered','order_id','page'
    ];
    
    public function scopeFilter($q)
    {
        if (request('site')) {
            $q->where('site','LIKE' , '%'.request('site').'%');
        }
        if (request('c_page')) {
            $q->where('page', request('c_page'));
        }
        if (request('coupon')) {
            $q->where('coupon','LIKE','%'.request('coupon').'%');
        }
        if (null !== request('is_success')) {
            $q->where('is_success', boolval(request('is_success')));
        }
        if (null !== request('is_ordered')) {
            $q->where('is_ordered', boolval(request('is_ordered')));
        }
        if (request('date')) {
            $q->where('created_at', '>=' , Carbon::createFromFormat('Y-m-d',request('date'))->startOfDay());
            $q->where('created_at', '<=' , Carbon::createFromFormat('Y-m-d',request('date'))->endOfDay());
        }

        return $q;
    }

}
