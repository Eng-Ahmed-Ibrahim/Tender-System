<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Bill;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\View;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bill::query();
    
        // Apply filters if present in the request
        if ($request->has('customer_id') && $request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }
    
        if ($request->has('subscription_plan_id') && $request->subscription_plan_id) {
            $query->where('subscription_plan_id', $request->subscription_plan_id);
        }
    
        if ($request->has('due_date') && $request->due_date) {
            $query->whereDate('due_date', $request->due_date);
        }
    
        if ($request->has('remaining_ads_normal')) {
            $query->where('remaining_ads_normal', '>', $request->remaining_ads_normal);
        }
    
        if ($request->has('remaining_ads_commercial')) {
            $query->where('remaining_ads_commercial', '>', $request->remaining_ads_commercial);
        }
    
        // Filter by amount (min and max)
        if ($request->has('min_amount') && $request->min_amount) {
            $query->where('amount', '>=', $request->min_amount);
        }
    
        if ($request->has('max_amount') && $request->max_amount) {
            $query->where('amount', '<=', $request->max_amount);
        }
    
        // Get the filtered results
        $bills = $query->get();
    
        // Preload customers and subscription plans for the filters
        $customers = Customers::all();
        $subscriptionPlans = SubscriptionPlan::all();
    
        // Pass filters to the view to maintain them after filtering
        return view('backend.bills.index', compact('bills', 'customers', 'subscriptionPlans'));
    }
    
    

    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::findOrFail($id);

        return view('backend.bills.show',compact('bill'));
        
    }
    public function printInvoice($id)
    {
        $bill = Bill::with(['customer', 'customerSubscription.subscriptionPlan'])
                    ->findOrFail($id);
    
        $configuration = \App\Models\Configuration::first();
    
        $pdf = PDF::loadView('backend.bills.bill-pdf', compact('bill', 'configuration'));
    
        return $pdf->download("invoice-{$bill->id}.pdf");
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
