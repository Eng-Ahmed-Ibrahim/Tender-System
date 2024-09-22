<?php

namespace App\Listeners;

use App\Models\Country;
use App\Events\CustomerRegistered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreCustomerLocation
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  \App\Events\CustomerRegistered  $event
     * @return void
     */
    public function handle(CustomerRegistered $event)
    {
        $customer = $event->customer;

        Log::info('StoreCustomerLocation Listener triggered for customer:', ['customer_id' => $customer->id]);

        $ip = Request::ip(); 
        
        $currentUserInfo = Location::get($ip);

        if ($currentUserInfo) {

            $countryId = $this->getCountryIdFromName($currentUserInfo->countryName);

            $customer->update(['country_id' => $countryId]);

            Log::info('Country updated for customer:', ['country_id' => $countryId, 'customer_id' => $customer->id]);
        } else {
            Log::warning('Failed to retrieve location information for customer:', ['customer_id' => $customer->id, 'ip' => $ip]);
        }
    }

    /**
     * Get the country ID from the country name.
     *
     * @param  string  $countryName
     * @return int|null
     */
    private function getCountryIdFromName($countryName)
    {
        // Find country by name in the database
        $country = Country::where('name', $countryName)->first();

        return $country ? $country->id : null;
    }
}
