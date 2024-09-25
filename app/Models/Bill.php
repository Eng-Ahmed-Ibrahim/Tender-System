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

    protected $guarded=[];

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
