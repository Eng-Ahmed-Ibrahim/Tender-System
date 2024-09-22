<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::all();

        return view('backend.Subscriptions.index',compact('subscriptionPlans'));
    }

    
    public function create()
    {
        return view('backend.Subscriptions.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'normalads' => 'required|integer|min:0',
            'commercialads' => 'required|integer|min:0',
            'popupads' => 'required|integer|min:0',
            'banners' => 'required|integer|min:0',
            'featured_ads' => 'nullable|boolean',
        ]);

        $subscriptionPlan = SubscriptionPlan::create($validatedData);
        $this->translateAndSave($request->all(), 'store');



        return redirect()->route('subscriptions.index')
                         ->with('success', 'Subscription plan created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    
    protected function translateAndSave(array $inputs, $operation)
{
    $languages = ['en', 'fr', 'es', 'ar', 'de', 'tr', 'it', 'ja', 'zh', 'ur'];

    foreach ($inputs as $key => $value) { 
        if (is_string($value) && !empty($value)) {
            // Dispatch the job for each input value
            dispatch(new TranslateText($key, $value, $languages));
        }
    }
}
}
