<?php

namespace App\Influence;
use GuzzleHttp\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Support\Facades\Log;

class Influence {
    private $api_key, $client;
    public function configure($api_key)
    {
        $this->api_key = $api_key;
        $this->client = new Client();
    }

    public function getCustomers($query = []){
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        try {
        $response = $this->client->request('GET', 'https://platform.api.influence.io/v1/customers'.$query, [
            'headers' => [
                'x-api-key' => $this->api_key,
                'accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents() ,true);
       } 
       catch (\GuzzleHttp\Exception\ClientException $e) {
           $response =  $this->handleError($e);
           if(isset($response['status_code']) && $response['status_code'] == 404){
               return [];
           }
           return $response;
       }
    }
     public function getCustomerById($customerId){
        try {
        $response = $this->client->request('GET', 'https://platform.api.influence.io/v1/customers/'.$customerId, [
            'headers' => [
                'x-api-key' => $this->api_key,
                'accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents() ,true);
       } 
       catch (\GuzzleHttp\Exception\ClientException $e) {
           $response =  $this->handleError($e);
           if(isset($response['status_code']) && $response['status_code'] == 404){
               return [];
           }
           return $response;
       }
    }
    public function createCustomer($externalId , $data)
    {
        try {
            $response = $this->client->request('PUT', 'https://platform.api.influence.io/v1/customers/'. $externalId, [
                'headers' => [
                    'x-api-key' => $this->api_key,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
                'json' => $data,
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error("Error creating customer: " . $e->getMessage());
            return $this->handleError($e);

        }
    }
    
    public function awardPoints($customerId, $data)
    {
        try {
            $response = $this->client->request('POST', 'https://platform.api.influence.io/v1/customers/' . $customerId . '/points', [
                'headers' => [
                    'x-api-key' => $this->api_key,
                    'accept' => 'application/json',
                ],
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error("Error awarding points: " . $e->getMessage());
            return $this->handleError($e);
        } 
                
    }
    
    public function markRewardUsed($coupon_code)
    {
        try {
            $response = $this->client->request('POST', 'https://platform.api.influence.io/v1/rewards/' . $coupon_code . '/use', [
                'headers' => [
                    'x-api-key' => $this->api_key,
                    'accept' => 'application/json',
                ],
                'json' => ['couponCode' => $coupon_code],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error("Error making rewards used : " . $e->getMessage());
            return $this->handleError($e);
        } 
                
    }
     

    public function handleError($exception)
    {
        $response = $exception->getResponse();
            if ($response) {
                $errorData = json_decode($response->getBody()->getContents(), true);
                return [
                    'error' => true,
                    'message' => $errorData['message'] ?? 'An error occurred',
                    'status_code' => $response->getStatusCode(),
                ];
            }
            return [
                'error' => true,
                'message' => 'An unexpected error occurred',
            ];
    }

}