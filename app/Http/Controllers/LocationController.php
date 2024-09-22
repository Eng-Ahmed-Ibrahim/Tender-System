<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use App\Models\Country;

class LocationController extends Controller
{
    public function getLocation(Request $request)
    {
        $ip = $request->header('X-Forwarded-For') ?: $request->ip();
        $currentUserInfo = Location::get($ip);

        if ($currentUserInfo) {
            // Retrieve country ID from the database
            $countryId = $this->getCountryIdFromName($currentUserInfo->countryName);

            // Store country ID in the session
            $request->session()->put('country_id', $countryId);

            return response()->json([
                'country' => $currentUserInfo->countryName,
                'city' => $currentUserInfo->cityName,
                'latitude' => $currentUserInfo->latitude,
                'longitude' => $currentUserInfo->longitude,
                'country_id' => $countryId,
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to retrieve position.',
                'ip' => $ip,
            ]);
        }
    }

    private function getCountryIdFromName($countryName)
    {
        // Find country by name in the database
        $country = Country::where('name', $countryName)->first();
        return $country ? $country->id : null;
    }
}
