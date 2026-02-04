<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlytixSettings;
class PlytixController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $plytixSettings = PlytixSettings::all();

       return view('plytix-settings', [ 'plytixSettings' => $plytixSettings]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $data = $request->except('_token');
        foreach ($data['plytixSettings'] as $key => $value) {
            PlytixSettings::where('id', $value['id'])->update(['value' => isset( $value['value'] ) ?  $value['value'] : 0 ]);
        }
        return redirect()->back()->withStatus('Settings updated successfully');
    }

    public function restoreImages(Request $request)
    {
        //
        return redirect()->back()->withStatus("Started restore in background");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
