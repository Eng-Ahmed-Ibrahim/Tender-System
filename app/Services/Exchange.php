<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Exchange
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('EXCHANGE_RATE_API_KEY');
    }

    public function getExchangeRate($fromCurrency, $toCurrency)
    {
        $response = Http::get("https://v6.exchangerate-api.com/v6/d0d7188d91998127e874bde2/pair/{$fromCurrency}/{$toCurrency}");
        if ($response->successful()) {
            return $response;
        }

        // Log the response or status code for debugging
        \Log::error('Exchange rate API error', [
            'status' => $response->status(),
            'response' => $response->body()
        ]);

        throw new \Exception('Error fetching exchange rate');
    }
}
