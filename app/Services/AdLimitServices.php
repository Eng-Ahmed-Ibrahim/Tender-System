<?php
namespace App\Services;

use App\Models\CustomerSubscription;
use Illuminate\Support\Facades\Auth;

class AdLimitServices
{
    public function canPostAd($adType)
    {
        $customerId = Auth::guard('customer')->id();
        $subscription = CustomerSubscription::where('customer_id', $customerId)
            ->where('end_date', '>', now())
            ->first();

        if (!$subscription) {
            return false;
        }

        $remainingAdsField = 'remaining_ads_' . $adType;
        if ($subscription->$remainingAdsField <= 0) {
            return false;
        }

        return true;
    }

    public function updateAdLimits($adType)
    {
        $customerId = Auth::guard('customer')->id();
        $subscription = CustomerSubscription::where('customer_id', $customerId)
            ->where('end_date', '>', now())
            ->first();

        if (!$subscription) {
            return;
        }

        $remainingAdsField = 'remaining_ads_' . $adType;
        $postedAdsField = 'ads_posted_' . $adType;
        

        $subscription->$remainingAdsField--;
        $subscription->$postedAdsField++;
        $subscription->save();
    }

}
