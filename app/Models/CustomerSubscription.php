<?php

namespace App\Models;

use App\Models\Customers;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerSubscription extends Model
{
    use HasFactory;


    protected $guarded=[];

    protected $table="customer_subscriptions";
    
    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
