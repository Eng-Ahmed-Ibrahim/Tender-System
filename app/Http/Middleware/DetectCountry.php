<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Country;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class DetectCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Retrieve the country ID from the session
            $countryId = $request->session()->get('country_id');

            // If no country ID in session, attempt to detect by IP address
            if (!$countryId) {
                $ip = $request->ip();
                $currentUserInfo = Location::get($ip);

                if ($currentUserInfo && $currentUserInfo->countryName) {
                    $country = Country::where('name', $currentUserInfo->countryName)->first();

                    if ($country) {
                        $request->session()->put('country_id', $country->id);
                        $countryId = $country->id; 
                    } else {
                    }
                }
            }

            // If still no country ID, set a default or handle as needed
            if (!$countryId) {
                $countryId = 1; // Assuming ID 1 is for a default country, adjust as necessary
                $request->session()->put('country_id', $countryId);
            }

        } catch (\Exception $e) {
            // Optionally handle exceptions or log errors
            // For example: Log::error('Country detection failed: ' . $e->getMessage());
        }

        return $next($request);
    }
}
