<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerSettings;

class BannerSettingsController extends Controller
{ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $bannerSettings = BannerSettings::all();

       return view('banner-settings', [ 'bannerSettings' => $bannerSettings ]);

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
        foreach ($data['bannerSettings'] as $key => $value) {
            BannerSettings::where('id', $value['id'])->update(['value' => $value['value'] , 'status' => isset( $value['status'] ) ?  $value['status'] : 0 ]);
        }
        
        return redirect()->back()->withStatus('Settings updated successfully');
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

    public function api(Request $request){
         // Find origin from which request is made
        $origin =  $request->headers->get('origin');
        $origin = str_replace('http://','' ,$origin);
        $origin = str_replace('https://','',$origin);
         
        if($origin  == 'genuineink.com' || $origin == 'genuine-ink-sandbox.mybigcommerce.com' || $origin == 'localhost:3000' ){
            $site = 'gi';
        }elseif($origin  == 'originalsupplies.com' || $origin == 'original-supplies-sandbox.mybigcommerce.com'){
            $site = 'os';
        }else{
            $site = 'tb';
        }


        $settings =  BannerSettings::where('site',$site)->first();         
        
        return response()->json($settings);
    }

}

/*
        $config = new \BigCommerce\Api\v3\Configuration();
        $config->setHost( 'https://api.bigcommerce.com/stores/zdnxndpmtf/v3' );
        $config->setClientId( 'ln8f0ws1aw1vlb8aq5ywe9m6kxv1y46' );
        $config->setAccessToken( '8l9vfqlbh0883kapkz1dbyod9osw3pc' );

        $client = new \BigCommerce\Api\v3\ApiClient( $config ); 
        $catalog  = new \BigCommerce\Api\v3\Api\CatalogApi( $client );
        $widgets = new \BigCommerce\Api\v3\Api\WidgetApi( $client );
        try {
            
            $placements = $widgets->getPlacements();
            $widget = $widgets->getWidgets()->getData();
            $widgetTemplates = $widgets->getWidgetTemplates()->getData();
            // dump($widgetTemplates);
            // dump($widget);
            // dump($placements);
            dump();
            die();
            
        } catch ( \BigCommerce\Api\v3\ApiException $e ) {
            $error_message = $e->getMessage();
            $error_body    = $e->getResponseBody();
            $error_headers = $e->getResponseHeaders();
            // do something with the error
            return;
        }
*/