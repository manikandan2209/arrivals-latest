<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Bigcommerce\Api\Client as Bigcommerce;
use App\Influence\Facades\Influence;
use App\Models\TremendousOrder;
use App\Models\TbCoupon;
use App\Models\InfluenceAwards;
use App\Models\TremendousSettings;
use App\Models\OrdersWebhook;


class TremendousController extends Controller
{
    //
    public function __construct(){
        // $this->middleware('auth')->except('orderPlacedHook','processInfluenceRewards','rewardsRedeemedHook');
    }
    public function ordersList(){
        $orders = TremendousOrder::orderBy('id', 'desc')->paginate(50);
        return view('tremendous.orderslist', [
            'orders' => $orders,
        ]);
    }
    public function influenceAwards(){
        $awards = InfluenceAwards::orderBy('id', 'desc')->paginate(50);
        return view('tremendous.influenceAwardList', [
            'awards' => $awards,
        ]);
    }
    public function settings(){
        $settings = TremendousSettings::all();
        // dd($settings);
        return view('tremendous.settings', [
            'settings' => $settings,
        ]);
    }
    public function settingsUpdate(Request $request){

        // dd($request->all());
        $data = $request->except('_token');
        
        foreach($data as $key => $value){
            TremendousSettings::updateOrCreate(
                ['name' => $key],   
                ['value' => $value]
            );
        }
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
    public function orderPlacedHook(Request $request){
        $hookData = json_decode($request->getContent(), true);
        $order_id = $hookData['data']['id'];
        $receivedStoreHash = explode('/', $hookData['producer'])[1];

        OrdersWebhook::insert([
            'store_hash' => $receivedStoreHash,
            'order_id' => $order_id,
        ]);

        return response()->json('ok');

    }
    public function processInfluenceRewards(){
        
        $hookData = OrdersWebhook::where('tremendous_processed', false)->get();
        // $hookData = [['order_id' => 1002391041, 'store_hash' => 'dnybxc6']];
        if($hookData->isEmpty()){
            return response()->json('No new orders to process');
        }
        $tb_store_hash = TremendousSettings::where('name', 'tb_store_hash')->first()->value ?? '';
        $tb_client_id = TremendousSettings::where('name', 'tb_client_id')->first()->value ?? '';
        $tb_access_token = TremendousSettings::where('name', 'tb_access_token')->first()->value ?? '';
        $influence_api_key = TremendousSettings::where('name', 'influence_api_key')->first()->value ?? '';
         
        Bigcommerce::configure([
            'client_id' => $tb_client_id,
            'auth_token'=> $tb_access_token,
            'store_hash'=> $tb_store_hash,
        ]);
        // Bigcommerce::configure([
        //     'client_id' => 'makjti82rv4hs8rxssz5jnpus22jzew',
        //     'auth_token'=> 'jf5juxb28fryat1v35s2r7irvk76u2f',
        //     'store_hash'=> 'zdnxndpmtf',
        // ]);

        Bigcommerce::failOnError();

        foreach($hookData as $data){
            $order_id = $data['order_id'];
            $influenceAwards = InfluenceAwards::where('order_id', $order_id)->first();
            if($influenceAwards){
                Log::info('Order already processed for Influence points ' . $order_id);
                continue;
            }
            if($data['store_hash'] != $tb_store_hash){
                Log::info('Store hash mismatch for order ' . $order_id);
                continue;
            }
            try {
                $order = Bigcommerce::getOrder($order_id);

                // delete the hook if order is incomplete
                if($order->status == 'Incomplete'){
                    Log::info('Order is incomplete ' . $order_id);
                    OrdersWebhook::destroy($data['id']);
                    continue;
                }

                // $orderProducts = Bigcommerce::getOrderProducts($order_id);
                $email = $order->billing_address->email;
                $name =$order->billing_address->first_name ." ". $order->billing_address->last_name;
                $phone = $order->billing_address->phone;
                $externalId = $order->customer_id;
                $ordertotal = $order->subtotal_ex_tax;
                Log::info('order processing for Influence points ' . $email);
                $BC_customer = Bigcommerce::getCustomers(['email' => $email]);
                // skip is customer not found for guest orders  
                if(empty($BC_customer)){
                    Log::info('No BC customer found for email ' . $email);
                    OrdersWebhook::where('id', $data['id'])->update(['tremendous_processed' => true]);
                    continue;
                }
               
                if($externalId == 0){
                    $externalId =  !empty($BC_customer) ? $BC_customer[0]->id : null;
                }
                
                Influence::configure($influence_api_key);

                $customer = Influence::getCustomerById($externalId);
                
                if( empty($customer) ){
                
                $customer = Influence::createCustomer($externalId ,[
                        'email' => $email,
                        'name' => $name,
                        'phone' => $phone,
                    ]);
                    $customer = $customer['customer'];

                }else{
                    $customer = $customer['customer'];
                }
                
                // dd($customer['id']);
                if(is_array($order->coupons)) {
                    foreach( $order->coupons as $orderCoupon){
                        $db_coupon = TbCoupon::where('coupon', $orderCoupon->code)->first();
                        if(!$db_coupon){
                            continue;
                        }
                        // reward rule will override loyalty points so only one of them is required
                        if($db_coupon->loyalty_points > 0 || $db_coupon->influence_reward_rule_id != null){
                            $loyalypoints = 0;
                            $actiontitle = '';
                            if($db_coupon->loyalty_points_type == 'per_dollar'  && $ordertotal >= $db_coupon->min_purchase ){
                                $loyalypoints = round($db_coupon->loyalty_points * $ordertotal);
                                $actiontitle = $loyalypoints . ' Points Earned for Order #' . $order_id;
                            }
                            if($db_coupon->loyalty_points_type == 'per_order' && $ordertotal >= $db_coupon->min_purchase ){
                                $loyalypoints = $db_coupon->loyalty_points;
                                $loyalypointscost =  $loyalypoints/100;
                                $actiontitle = '$'.$loyalypointscost.' Cash Reward Earned for Order #'.$order_id;
                            }
                            if($db_coupon->loyalty_points_type == 'tier_2'){
                                if($ordertotal >= $db_coupon->min_order_tier2){
                                    $loyalypoints = $db_coupon->loyalty_points_tier2;    
                                }elseif($ordertotal >= $db_coupon->min_purchase){
                                    $loyalypoints = $db_coupon->loyalty_points;
                                }
                                $loyalypointscost =  $loyalypoints/100;
                                $actiontitle = '$'.$loyalypointscost.' Cash Reward Earned for Order #'.$order_id;
                            } 
                            if($db_coupon->loyalty_points_type == 'tier_3'){
                                if($ordertotal >= $db_coupon->min_order_tier3){
                                    $loyalypoints = $db_coupon->loyalty_points_tier3;    
                                }elseif($ordertotal >= $db_coupon->min_order_tier2){
                                    $loyalypoints = $db_coupon->loyalty_points_tier2;
                                }elseif($ordertotal >= $db_coupon->min_purchase){
                                    $loyalypoints = $db_coupon->loyalty_points;
                                }
                                $loyalypointscost =  $loyalypoints/100;
                                $actiontitle = '$'.$loyalypointscost.' Cash Reward Earned for Order #'.$order_id;
                            }
                            if($loyalypoints == 0){
                                continue;
                            }
                            $res = Influence::awardPoints($externalId , [
                                'points' => $loyalypoints,
                                'action' => $actiontitle,
                                'earnRuleId' => $db_coupon->influence_reward_rule_id,
                            ]);

                            Log::info('Influence points awarded ' . $email , $res);
                            if(isset($res['error'])){
                                InfluenceAwards::insert([
                                    'email' => $email,
                                    'name' => $name,
                                    'coupon_code' => $orderCoupon->code,
                                    'order_id' => $order_id,
                                    'externalId' => $externalId,
                                    'rewardRuleId' => $db_coupon->influence_reward_rule_id,
                                    'rewardPoints' => $loyalypoints,
                                    'response' => $res['message'],
                                ]);
                            }elseif(isset($res['customer'])) {
                                InfluenceAwards::insert([
                                    'email' => $email,
                                    'name' => $name,
                                    'coupon_code' => $orderCoupon->code,
                                    'order_id' => $order_id,
                                    'externalId' => $externalId,
                                    'rewardRuleId' => $db_coupon->influence_reward_rule_id,
                                    'rewardPoints' => $loyalypoints,
                                    'response' => 'success',
                                ]);
                            }
                        }
                    }
                }

            }catch(\Bigcommerce\Api\Error $error) {
                $code = $error->getCode();
                $msg = $error->getMessage();
                return response()->json ("Error $code, $msg");
            }
            OrdersWebhook::where('id', $data['id'])->update(['tremendous_processed' => true]);
        }
        return response()->json('ok');
    }
    public function rewardsRedeemedHook(Request $request){
       
        $hookData = json_decode($request->getContent(), true);

        Log::info('Influence point redeemed' , $hookData );
        $redeem_id = $hookData['id'];
        $customerEmail = $hookData['customer']['email'];
        $customerName = $hookData['customer']['name'];
        $rewardPoints = $hookData['redeemRule']['pointCost'];
        $rewardCost = $rewardPoints/100;
        $couponcode = $hookData['couponCode'];
        $action = strtolower($hookData['action']);
        $campaignId = 'VIVIODPM5CF3'; // default campaign id visa gift card
        if(str_contains($action, 'amazon') ){
            $campaignId = 'UTN84HR01LR8'; // amazon campaign id
        }

        $influence_api_key = TremendousSettings::where('name', 'influence_api_key')->first()->value ?? '';
        Influence::configure($influence_api_key);

        $res = $this->createRewardOrder($customerEmail,$customerName, $rewardCost, $couponcode, $campaignId); 
                    $res = json_decode($res);
                    $tremendous_reward_order_id = $res->order->id;
                    TremendousOrder::insert([
                        'redeem_id' => $redeem_id,
                        'email' => $customerEmail,
                        'amount' => $rewardCost,
                        'tremendous_reward_order_id' => $tremendous_reward_order_id
                    ]);
                    if($tremendous_reward_order_id){
                        Influence::markRewardUsed($couponcode);
                    }
        // dd($hookData);
        return response()->json('ok');

    }
    public function createRewardOrder($email,$name, $price, $couponcode, $campaignId){
        $client = new Client();
        $tremendous_api_key = TremendousSettings::where('name', 'tremendous_api_key')->first()->value ?? '';
        $response = $client->request('POST', 'https://api.tremendous.com/api/v2/orders', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' =>  'Bearer PROD_' . $tremendous_api_key,
            ],
            'json' => [
                "payment" => [
                "funding_source_id" => "balance" 
                ], 
                "reward" => [
                    "value" => [
                        "currency_code" => "USD", 
                        "denomination" => $price
                    ], 
                    "recipient" => [
                            "name" =>$name,
                            "email" => $email
                    ], 
                    "delivery" => [
                            "method" => "EMAIL" 
                    ], 
                    "custom_fields" => [
                        [
                            "id" => "SVJCZ096Q74F", 
                            "value" => $couponcode
                        ] 
                    ],
                    "campaign_id" => $campaignId
                ] 
            ]
        ]);
        
        return $response->getBody()->getContents();
    }
}