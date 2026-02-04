<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FedexModal;
use Illuminate\Support\Facades\Cache;

class FedexController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        $cutoff =  FedexModal::where('type','cutoff')->get();
        $settings =  FedexModal::where('type','settings')->get();
 
        return view('fedex', [
            'cutoff' => $cutoff,
            'settings' => $settings
        ]);
    }
    public function listholidays()
    {   
        
        // $cutoff =  FedexModal::where('type','cutoff')->get();
        $holidays =  FedexModal::where('type','holiday')->get();
        // dd($fedex);
        return view('fedex-holidays', [
            'holidays' => $holidays,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        // dd($data);
        foreach ($data['fedex'] as $key => $value) {
            FedexModal::where('id', $value['id'])->update(['value' => $value['value']]);
        }
        Cache::flush();
        return redirect()->back()->withStatus('Settings updated successfully');
    }
    
    public function addHoliday(Request $request)
    {   
        
        $request->validate([
            'label' => 'required|string|max:191',
            'value' => 'required',
        ],[
            'label.required'=>'Name of the Holiday is required',    
            'value.required'=>'Holiday Date is required',    
        ]);

        $data = $request->except('_token');
        $data['type'] = 'holiday';
        $holdiay = FedexModal::create($data);
        $holdiay->save();
        Cache::flush();
        return  redirect()->back()->withStatus('Holiday added successfully');
    }

    public function deleteHoliday($id)
    {
        $holdiay = FedexModal::find($id);
        $holdiay->delete();
        Cache::flush();
        return redirect()->back()->withStatus( 'Holiday deleted successfully');
    }

    public function cacheClean(){
        Cache::flush();
        return  redirect()->back()->withStatus('Zip code with fedex response cache cleaned successfully');
    }
}
