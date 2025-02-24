<?php

namespace App\Http\Controllers\Api\V1\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
class FirebaseController extends Controller
{
    public function send(Request $request)

    {

        $fcm = "DEVICE_FCM_TOKEN";


        $title = "اشعار جديد";
    
        $description = "تيست تيست تيست";
    
        $credentialsFilePath = Http::get(asset('json/testupdate-d92bb-0283807065a9.json')); // in server
    
        $client = new GoogleClient();
    
        $client->setAuthConfig($credentialsFilePath);
    
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    
        $client->refreshTokenWithAssertion();
    
        $token = $client->getAccessToken();
    
    
        $access_token = $token['access_token'];
    
    
        $headers = [
    
            "Authorization: Bearer $access_token",
    
            'Content-Type: application/json'
    
        ];
    
    
        $data = [
    
            "message" => [
    
                "token" => $fcm,
    
                "notification" => [
    
                    "title" => $title,
    
                    "body" => $description,
    
                ],
    
            ]
    
        ];
    
        $payload = json_encode($data);
    
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/notification-c475b/messages:send');
    
        curl_setopt($ch, CURLOPT_POST, true);
    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
    
        $response = curl_exec($ch);
    
        $err = curl_error($ch);
    
        curl_close($ch);
    
    
        if ($err) {
    
            return response()->json([
    
                'message' => 'Curl Error: ' . $err
    
            ], 500);
    
        } else {
    
            return response()->json([
    
                'message' => 'Notification has been sent',
    
                'response' => json_decode($response, true)
    
            ]);
    
        }
    

    
   
}

}
