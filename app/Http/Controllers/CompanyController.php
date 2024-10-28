<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\User;
use App\Models\Tender;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
         try {
             $validated = $request->validate([
                 'name' => 'required|string|max:255',
                 'email' => 'required|email|unique:users,email',
                 'password' => 'required|string|min:8',
                 'phone' => 'nullable|string',
                 'address' => 'nullable|string',
                 'website' => 'nullable|url',
                 'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                 'admin_name' => 'required|string|max:255',
                 'admin_email' => 'required|email|unique:users,email',
                 'status' => 'required',
             ]);
     
             DB::beginTransaction();
     
             // Handle logo upload
             $logoPath = null;
             if ($request->hasFile('logo')) {
                 $logoPath = $request->file('logo')->store('company-logos', 'public');
             }
     
             // Create company
             $company = Company::create([
                 'name' => $validated['name'],
                 'email' => $validated['email'],
                 'phone' => $validated['phone'],
                 'address' => $validated['address'],
                 'website' => $validated['website'],
                 'logo' => $logoPath,
                 'status' => $validated['status'],
             ]);
     
             // Create admin user
             $user = User::create([
                 'name' => $validated['admin_name'],
                 'email' => $validated['admin_email'],
                 'password' => Hash::make($validated['password']),
                 'company_id' => $company->id,
                 'is_active' =>1,
                 'role' => 'admin_company',
             ]);
     
             DB::commit();
     
             return response()->json([
                 'success' => true,
                 'message' => 'Company created successfully',
                 'redirect' => route('companies.index')
             ]);
     
         } catch (Exception $e) {
             DB::rollBack();
     
             return response()->json([
                 'success' => false,
                 'message' => 'Failed to create company'. $e->getMessage()
             ], 500);
         }
     }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      
        $company = Company::findOrFail($id);

        $tenders = Tender::where('company_id',$id)->get();

        // Get some statistics
        $statistics = [
            'total_users' => $company->users->count(),
            'active_users' => $company->users->where('status', 'active')->count(),
            'created_date' => $company->created_at->format('F d, Y'),
            'last_updated' => $company->updated_at->format('F d, Y'),
        ];

        return view('backend.companies.show', compact('company', 'statistics','tenders'));

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('backend.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company updated successfully',
            'company' => $company
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
