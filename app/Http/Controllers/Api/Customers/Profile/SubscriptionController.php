<?php

namespace App\Http\Controllers\Api\Customers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\SubscriptionPlan;
use App\Models\CustomerSubscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Show all subscription plans.
     */
    public function showPlans()
    {
        $plans = SubscriptionPlan::all();

        $customer = auth()->guard('customer')->user();

        $customerSubscription = CustomerSubscription::where('customer_id', $customer->id)
            ->where('end_date', '>', now())
            ->first();




        $selectedPlanId = $customerSubscription ? $customerSubscription->subscription_plan_id : 1;

        return response()->json([
            'plans' => $plans,
            'selectedPlanId' => $selectedPlanId,
        ], 200);
    }


    public function customerPlan(){

        $customer = Auth::guard('customer')->user();


        $customerSubscription = CustomerSubscription::where('customer_id', $customer->id)
            ->where('end_date', '>', now())
            ->first();

            return response()->json([

                'subscription' => $customerSubscription

            ]);


    }

  
    public function selectPlan(Request $request)
    {
        $validatedData = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $customer = Auth::guard('customer')->user();
        $planId = $validatedData['subscription_plan_id'];
        $plan = SubscriptionPlan::findOrFail($planId);

        $durationInMonths = $this->getDurationInMonths($plan->duration);

        $existingSubscription = CustomerSubscription::where('customer_id', $customer->id)
            ->where('end_date', '>', now())
            ->first();

        if ($existingSubscription) {
            $remainingAdsNormal = $existingSubscription->remaining_ads_normal;
            $remainingAdsCommercial = $existingSubscription->remaining_ads_commercial;
            $remainingAdsPopup = $existingSubscription->remaining_ads_popup;
            $remainingAdsBanners = $existingSubscription->remaining_ads_banners;

            $existingSubscription->update([
                'subscription_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addMonths($durationInMonths),
                'remaining_ads_normal' => $plan->normalads + $remainingAdsNormal,
                'remaining_ads_commercial' => $plan->commercialads + $remainingAdsCommercial,
                'remaining_ads_popup' => $plan->popupads + $remainingAdsPopup,
                'remaining_ads_banners' => $plan->banners + $remainingAdsBanners,
            ]);

            return response()->json([
                'message' => 'Subscription plan updated successfully.',
                'subscription' => $existingSubscription
            ], 200);
        } else {
            $newSubscription = CustomerSubscription::create([
                'customer_id' => $customer->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addMonths($durationInMonths),
                'remaining_ads_normal' => $plan->normalads,
                'remaining_ads_commercial' => $plan->commercialads,
                'remaining_ads_popup' => $plan->popupads,
                'remaining_ads_banners' => $plan->banners,
            ]);

            return response()->json([
                'message' => 'Subscription plan created successfully.',
                'subscription' => $newSubscription
            ], 201);
        }
    }

    /**
     * Convert the duration string to months.
     *
     * @param string $duration
     * @return int
     */
    private function getDurationInMonths(string $duration): int
    {
        $durationMap = [
            'monthly' => 1,
            'quarterly' => 3,
            '3 month' => 3,
            'semiannually' => 6,
            '6 month' => 6,
            '9 month' => 9,
            'annually' => 12,
            '12 month' => 12,
        ];

        return $durationMap[$duration] ?? 1;
    }
}
