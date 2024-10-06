<?php
namespace App\Services;

use GuzzleHttp\Client;

class FawaterkService
{
    protected $client;
    protected $apiUrl = 'https://staging.fawaterk.com/api/v2/invoiceInitPay';
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = '3b0e2ea6330eca65eb3ae2e6a00aa05c097158a1cab873a7ac';
    }

    public function createInvoice($orderData)
    {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://staging.fawaterk.com/api/v2/createInvoiceLink',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "cartTotal": "50",
            "currency": "EGP",
            "customer": {
                "first_name": "mohammad",
                "last_name": "hamza",
                "email": "test@fawaterk.com",
                "phone": "011252523655",
                "address": "test address"
            },
            "redirectionUrls": {
                 "successUrl" : "https://dev.fawaterk.com/success",
                 "failUrl": "https://dev.fawaterk.com/fail",
                 "pendingUrl": "https://dev.fawaterk.com/pending"   
            },
            "cartItems": [
                {
                    "name": "this is test oop 112252",
                    "price": "25",
                    "quantity": "1"
                },
                {
                    "name": "this is test oop 112252",
                    "price": "25",
                    "quantity": "1"
                }
            ]
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer 3b0e2ea6330eca65eb3ae2e6a00aa05c097158a1cab873a7ac'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    public function getPaymentMethods()
    {
        try {
            $response = $this->client->get($this->apiUrl . 'getPaymentmethods', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
