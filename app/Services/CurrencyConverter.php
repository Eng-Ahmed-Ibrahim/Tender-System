<?php 

namespace App\Services;

class CurrencyConverter {

private $apiKey;


protected $baseUrl='https://free.currconv.com';

public function __construct(string $apiKey) {

    $this->apiKey = $apikey;
}

public function convert(string $from,  string $to, $amount =1): float
{


    $q = "{$from}_{$to}";
    $response=Http::baseUrl($this->$baseUrl)
    ->get('/convert',[

        'q' => $q ,
        'compact' => 'y',
        'apikey' => $this->apikey,

    ]);

    $result = $response->json();

return $result[$q]*$amount;


}








}

