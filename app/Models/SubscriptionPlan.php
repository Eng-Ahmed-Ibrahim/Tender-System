<?php

namespace App\Models;

use App\Models\CustomerSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $guarded=[];

    

    public function customerSubscriptions()
    {
        return $this->hasMany(CustomerSubscription::class);
    }

    
}
