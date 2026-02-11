<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pim\Facades\Plytix;
use App\Models\PlytixCredential;
use App\Models\SetProduct;
use App\Models\SingleProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SetProductInfoController extends Controller
{
    //
    private $plytixCredentials; 
    
    public function __construct()
    {
        set_time_limit(360000);
        $this->plytixCredentials = PlytixCredential::where('used_for','set_info')->first();

    }

    public function checkandget($arr,$key) {
        return isset($arr['attributes'][$key]) ? $arr['attributes'][$key] : null; 
    }
    
    public function setProduct()
    {
        //
        Plytix::configure($this->plytixCredentials->api_key,$this->plytixCredentials->password);
        $page = 0;
        $plytixProducts = array();
        do{
            $page++;
            $res = Plytix::getSetProducts($page);
            // dd($res);
            $totalpage  = ceil($res['pagination']['count']/$res['pagination']['page_size']);
            $plytixProducts = $res['data']; 
            foreach($plytixProducts as $plytixProduct) {
    
                $setProduct = SetProduct::updateOrCreate(
                    ['sku' => $plytixProduct['sku']],
                    [
                        'plytix_id' => $plytixProduct['id'],
                        'tb_id' => $this->checkandget($plytixProduct, 'toner_buzz_product_id'),
                        'tb_url' => $this->checkandget($plytixProduct, 'toner_buzz_url'),
                        'tb_price' => $this->checkandget($plytixProduct, 'toner_buzz_price'),
                        'gi_id' => $this->checkandget($plytixProduct, 'genuine_ink_product_id'),
                        'gi_url' => $this->checkandget($plytixProduct, 'genuine_ink_url'),
                        'os_id' => $this->checkandget($plytixProduct, 'original_supplies_product_id'),
                        'os_url' => $this->checkandget($plytixProduct, 'original_supplies_url')
                    ]
                );
                $setProduct->save();
                if(isset($plytixProduct['attributes']['set_contains'])){
                    $related = array_map('trim', explode(',',$plytixProduct['attributes']['set_contains']));
                    $singleProducts = SingleProduct::whereIn('sku' , $related)->pluck('id');
                    $setProduct->contains()->syncWithoutDetaching($singleProducts);
                }
            }

        } while($page < $totalpage);
    }

    public function singleProduct()
    {
        //
        Plytix::configure($this->plytixCredentials->api_key,$this->plytixCredentials->password);
        $page = 0;
        $plytixProducts = array();
        do{
            $page++;
            $res = Plytix::getSingleProducts($page);
            // dd($res);
            $totalpage  = ceil($res['pagination']['count']/$res['pagination']['page_size']);
            $plytixProducts = $res['data']; 
            foreach($plytixProducts as $plytixProduct) {
    
                $singleProduct = SingleProduct::updateOrCreate(
                    ['sku' => $plytixProduct['sku']],
                    [
                    'plytix_id' => $plytixProduct['id'],
                    'tb_id' => $this->checkandget($plytixProduct, 'toner_buzz_product_id'),
                    'tb_url' =>$this->checkandget($plytixProduct, 'toner_buzz_url'),
                    'tb_price' =>$this->checkandget($plytixProduct, 'toner_buzz_price'),
                    'gi_id' => $this->checkandget($plytixProduct, 'genuine_ink_product_id'),
                    'gi_url' =>$this->checkandget($plytixProduct, 'genuine_ink_url'),
                    'os_id' => $this->checkandget($plytixProduct, 'original_supplies_product_id'),
                    'os_url' =>$this->checkandget($plytixProduct, 'original_supplies_url')
                    ]
                );
                $singleProduct->save();

            }

        } while($page < $totalpage);
    }

    public function syncPlytix()
    {   
        $this->deleteAll();
        $this->singleProduct();
        $this->setProduct();
        return  redirect()->back()->withStatus('Products synced with plytix succesfully');

    }

    public function listSet()
    {   
        $products = SetProduct::paginate(50);

        return view('setinfo.list-set', compact('products'));

    }
    public function listSingle()
    {   
        $products = SingleProduct::paginate(50);

        return view('setinfo.list-single', compact('products'));

    }
    public function deleteAll(){
        Schema::disableForeignKeyConstraints();
        SetProduct::truncate();
        SingleProduct::truncate();
        DB::table('set_single')->truncate();
        Schema::enableForeignKeyConstraints();
        return  redirect()->back()->withStatus('Products deleted successfully');

    }

    public function api(Request $request){
        $sku = $request->query('sku');
        $type = $request->query('type');
        
        if(!isset( $sku )){
            return response()->json(['msg'=>'Sku is not provided']);
        }
      
        $res = array();
  
        $res = SetProduct::where('sku', $sku)->with('contains:sku,tb_id,gi_id,os_id')->first();
        if(!$res){
            $res = SingleProduct::where('sku', $sku)->with('includedIn:sku,tb_id,gi_id,os_id,tb_price')->first();
            if( $res && $res->includedIn ){
                foreach($res->includedIn as &$item) {
                    $set_contains = SetProduct::where('sku', $item->sku)->first()->contains;
                    $item['contains'] = $set_contains;
                }
            }
        }
        // dd($res);
        return response()->json($res);
    }
}