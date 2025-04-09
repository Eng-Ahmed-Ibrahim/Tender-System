<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {  $user= Auth::User();
        $companyId = $user->company_id;

        $roles = Role::where('company_id',$companyId)->get();
        $permissions = Permission::all();
        return view('backend.roles.create', compact('roles', 'permissions'));
    }
    
/*
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Update the role_id of the user
        $user->update(['role_id' => $request->role]);
        Alert::success('Done','Role changed successfully');

        return redirect()->back();
    }
*/

public function assignRole(Request $request, $userId)
{
$request->validate([
    'role_id' => 'required|exists:roles,id',
]);

$user = User::findOrFail($userId);

$user->role_id = $request->role_id;
$user->save();

    return redirect()->back()->with('success', __('Role assigned successfully.'));
}




// Add this to your store method in the controller
public function store(Request $request)
{
    $user = Auth::user();
    $userId = $user->company_id;
    if (auth()->user()->role == "admin_company" && $userId) {
        $company = Company::where('id', $userId)->first();
        $CompanyName = $company ? $company->name : 'UnknownCompany'.$user->email;
    } else {
        $CompanyName = 'Admin';
    }

    try {
        // Check if permissions are provided
        if (!$request->has('permissions') || empty($request->permissions)) {
            return redirect()->back()
                ->with('error', __('At least one permission must be selected for the role.'))
                ->withInput();
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'permissions.required' => 'At least one permission must be selected.',
            'permissions.min' => 'At least one permission must be selected.'
        ]);
        
        $role = Role::create([
            'title' => $request->input('title'),
            'name' => strtolower($request->input('title')) . '_' . $CompanyName,
            'company_id' => $userId ?? null,
        ]);
        
        $permissions = Permission::whereIn('id', $request->input('permissions', []))->pluck('id');
        
        // Attach permissions to the role
        if ($permissions->isNotEmpty()) {
            $role->syncPermissions($permissions);
        }
         
        return redirect()->back()->with('success', 'Role "' . $role->title . '" created successfully with ' . $permissions->count() . ' permissions.');
    } catch (\Exception $e) {
        return redirect()->back() 
            ->with('error', __('Error creating role: ' . $e->getMessage()))
            ->withInput(); 
    }
}
public function role_permission($roleId)
{
    
    $user= Auth::User();

    $userId =  $user->company_id;

    $role = Role::where('company_id',$userId)->findOrFail($roleId);

    $permissions = Permission::all();
    return view('backend.permissions.role_permission', compact('role', 'permissions'));
}

public function storePermissions(Request $request, $roleId)
{
 $user= Auth::User();

    $userId = $user->company_id;

    $role = Role::where('company_id',$userId)->findOrFail($roleId);

    $permissionIds = $request->input('permissions', []);
    
    $permissions = Permission::whereIn('id', $permissionIds)->get();
    
    // Sync the permissions to the role
    $role->syncPermissions($permissions);
    
    // Return the role and its updated permissions as JSON
    return Redirect()->route('role.create');
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
    public function edit($id)
    {
     $user= Auth::User();

    $userId = $user->company_id;

    $role = Role::where('company_id',$userId)->findOrFail($roleId);
    
    return view('backend.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|string|max:255',
        
    ]);

    $role->update($request->only('name'));

    return redirect()->back();
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user= Auth::User();

        $userId = $user->company_id;
    
        $role = Role::where('company_id',$userId)->findOrFail($id);
        $role->permissions()->detach();
        $role->delete();

        return redirect()->back();
    }
}
