<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{
    protected $modelClass = Company::class;
    protected $viewPrefix = 'backend.companies';
    protected $routePrefix = 'companies';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email', // For create
            'password' => 'required|string|min:8|confirmed', // For create
            'phone' => 'nullable|numeric|digits_between:10,15',
            'address' => 'nullable|string|max:255',
            'is_active' => 'nullable|in:1,0',
         ];
    }
    public function show($id) {
        $company = Company::with(['NormalAds', 'CommericalAds', 'subscriptions','bills'])->findOrFail($id);    
        if (!$company) {
            return redirect()->back()->with('error', 'company not found.');
        }

        $companyId = $company->id;

    
        return view('backend.companies.show', compact('company','normalCount','commercialCount','billsCount'));
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
    
        Company::create($validated);
    
        return $this->redirectToIndex('company created successfully.');
    }
    
    public function update(Request $request, $id)
    {
        // Retrieve the company model by ID
        $company = Company::findOrFail($id);
    
        // Validate request with unique email check excluding the current record
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:companies,email,' . $id,
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
    
        // Update the company

        $company->update($validated);

        $this->translateAndSave($request->all(), 'store');

    
        return $this->redirectToIndex('company updated successfully.');
    }

    public function toggleStatus(Company $company)
    {
        $company->is_active = !$company->is_active; // Toggle the status
        $company->save();
    
        return redirect()->back()->with('status', 'company status updated successfully!');
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
