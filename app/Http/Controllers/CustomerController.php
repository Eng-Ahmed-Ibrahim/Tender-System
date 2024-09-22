<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    protected $modelClass = Customers::class;
    protected $viewPrefix = 'backend.customers';
    protected $routePrefix = 'customers';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email', // For create
            'password' => 'required|string|min:8|confirmed', // For create
            'phone' => 'nullable|numeric|digits_between:10,15',
            'address' => 'nullable|string|max:255',
            'is_active' => 'nullable|in:1,0',
         ];
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
    
        // Hash password before storing
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }
    
        // Ensure 'is_active' is treated as a boolean
        $validated['is_active'] = isset($validated['is_active']) ? (bool) $validated['is_active'] : false;
    
        Customers::create($validated);
    
        return $this->redirectToIndex('Customer created successfully.');
    }
    
    public function update(Request $request, $id)
    {
        // Retrieve the customer model by ID
        $customer = Customers::findOrFail($id);
    
        // Validate request with unique email check excluding the current record
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:customers,email,' . $id,
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
    
        // Handle optional password field
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
    
        // Update the customer

        $customer->update($validated);

        $this->translateAndSave($request->all(), 'store');

    
        return $this->redirectToIndex('Customer updated successfully.');
    }


  protected function translateAndSave(array $inputs, $operation)
{
    $languages = ['en', 'fr', 'es', 'ar', 'de', 'tr', 'it', 'ja', 'zh', 'ur'];

    foreach ($inputs as $key => $value) { 
        if (is_string($value) && !empty($value)) {
            dispatch(new TranslateText($key, $value, $languages));
        }
    }
}

    

}
