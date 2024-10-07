<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Currency;
use App\Models\Customers;
use App\Services\Exchange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{

    public function index(){

        $currencies = Currency::all();


        return response()->json([
            'currencies' =>$currencies
        ]);




    }



    public function store(Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id', // Ensure the currency exists
        ]);
    
        $customer = Auth::guard('customer')->user(); // Get the authenticated customer instance
        if (!$customer) {
            return response()->json(['error' => 'Customer not authenticated'], 401); // Handle unauthenticated case
        }
    
        $currencyId = $request->input('currency_id');
    
        $customer->currency_id = $currencyId;
        
        $customer->save();

    
        return response()->json([
            'message' => 'Currency updated successfully',
            'currency_code' => $currency->code,
            'conversion_rate' => $rate,
        ], 200); // Return a 200 success response
    }
    
    
}


    
    
