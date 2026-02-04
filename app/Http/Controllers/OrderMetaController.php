<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class OrderMetaController extends Controller
{
    private $client , $storehash , $access_token;
    //
    public function __construct()
    {
        $this->storehash  = 'zdnxndpmtf';
        $this->access_token = '931l4dvbr00pf2vn5xlgtzlzlyw1vsu';
    }
    

    public function list($resource){
        $this->client = new Client();

        try {
            $response = $this->client->get("https://api.bigcommerce.com/stores/".$this->storehash."/v3/".$resource."s/metafields?direction=desc", 
            [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Auth-Token' =>  $this->access_token
                ],
            ]);
            $orderMetaFeilds =  json_decode($response->getBody(), true);
            // print_r($orderMetaFeilds);
            // return response()->json($data);
            $grouped_orderMetaFeilds = [];
            foreach($orderMetaFeilds['data'] as $item){
                $grouped_orderMetaFeilds[$item['resource_id']][] = $item;
            }
            return view('ordermeta-list', ['orderMetaFeilds' => $grouped_orderMetaFeilds, 'resource' => $resource]);

        }
        catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return response()->json(json_decode($responseBodyAsString));
        }
        // print_r($orderMeta);

    }   

    public function delete($resource, $resource_id, Request $request){
        $this->client = new Client();

        try {
            foreach($request->metafieldsId as $id) {
            $response = $this->client->delete("https://api.bigcommerce.com/stores/".$this->storehash."/v3/".$resource."s/$resource_id/metafields/".$id, 
            [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Auth-Token' =>  $this->access_token
                ],
            ]);
            $res =  json_decode($response->getBody(), true);
            }
            // return response()->json($data);
            return redirect()->back()->withStatus('Metafield deleted successfully');

        }
        catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return response()->json(json_decode($responseBodyAsString));
        }
        // print_r($orderMeta);

    }   

    public function add(Request $request){

        
        $this->client = new Client();
        
        if($request->cart_id !== null){
            $resource_id =  $request->cart_id;
            $resource = 'carts';
        }else {
            $resource_id =  (int) $request->order_id;
            $resource = 'orders';
        }
        $is_dropship =  $request->is_dropship;
        $po_number =  $request->po_number;
        if( !$resource_id || !$is_dropship  ||  !$po_number){
            response()->json(["error" =>['Please provide required data']]);
        }


        $object = array(
                    [ "permission_set" => "read_and_sf_access",
                    "namespace" => "Tonerbuzz",
                    "key" => "Is drop shipping",
                    "value" => $is_dropship,
                    "resource_id" => $resource_id
                    ],
                    [ "permission_set" => "read_and_sf_access",
                    "namespace" => "Tonerbuzz",
                    "key" => "PO Number",
                    "value" => $po_number,
                    "resource_id" => $resource_id
                    ]
                );

        try {
            $response = $this->client->post("https://api.bigcommerce.com/stores/".$this->storehash."/v3/".$resource."/metafields", 
            [
                'json' => $object,
                'headers' => [
                    'Accept'     => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Auth-Token' =>  $this->access_token
                ],
            ]);
            $data =  json_decode($response->getBody(), true);
            return response()->json($data);
        }
        catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return response()->json(json_decode($responseBodyAsString));
        }

    return;
    }
}
