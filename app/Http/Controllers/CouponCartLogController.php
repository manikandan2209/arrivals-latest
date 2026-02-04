<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CouponCartLog;
use Illuminate\Support\Facades\Log;

class CouponCartLogController extends Controller
{

    public function index(){
        $couponCartLogs = CouponCartLog::filter()->orderBy('created_at', 'desc')->paginate(20);
        
        return view('coupon-cart-logs', compact('couponCartLogs'));
    }
    public function addApi(Request $request){
        Log::info('Received coupon data');
        $site =  $request->headers->get('origin');
        $site = str_replace('http://','' ,$site);
        $site = str_replace('https://','',$site);

        $data = $request->all();
        $data['is_success'] = isset($data['is_success']) && $data['is_success'] == 'true' ? true : false;
        $data['site'] = $site;

        $validator = Validator::make($data,  [
            'cart_id' => 'required',
            'coupon' => 'required',
            'cart_total' => 'required',
        ],[
            'cart_id.required'=>'cart id is required',    
            'coupon.required'=>'coupon code is required',
            'cart_total.required'=>'cart total value is required',
        ]);
        if ($validator->fails()) {
           $errors = $validator->errors();
           return response()->json(['errors' => $errors]);
        }

        $couponCartLog = CouponCartLog::create($data);
        if( !$couponCartLog->save() ) {
            return response()->json(['errors' => ['something went wrong']]);
        }
        return response()->json(['success' => 'successfully added']);

    }

    public function orderConvertedHook(Request $request){
        
        $hookData = json_decode($request->getContent(), true);
        $cart_id = $hookData['data']['id'];
        $order_id = $hookData['data']['orderId'];
        Log::info('Order converted' . $order_id . " " . $cart_id );
        
        CouponCartLog::where('cart_id',$cart_id)->update(['order_id' => $order_id , 'is_ordered' => true]);

        return response()->json('ok');
    }
}
