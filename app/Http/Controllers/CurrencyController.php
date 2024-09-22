<?php

namespace App\Http\Controllers;

use App\Services\Exchange;
use Illuminate\Http\Request;
use App\Services\CurrencyConverter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    /*
    public function store(Request $request) {


        $request->validate([

            'currency_code' =>'required|string|size:3',


        ]);

        $currencycode = $request->input('currency_code');

        Session::put('currency_code', $currencycode);

        $baseCurrencyCode = config('app.currency');


        $cacheKey = 'currency_rate_'.$currencycode;

        $rate= Cache::get($cacheKey,0);

        if(!$rate) {
        $converter = new CurrencyConverter(config('services.currency_converter.api_key'));

        $rate = $converter->convert($baseCurrencyCode,$currencycode);

        Cache::put(  $cacheKey,$rate,now()->addMinute(60));
        }

        Session::put('currency_rate', $rate);

        return redirect()->back();



    }

    */

    public function store(Request $request)
    {
        $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);
    
        $currencyCode = $request->input('currency_code');
        Session::put('currency_code', $currencyCode);
    
        $baseCurrencyCode = config('app.currency');
    
        try {
            $exchange = new Exchange();
            $response = $exchange->getExchangeRate($baseCurrencyCode, $currencyCode);
            $data = $response->json();
            $rate = $data['conversion_rate'] ?? 0;
    
            // Store the rate in session
            Session::put('currency_rate', $rate);
        } catch (\Exception $e) {
            // Handle API error
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    
        return redirect()->back();
    }
    
}
