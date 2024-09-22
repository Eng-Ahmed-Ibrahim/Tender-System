<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Reference to the users table
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans')->onDelete('cascade'); // Reference to the subscription plans table
            $table->dateTime('start_date'); 
            $table->dateTime('end_date'); 
            $table->integer('remaining_ads_normal')->default(0);
            $table->integer('remaining_ads_commercial')->default(0); 
            $table->integer('remaining_ads_popup')->default(0); 
            $table->integer('remaining_ads_banners')->default(0); 
            $table->integer('ads_posted_normal')->default(0); 
            $table->integer('ads_posted_commercial')->default(0); 
            $table->integer('ads_posted_popup')->default(0);
            $table->integer('ads_posted_banners')->default(0); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_subscriptions');
    }
};
