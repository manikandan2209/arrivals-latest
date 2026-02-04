<?php

namespace App\Http\Controllers\CouponsPage;

use App\Models\CouponsPageSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponsPageSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($site)
    {
        //
        return view('couponspagesettings.add',['site' => $site] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($site,Request $request)
    {
        //
        $data = $request->except('_token');
        $couponsPageSetting = CouponsPageSetting::create($data);
        $couponsPageSetting->save();
        return  redirect()->route('couponspage.index',['site' => $site])->withStatus('Settings created successfully');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CouponsPageSetting  $couponsPageSettings
     * @return \Illuminate\Http\Response
     */
    public function show(CouponsPageSetting $couponsPageSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CouponsPageSetting  $couponsPageSettings
     * @return \Illuminate\Http\Response
     */
    public function edit($site, CouponsPageSetting $couponsPageSetting)
    {
        // $couponspagesetting = CouponsPageSetting::find($id);
        return view('couponspagesettings.edit')->with(['site'=>$site,'couponspagesettings' => $couponsPageSetting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CouponsPageSetting  $couponsPageSettings
     * @return \Illuminate\Http\Response
     */
    public function update($site, Request $request, CouponsPageSetting $couponsPageSetting)
    {
        //
        $couponsPageSetting->fill($request->except('_token'))->save();
        return  redirect()->route('couponspage.index',['site' => $site])->withStatus('Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CouponsPageSetting  $couponsPageSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(CouponsPageSetting $couponsPageSettings)
    {
        //
    }
}
