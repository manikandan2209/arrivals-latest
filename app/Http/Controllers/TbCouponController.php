<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use App\Models\TbCoupon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Bigcommerce\Api\Client as Bigcommerce;


class TbCouponController extends Controller
{
    
    public function getModelClass($site){

        if($site != 'tb' && $site != 'gi' && $site != 'os' && $site != 'tbdev'){
            abort(404);
        }
        
        return 'App\\Models\\'.ucfirst($site).'Coupon';
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($site)
    {
        //
        $modelClass = $this->getModelClass($site);
        $tbCoupons = $modelClass::all();

        return view('coupon.list', [ 'site' => $site , 'coupons' => $tbCoupons ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($site)
    {
        //
        return view('coupon.add',['site' => $site] );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($site , Request $request)
    {
        //
        // $this->validate($request, [
        //     'coupon' => 'required|string|max:191',
        //     'expires' => 'required',
        //     'min_purchase' => 'required',
        //     'type' => 'required',
        //     'is_active' => 'required',
        // ]);
        try {
        $modelClass = $this->getModelClass($site);
    
        $data = $request->except('_token');
        $data['is_active'] = $data['is_active'] ? true : false;
        $tbCoupon = $modelClass::create($data);
        $tbCoupon->save();
        return  redirect()->route('coupon.index',['site' => $site])->withStatus('Coupon message added successfully');
        }catch (QueryException $e) {
            $errorCode = $e->errorInfo[1]; // MySQL error code (e.g., 1062 for duplicate entry)
            $errorMessage = $e->getMessage();
             if ($errorCode == 1062) {
                return redirect()->back()->withInput()->withErrors(['coupon' => 'The coupon code already exists. Please use a different code.']);
            } else {
                return redirect()->back()->with('error', 'A database error occurred. Please try again.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');    
        }
    }

    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(TbCoupon $tbCoupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\
     * TbCoupon  $tbCoupon
     * @return \Illuminate\Http\Response
     */
    public function edit($site, $id)
    {
        //
        $modelClass = $this->getModelClass($site);
        $tbCoupon = $modelClass::find($id);
        return view('coupon.edit')->with(['site'=>$site,'coupon'=>$tbCoupon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TbCoupon  $tbCoupon
     * @return \Illuminate\Http\Response
     */
    public function update($site,$id,Request $request)
    {
        //
        $modelClass = $this->getModelClass($site);
        $tbCoupon = $modelClass::find($id);
        $data = $request->except('_token');
        $data['is_active'] = $data['is_active'] ? true : false;
        $tbCoupon->fill($data);
        $tbCoupon->save();
        return  redirect()->back()->withStatus('Coupon message updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TbCoupon  $tbCoupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($site,$id)
    {
        //
        $modelClass = $this->getModelClass($site);
        $tbCoupon = $modelClass::find($id);
        
        $tbCoupon->delete();

        return redirect()->back()->withStatus('Coupon message deleted successfully');

    }

    public function getCouponData($site,Request $request){
        
        $code = $request->get('coupon');

        if($site != 'tb' && $site != 'gi' && $site != 'os' && $site != 'tbdev'){
            // abort(404);
        }
        
        $credential = Credential::where('site', $site)->first(['client_id','access_token','store_hash']);

        Bigcommerce::configure([
            'client_id' => $credential->client_id,
            'auth_token'=> $credential->access_token,
            'store_hash'=> $credential->store_hash,
        ]);

        $tbCoupons = Bigcommerce::getCoupons(['code'=> $code]);
        // dd($tbCoupons);
        if(!empty($tbCoupons)){
            $res = [];
            foreach($tbCoupons as $tbCoupon){
                if($tbCoupon->code == $code){
                    $res = $tbCoupon->getCreateFields();
                }
            }
            if(!empty($res)){   
                return response()->json($res);
            }
        }

        return response()->json(['msg'=>'Coupon not found']);
        
        
    }

    public function api( $site,Request $request){
        // Find origin from which request is made

        $modelClass = $this->getModelClass($site);

        $tbCoupons = $modelClass::select('coupon','msg_applied' ,'msg_not_applied')->get();       
    
        $res = [];
        foreach($tbCoupons as $tbCoupon){
            $code = strtolower($tbCoupon->coupon);
            unset($tbCoupon->coupon);
            $res[$code] = $tbCoupon;   
        }

        return response()->json($res);
   }
   
}
