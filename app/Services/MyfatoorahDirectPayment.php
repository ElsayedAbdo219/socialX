<?php

namespace App\Services;

class MyfatoorahDirectPayment
{
    protected $apiURL = '';
    protected $apiKey;
    protected $countryMode;
    protected $isTest;
    protected $CurrencyIso;


    public function __construct()
    {
        $this->countryMode = 'SAU';
        $this->apiKey = trim(config('myfatoorah.api_key'));
        $this->isTest = config('myfatoorah.test_mode');
        $this->CurrencyIso = 'SAR';

        $mfCountries = $this->getMyFatoorahCountries();

        $code = strtoupper($this->countryMode);
        if (isset($mfCountries[$code])) {
            $this->apiURL = ($this->isTest) ? $mfCountries[$code]['testv2'] : $mfCountries[$code]['v2'];
        } else {
            $this->apiURL = ($this->isTest) ? 'https://apitest.myfatoorah.com' : 'https://api.myfatoorah.com';
        }
    }

    public function getPaymentMethodsSupportDirectPayment()
    {
        $paymentMethodsSupportDirectPayment = [];
        foreach ($this->initiatePayment() as $pm) {
            if ($pm->IsDirectPayment) {
                $paymentMethodsSupportDirectPayment[] = json_decode(json_encode($pm, true), true);
            }
        }

        return $paymentMethodsSupportDirectPayment;
    }

    public function initiatePayment()
    {
        $ipPostFields = ['CurrencyIso' => $this->CurrencyIso];
        $json = $this->callAPI("$this->apiURL/v2/InitiatePayment", $this->apiKey, $ipPostFields);
        return $json->Data->PaymentMethods;
    }

    public function directPayment($data, $cardInfo)
    {
        $paymentData = $this->executePayment($data);
        $paymentURL = $paymentData->PaymentURL;
        $json = $this->callAPI($paymentURL, $this->apiKey, $cardInfo);
        return $json->Data;
    }

    public function executePayment($data)
    {
        $json = $this->callAPI("$this->apiURL/v2/ExecutePayment", $this->apiKey, $data);
        return $json->Data;
    }


    public function getMyFatoorahCountries()
    {

        $cachedFile = dirname(__FILE__) . '/mf-config.json';

        if (file_exists($cachedFile)) {
            if ((time() - filemtime($cachedFile) > 3600)) {
                $countries = self::createNewMFConfigFile($cachedFile);
            }

            if (!empty($countries)) {
                return $countries;
            }

            $cache = file_get_contents($cachedFile);
            return ($cache) ? json_decode($cache, true) : [];
        } else {
            return self::createNewMFConfigFile($cachedFile);
        }
    }

    protected static function createNewMFConfigFile($cachedFile)
    {

        $curl = curl_init('https://portal.myfatoorah.com/Files/API/mf-config.json');
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true
        ));

        $response  = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($http_code == 200) {
            file_put_contents($cachedFile, $response);
            return json_decode($response, true);
        } elseif ($http_code == 403) {
            touch($cachedFile);
            $fileContent = file_get_contents($cachedFile);
            if (!empty($fileContent)) {
                return json_decode($fileContent, true);
            }
        }
        return [];
    }

    public function callAPI($endpointURL, $apiKey, $postFields = [], $requestType = 'POST')
    {
        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $curlErr = curl_error($curl);

        curl_close($curl);

        if ($curlErr) {
            //Curl is not working in your server
            die("Curl Error: $curlErr");
        }

        $error = $this->handleError($response);
        if ($error) {
            die($error);
        }

        return json_decode($response);
    }

    public function handleError($response)
    {

        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        //Check for the errors
        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $blogDatas = array_column($errorsObj, 'Error', 'Name');

            $error = implode(', ', array_map(function ($k, $v) {
                return "$k: $v";
            }, array_keys($blogDatas), array_values($blogDatas)));
        } elseif (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }


}
