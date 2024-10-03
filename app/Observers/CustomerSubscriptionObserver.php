<?php

namespace App\Observers;

use App\Models\Bill;
use App\Models\User;
use App\Models\CustomerSubscription;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminSubscriptionNotification;

class CustomerSubscriptionObserver
{
    public function created(CustomerSubscription $subscription)
    {
        $this->createBill($subscription);

        $admin = User::where('role_id',1)->first();  // Retrieve a valid admin object
        if ($admin) {
            $admin->notify(new AdminSubscriptionNotification($subscription,'create'));
        }
    }

    public function updated(CustomerSubscription $subscription)
    {
        $this->updateBill($subscription);

        $admin = User::where('role_id',1)->first();  // Retrieve a valid admin object
        if ($admin) {
            $admin->notify(new AdminSubscriptionNotification($subscription,'updated'));
        }

    }

    protected function createBill(CustomerSubscription $subscription)
{
    $amount = $this->calculateAmount($subscription);

    $durationInMonths = $this->getDurationInMonths($subscription->subscriptionPlan->duration);
    $dueDate = now()->addMonths($durationInMonths); 

    Bill::create([
        'customer_subscription_id' => $subscription->id,
        'customer_id' => $subscription->customer_id,
        'amount' => $amount, 
        'due_date' => $dueDate, 
        'subscription_plan_id' => $subscription->subscription_plan_id,
        'subscription_start_date' => $subscription->start_date,
        'subscription_end_date' => $subscription->end_date,
        'remaining_ads_normal' => $subscription->remaining_ads_normal,
        'remaining_ads_commercial' => $subscription->remaining_ads_commercial,
        'remaining_ads_popup' => $subscription->remaining_ads_popup,
        'remaining_ads_banners' => $subscription->remaining_ads_banners,
        'status' => 'New subscription'
    ]);
}
protected function updateBill(CustomerSubscription $subscription)
{
    $amount = $this->calculateAmount($subscription);

    $durationInMonths = $this->getDurationInMonths($subscription->subscriptionPlan->duration);
    $dueDate = now()->addMonths($durationInMonths); 

    Bill::create([
        'customer_subscription_id' => $subscription->id,
        'customer_id' => $subscription->customer_id,
        'amount' => $amount, 
        'due_date' => $dueDate, 
        'subscription_plan_id' => $subscription->subscription_plan_id,
        'subscription_start_date' => $subscription->start_date,
        'subscription_end_date' => $subscription->end_date,
        'remaining_ads_normal' => $subscription->remaining_ads_normal,
        'remaining_ads_commercial' => $subscription->remaining_ads_commercial,
        'remaining_ads_popup' => $subscription->remaining_ads_popup,
        'remaining_ads_banners' => $subscription->remaining_ads_banners,
        'status' => 'Updated subscription'
    ]);
}

    protected function calculateAmount(CustomerSubscription $subscription)
    {
        return $subscription->subscriptionPlan->price;
    }

    protected function getDurationInMonths($duration)
    {
        return $duration; // Assuming the duration is already in months
    }
}
