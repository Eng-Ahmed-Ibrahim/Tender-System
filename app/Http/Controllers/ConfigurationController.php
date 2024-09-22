<?php

namespace App\Http\Controllers;

use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\Storage;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configuration = Configuration::first();
        if (!$configuration) {
            $configuration = Configuration::create();
        }        return view('backend.configuration.index',compact('configuration'));
    }

    /**
     * Show the form for creating a new resource.
     */
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

    public function update(Request $request)
    {
        $request->validate([
            'whatsApp' => 'nullable|numeric',
            'phone_number' => 'nullable|numeric',
            'email' => 'nullable|email',
            'owner_name' => 'nullable|string|max:255',
            'terms_condition_en' => 'nullable|string',
            'terms_condition_ar' => 'nullable|string',
            'refund_policy_en' => 'nullable|string',
            'refund_policy_ar' => 'nullable|string',
            'privacy_policy_en' => 'nullable|string',
            'privacy_policy_ar' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $configuration = Configuration::first();
        if (!$configuration) {
            $configuration = Configuration::create();
        }

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($configuration->logo) {
                Storage::delete($configuration->logo);
            }

            // Store new logo
            $path = $request->file('logo')->store('logos', 'public');
            $configuration->logo = $path;
        }
      
        // Update only if the value is set
        $configuration->update(array_filter($request->only([
            'whatsApp',
            'phone_number',
            'email',
            'owner_name',
            'terms_condition_en',
            'terms_condition_ar',
            'refund_policy_en',
            'refund_policy_ar',
            'privacy_policy_en',
            'privacy_policy_ar',
        ])));

        $this->translateAndSave($request->all(), 'update');


        return redirect()->route('configurations.index')->with('success', 'Configuration updated successfully.');
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
