<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('users')->get();
        return view('backend.companies.index',compact('companies'));

    }

    /**
     * Show the form for creating a new resource.
     */
   
     public function create()
     {
         return view('backend.companies.create');

     }
 

     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|string|min:8',
             'phone' => 'nullable|string',
             'address' => 'nullable|string',
         ]);
     
         // Create and save the company
         $company = new Company(); // Assuming you have a Company model
         $company->name = $validatedData['name']; // Save the name from validated data
         // Add any other necessary fields for the Company model here
         $company->save();
     
         // Create and save the user
         $user = new User();
         $user->fill($validatedData);
         $user->password = Hash::make($validatedData['password']);
         $user->dashboard = 'company';
         $user->company_id = $company->id; // Save the new company's ID in the user
         $user->save();
     
         return redirect()->back()->with('success', 'User and company created successfully.');
     }
     


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      
        $company = Company::findOrFail($id);

        // Get some statistics
        $statistics = [
            'total_users' => $company->users->count(),
            'active_users' => $company->users->where('status', 'active')->count(),
            'created_date' => $company->created_at->format('F d, Y'),
            'last_updated' => $company->updated_at->format('F d, Y'),
        ];

        return view('backend.companies.show', compact('company', 'statistics'));

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
