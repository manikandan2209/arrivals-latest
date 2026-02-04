<?php

namespace App\Pim;
use GuzzleHttp\Client;
 
class Plytix {

    private $api_key, $api_password , $retryCount, $client;
 
    public function configure($api_key, $api_password)
    {
        //
        $this->api_key = $api_key;
        $this->api_password = $api_password;
        $this->retryCount = 3;

        $this->client = new Client();

        $options = [
            'json' => [
                "api_key" =>  $this->api_key,
                "api_password" =>  $this->api_password
            ]
        ];
        $response = $this->client->post("https://auth.plytix.com/auth/api/get-token", $options);
        $data =  json_decode($response->getBody(), true)['data'];
        // dd($data);
        session()->put('access_token', $data[0]['access_token']);
        session()->put('refresh_token', $data[0]['refresh_token']); 

    }

    public function getSetProducts($page)
    {
            $filters = array(
                            [
                                [
                                    "field" => "attributes.set_t_f",
                                    "operator"=>"eq",
                                    "value" => true
                                ],
                            ]
                        
                        );
        # code...
      
        $options = [
            'json' => [
                "filters" => $filters,
                "attributes" => [
                    "attributes.toner_buzz_product_id",
                    "attributes.genuine_ink_product_id",
                    "attributes.original_supplies_product_id",
                    "attributes.toner_buzz_url",
                    "attributes.toner_buzz_price",
                    "attributes.original_supplies_url",
                    "attributes.genuine_ink_url",
                    "attributes.set_contains",
                    "attributes.set_t_f",
                    "label"
                ],
                "pagination" =>[
                    "page" => $page,
                    "page_size" => 100,
                ]
            ] ,
            'headers' => [
                'Authorization' => 'Bearer '. session('access_token'),
                'content-type' => 'application/json'
            ],     
        ];
        
        $retry = 0;
        
        do {
            try {
                $response = $this->client->post("https://pim.plytix.com/api/v1/products/search" , $options);
                $response =  json_decode($response->getBody(), true);
                $this->retryCount = 3;
              
                return $response;

            } catch(GuzzleHttp\Exception\BadResponseException $e ){
                $response = $e->getResponse();
                $retry = $this->handleError($response);
                echo 'retry - '.$retry;
            }   
        } while($retry > 0);

    }

    public function getSingleProducts($page)
    {
            $filters = array(
                            [
                                [
                                    "field" => "attributes.set_t_f",
                                    "operator"=>"eq",
                                    "value" => false
                                ],
                                [
                                    "field" => "attributes.included_in_set",
                                    "operator"=>"exists",
                                ],
                            ]
                        
                        );
        # code...
      
        $options = [
            'json' => [
                "filters" => $filters,
                "attributes" => [
                    "attributes.toner_buzz_product_id",
                    "attributes.genuine_ink_product_id",
                    "attributes.original_supplies_product_id",
                    "attributes.toner_buzz_url",
                    "attributes.toner_buzz_price",
                    "attributes.original_supplies_url",
                    "attributes.genuine_ink_url",
                    "attributes.set_contains",
                    "attributes.included_in_set",
                    "attributes.set_t_f",
                ],
                "pagination" =>[
                    "page" => $page,
                    "page_size" => 100,
                ]
            ] ,
            'headers' => [
                'Authorization' => 'Bearer '. session('access_token'),
                'content-type' => 'application/json'
            ],     
        ];
        
        $retry = 0;
        
        do {
            try {
                $response = $this->client->post("https://pim.plytix.com/api/v1/products/search" , $options);
                $response =  json_decode($response->getBody(), true);
                $this->retryCount = 3;
              
                return $response;

            } catch(GuzzleHttp\Exception\BadResponseException $e ){
                $response = $e->getResponse();
                $retry = $this->handleError($response);
                echo 'retry - '.$retry;
            }   
        } while($retry > 0);

    }
}