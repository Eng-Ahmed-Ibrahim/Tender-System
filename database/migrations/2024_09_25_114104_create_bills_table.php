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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Reference to the customers table
            $table->foreignId('customer_subscription_id')->constrained('customer_subscriptions')->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Total amount for the bill
            $table->dateTime('due_date')->nullable(); // Due date for the bill
            
            // Add fields to capture the subscription details
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans')->onDelete('cascade'); // The subscription plan
            $table->dateTime('subscription_start_date'); // Subscription start date
            $table->dateTime('subscription_end_date'); // Subscription end date
            $table->integer('remaining_ads_normal')->default(0); // Remaining ads for normal
            $table->integer('remaining_ads_commercial')->default(0); // Remaining ads for commercial
            $table->integer('remaining_ads_popup')->default(0); // Remaining ads for popup
            $table->integer('remaining_ads_banners')->default(0); // Remaining ads for banners
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
