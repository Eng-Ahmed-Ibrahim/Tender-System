<?php

namespace App\Models;

use App\Models\Customers;
use App\Models\SubscriptionPlan;
use App\Models\CustomerSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_subscription_id',
        'amount',
        'due_date',
        'subscription_plan_id',
        'subscription_start_date',
        'subscription_end_date',
        'remaining_ads_normal',
        'remaining_ads_commercial',
        'remaining_ads_popup',
        'remaining_ads_banners',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customers::class,'customer_id');
    }

    public function customerSubscription()
    {
        return $this->belongsTo(CustomerSubscription::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
