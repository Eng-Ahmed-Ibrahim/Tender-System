<?php


use Illuminate\Support\Facades\Session;


class Currency
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
        $convertedPrice = $price * Session::get('currency_rate', 1);

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
