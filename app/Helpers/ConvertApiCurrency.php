<?php

namespace App\Helpers;
use App\Models\Currency;
use App\Services\Exchange;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ConvertApiCurrency
{
    protected $baseCurrencyCode;
    protected $rate;

    public function __construct()
    {
        $this->baseCurrencyCode = config('app.currency');
        $this->rate = Session::get('currency_rate', 1); 
    }


     
    public static function convertPrice(float $price, string $currencyCode): string
    {

        $customer = Auth::guard('customer')->user();
        $currencyId = $customer->currency_id;
        
    
        $currency = Currency::find($currencyId);
    
        $baseCurrencyCode = config('app.currency');
    
            $exchange = new Exchange();
            $response = $exchange->getExchangeRate($baseCurrencyCode, $currency->code);
            $data = $response->json();
            $rate = $data['conversion_rate'] ?? 0;
        
        $convertedPrice = $price * $rate;

        $currencySymbols = [
            'USD' => '$',
            'EUR' => '€',
            'EGP' => 'LE',
            'SAR' => 'SAR',
            'QAR' => 'QAR',
        ];

        $symbol = $currencySymbols[$currencyCode] ?? '';

        return number_format($convertedPrice, 2). ' '. $symbol;
    }
}

if (!function_exists('convertPrice')) {
  
    function convertPrice(float $price, string $currencyCode): string
    {
        $currency = new Currency();
        return $currency->convertPrice($price, $currencyCode);
    }
}
