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
    // Assuming the amount is calculated based on the subscription plan
    $amount = $this->calculateAmount($subscription);

    // Calculate due date based on the subscription plan's duration
    $durationInMonths = $this->getDurationInMonths($subscription->subscriptionPlan->duration);
    $dueDate = now()->addMonths($durationInMonths); // Correct calculation

    // Create the bill entry
    Bill::create([
        'customer_subscription_id' => $subscription->id,
        'customer_id' => $subscription->customer_id, // Ensure you have access to customer_id
        'amount' => $amount, // Use the calculated amount
        'due_date' => $dueDate, // Use the calculated due date
        'subscription_plan_id' => $subscription->subscription_plan_id,
        'subscription_start_date' => $subscription->start_date,
        'subscription_end_date' => $subscription->end_date,
        'remaining_ads_normal' => $subscription->remaining_ads_normal,
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
