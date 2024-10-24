<?php

// app/Services/FirebaseService.php
namespace App\Services;

use GuzzleHttp\Client;

class FirebaseService
{
   
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function sendNotification($token, $notification, $data)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'e9jr1_bEQ8yqzM8QH6ga9L:APA91bHZfFxNwXeijCs9km7hDMPpou9_uxtE9G4omcv1cn50GwCMNQy29ygjOGmGpMwWBpoVZicUaigDHK5wnfYqc_PzBaLZlRCoNMMyONRJNGhnREnTcGw'; // Replace with your FCM server key

        $payload = [
            'to' => $token,
            'notification' => $notification,
            'data' => $data,
        ];

        $headers = [
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json',
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'json' => $payload,
        ]);

        return json_decode($response->getBody(), true);
    }


    
}