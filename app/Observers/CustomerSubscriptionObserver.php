<?php

namespace App\Observers;

use App\Models\CustomerSubscription;
use App\Models\Bill;

class CustomerSubscriptionObserver
{
    public function created(CustomerSubscription $subscription)
    {
        $this->createBill($subscription);
    }

    public function updated(CustomerSubscription $subscription)
    {
        // Uncomment the line below if you want to create a bill on update
        // $this->createBill($subscription);
    }

    protected function createBill(CustomerSubscription $subscription)
    {
        // Calculate amount based on the subscription plan
        $amount = $this->calculateAmount($subscription);
        $durationInMonths = $this->getDurationInMonths($subscription->subscriptionPlan->duration);

        Bill::create([
            'customer_subscription_id' => $subscription->id,
            'customer_id' => $subscription->customer_id, // Assuming there's a customer relationship
            'amount' => $amount,
            'due_date' => $durationInMonths,
            'subscription_plan_id' => $subscription->subscription_plan_id,
            'subscription_start_date' => now(),
            'subscription_end_date' => now()->addMonths($durationInMonths),
            'remaining_ads_normal' => $subscription->remaining_ads_normal, // Directly use the subscription values
            'remaining_ads_commercial' => $subscription->remaining_ads_commercial,
            'remaining_ads_popup' => $subscription->remaining_ads_popup,
            'remaining_ads_banners' => $subscription->remaining_ads_banners,
        ]);
    }

    protected function calculateAmount(CustomerSubscription $subscription)
    {
        // Return the amount associated with the subscription plan
        return $subscription->subscriptionPlan->price; // Assuming you have a price attribute in the SubscriptionPlan model
    }

    protected function getDurationInMonths($duration)
    {
        // Implement your logic to convert duration to months if needed
        return $duration; // Assuming the duration is already in months
    }
}
