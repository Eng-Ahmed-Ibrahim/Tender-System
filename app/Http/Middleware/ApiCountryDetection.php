<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Country;
use Stevebauman\Location\Facades\Location;


    
    class ApiCountryDetection
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next)
        {
            try {
                Log::info('Request Headers: ', $request->headers->all());
    
                $countryId = $request->header('X-Country-ID') ?? $request->query('country_id');
    
                if (!$countryId) {
                    $ip = $request->ip();
                    $currentUserInfo = Location::get($ip);
    
                    if ($currentUserInfo && $currentUserInfo->countryName) {
                        $country = Country::where('name', $currentUserInfo->countryName)->first();
    
                        if ($country) {
                            $countryId = $country->id; 
                        } else {
                            Log::warning('Country not found for IP: ' . $ip);
                        }
                    }
                }
    
                if (!$countryId) {
                    $countryId = 1; // Default country ID
                }
    
                // Add the country ID to the request attributes
                $request->attributes->set('country_id', $countryId);
    
            } catch (\Exception $e) {
                Log::error('Country detection failed: ' . $e->getMessage());
            }
    
            return $next($request);
        }
    }
    
    

