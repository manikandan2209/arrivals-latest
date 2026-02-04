<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SRProduct;
use App\Models\NRProduct;
use Bigcommerce\Api\Client as Bigcommerce;
use Illuminate\Support\Facades\Log;



class NRAndSRProducts extends Controller
{
    //
    public function __construct()
    {
        ini_set('max_execution_time', '0'); // Set max execution time to unlimited
        ini_set('memory_limit', '-1'); // Set memory limit to unlimited
        set_time_limit(0);
       
    }
    //
    public function nrIndex()
    {  
    
        $items = NRProduct::filter()->paginate(100);

        return view('nr-sr-products.nr-index',compact('items'));
    }
    //
    public function srIndex()
    {  
    
        $items = SRProduct::filter()->paginate(100);

        return view('nr-sr-products.sr-index',compact('items'));
    }
    
    public function srImport(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        if (empty($fileContents)) {
            return redirect()->back()->with('error', 'The file is empty.');
        }
        if (count($fileContents) < 2) {
            return redirect()->back()->with('error', 'The file must contain at least two lines.');
        }
        if (count($fileContents) > 1) {
            SRProduct::truncate();
        }
        try {
            $fileContents = array_map('trim', $fileContents);
       
            foreach ($fileContents as $line) {
                // Skip the first line (header)
                if (strpos($line, 'State Code') !== false) {
                    continue;
                }
                $data = str_getcsv($line);
                // print_r($data);
                $item = SRProduct::where('sku', $data[0].$data[1])->first();
                if ($item) {
                    $item->update([
                        'sku' => $data[0].$data[1],
                        'state_code' => $item->state_code.",".$data[2], 
                    ]);
                } else {
                    SRProduct::create([
                        'sku' => $data[0].$data[1],
                        'state_code' => $data[2],
                    ]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error reading the file: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }

    public function nrImport(Request $request)
    {   
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        if (empty($fileContents)) {
            return redirect()->back()->with('error', 'The file is empty.');
        }
        if (count($fileContents) < 2) {
            return redirect()->back()->with('error', 'The file must contain at least two lines.');
        }
        if (count($fileContents) > 1) {
            NRProduct::truncate();
        }
        try {
            $fileContents = array_map('trim', $fileContents);
       
            foreach ($fileContents as $line) {
                // Skip the first line (header)
                if (strpos($line, 'Item Number') !== false) {
                    continue;
                }
                $data = str_getcsv($line);
                // print_r($data);
                NRProduct::create([
                    'sku' => $data[0],
                    'non_returnable_code' => $data[2],
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error reading the file: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');

    }
    public function publish()
    {
        $items = NRProduct::where('published', 0)->get();
        $items2 = SRProduct::where('published', 0)->get();
        $nrproducts = [];
        $srproducts = [];
        $all = [];
        foreach ($items as $item) {
            $nrproducts[$item->sku] = $item->non_returnable_code;
        }
        foreach ($items2 as $item) {
            $srproducts[$item->sku] = $item->state_code;
        }
        foreach($nrproducts as $key => $value) {
            if (array_key_exists($key, $srproducts)) {
                $all[$key] = array( 
                    'non_returnable_code' => $value ? $value : '',
                    'state_code' => $srproducts[$key]
                );
            } else {
                if($value != '') {
                    $all[$key] = array( 
                        'non_returnable_code' => $value,
                    );
                }
            }
        }
        foreach($srproducts as $key => $value) {
            if (!array_key_exists($key, $all)) {
                $all[$key] = array( 
                    'state_code' => $value,
                );      
            }
        }
    
        if(count($all) == 0){
            return redirect()->back()->with('error', 'No products to publish.');
        }
        Bigcommerce::configure([
            'client_id' => '7bxiix8ltm7q0wu8bp25rlv9z590rnm',
            'auth_token' => 'tcy4fx39jivlf47zcj1gw6n5iamolrr',
            'store_hash' => 'neu7klof60',
            'version' => 'v3'
        ]);
        Bigcommerce::failOnError();
        try{
            $batches = array_chunk($all, 100 , true);
            $productIndex = 1;
            $total = 0;
            $this->log("Total batches : " . count($batches));
            foreach($batches as $key => $batch){
                $products = Bigcommerce::getProducts(['sku:in' =>join(',',array_keys($batch)) , 'include' =>  'custom_fields' , 'limit'=>100],'v3');
                $this->log("Batch $key Size: " . count($products));

                foreach($products as $product){
                    // $product->custom_fields = [];
                    try{
                        foreach($product->custom_fields as $key => $custom_field){
                            if($custom_field->name == 'non_returnable_code' || $custom_field->name == 'state_code'){
                                Bigcommerce::deleteProductCustomField($product->id, $custom_field->id,'v3');
                            }
                        }
                        
                    if(isset($batch[$product->sku]['non_returnable_code']) && $batch[$product->sku]['non_returnable_code'] != ''){
                        Bigcommerce::createProductCustomField($product->id, [
                            'name' => 'non_returnable_code',
                            'value' => $batch[$product->sku]['non_returnable_code'],
                        ],'v3');
                        NRProduct::where('sku',$product->sku)->update(['published' => 1]);

                        $this->log($productIndex . ' Product : ' . $product->sku . ' updated with non_returnable_code: ' . $batch[$product->sku]['non_returnable_code'] );

                    }
                    if(isset($batch[$product->sku]['state_code']) && $batch[$product->sku]['state_code'] != ''){
                        Bigcommerce::createProductCustomField($product->id, [
                            'name' => 'state_code',
                            'value' => $batch[$product->sku]['state_code'],
                        ],'v3');
                        SRProduct::where('sku',$product->sku)->update(['published' => 1]);
                        $this->log($productIndex .' Product : ' . $product->sku . ' updated with state_code: ' . $batch[$product->sku]['state_code'] );
                    }
                    $productIndex++;
                    } catch(\Bigcommerce\Api\Error $error) {
                        $code = $error->getCode();
                        $msg = $error->getMessage();
                        $this->log("Product : $product->sku Error $code, $msg");
    
                    }
                }
                
            }
        }
        catch(\Bigcommerce\Api\Error $error) {
            $code = $error->getCode();
            $msg = $error->getMessage();
            echo "Error $code, $msg";
        }
        ob_end_flush();

        return ;
    }

    public function rePublish()
    {
        NRProduct::where('published', 1)->update(['published' => 0]);
        SRProduct::where('published', 1)->update(['published' => 0]);
        $this->publish();
        return ;
    }

    public function log($string){
        if (ob_get_level() == 0) ob_start();
        echo $string . '<br>';
        Log::info($string);
        ob_flush();
        flush();
    }
}  