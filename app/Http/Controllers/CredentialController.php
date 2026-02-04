<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use App\PlytixCredential;
use Illuminate\Http\Request;

class CredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $credentials = Credential::whereIn('site',['tb','gi','os','tbdev'])->get();
        // dd($credentials);
        return view('credentials.index', ['credentials' => $credentials]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Credential  $credential
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $credential = Credential::find($id);
        
        $data = $request->except('_token');
        $credential->fill($data);
        $credential->save();
        return  redirect()->back()->withStatus('credential updated');
    }

    public function plytixSetInfo()
    {
        //
        $credentials = PlytixCredential::where('used_for','set_info')->first();
        return view('credentials.plytix', ['credential' => $credentials]);

    }
    public function updatePlytixSetInfo(Request $request, $id){

        $plytixCredential = PlytixCredential::find($id);
        $plytixCredential->fill( $request->except('_token') );
        $plytixCredential->save();
        return  redirect()->back()->withStatus('credential updated');

    }
}
