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
use Spatie\Permission\Models\Permission;

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
                 'commercial_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                 'admin_name' => 'required|string|max:255',
                 'admin_email' => 'required|email|unique:users,email',
                 'admin_phone' => 'required',
                 'status' => 'required',
             ]);
     
             DB::beginTransaction();
     
             // Handle logo upload
             $logoPath = null;
             if ($request->hasFile('logo')) {
                 $logoPath = $request->file('logo')->store('company-logos', 'public');
             }
             
             // Handle commercial photo upload
             $Commercial = null;
             if ($request->hasFile('commercial_photo')) {
                 $Commercial = $request->file('commercial_photo')->store('Commercial', 'public');
             }
     
             // Create company
             $company = Company::create([
                 'name' => $validated['name'],
                 'email' => $validated['email'],
                 'phone' => $validated['phone'],
                 'address' => $validated['address'],
                 'website' => $validated['website'],
                 'logo' => $logoPath,
                 'commercial_photo' => $Commercial,
                 'status' => $validated['status'],
             ]);
     
             // Create admin user
             $user = User::create([
                 'name' => $validated['admin_name'],
                 'email' => $validated['admin_email'],
                 'phone' => $validated['admin_phone'],
                 'password' => Hash::make($validated['password']),
                 'company_id' => $company->id,
                 'is_active' => 1,
                 'role' => 'admin_company',
             ]);
     
             // Create a superadmin role for this company
             $roleName = 'superadmin_' . strtolower(str_replace(' ', '_', $company->name));
             $role = Role::create([
                 'title' => 'Super Admin',
                 'name' => $roleName,
                 'company_id' => $company->id,
             ]);
     
             // Get all permissions
             $allPermissions = Permission::all()->pluck('id');
     
             // Attach all permissions to the role
             $role->syncPermissions($allPermissions);
     
             // Assign the role to the user
             $user->assignRole($role);
     
             DB::commit();
     
             return response()->json([
                 'success' => true,
                 'message' => __('Company created successfully'),
                 'redirect' => route('companies.index')
             ]);
     
         } catch (Exception $e) {
             DB::rollBack();
     
             return response()->json([
                 'success' => false,
                 'message' => 'Failed to create company: ' . $e->getMessage()
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
        try {
            // First, check if email is being changed
            $emailRule = 'required|email';
            if ($request->email != $company->email) {
                // Only add the unique check if email is actually changing
                $emailRule .= '|unique:companies,email,' . $company->id;
            }
           
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => $emailRule,
                'phone' => 'nullable|string|max:20',
                'website' => 'nullable|url',
                'address' => 'nullable|string',
                'status' => 'required|in:active,unactive',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'commercial_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            // Handle logo upload
            if ($request->hasFile('logo')) {
                if ($company->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($company->logo)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($company->logo);
                }
                $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
            }
            
            // Handle commercial photo upload
            if ($request->hasFile('commercial_photo')) {
                if ($company->commercial_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($company->commercial_photo)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($company->commercial_photo);
                }
                $validated['commercial_photo'] = $request->file('commercial_photo')->store('commercial-photos', 'public');
            }
    
            // Update the company
            $company->update($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Company updated successfully',
                'company' => $company
            ]);
        } catch (\Exception $e) {
            // Log error and return error response
            \Illuminate\Support\Facades\Log::error('Company update error: ' . $e->getMessage());
           
            return response()->json([
                'success' => false,
                'message' => __('Error updating company: ' . $e->getMessage())
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $company = Company::findOrFail($id);
            $company->delete();
            
            return redirect()->route('companies.index')
                ->with('success', __('Company deleted successfully'));
        } catch (\Exception $e) {
            return redirect()->route('companies.index')
                ->with('error', __('Failed to delete company: ' . $e->getMessage()));
        }
    }
 
    public function toggleStatus($id)
{
    $company = Company::findOrFail($id);
    $company->status = $company->status === 'active' ? 'unactive' : 'active';
    $company->save();
    
    $message = $company->status === 'active' ? __('Company activated successfully') : __('Company deactivated successfully');
    
    return redirect()->back()->with('success', $message);
}
 
} 
