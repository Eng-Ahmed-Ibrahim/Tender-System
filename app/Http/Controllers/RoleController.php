<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $userId = $user->id;

        $roles = Role::where('user_id',$userId)->get();
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

    return redirect()->back()->with('success', 'Role assigned successfully.');
}




public function store(Request $request)
    {

        $user= Auth::User();
        $userId = $user->id;
        
        $request->validate([
            'title' => 'required|string|max:255',
            'permissions' => 'array',
            
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Create the role
        $role = Role::create([
            'title' => $request->input('title'),
            'name' => strlen($request->input('title')).'_'. $userId,
            'user_id' => $userId
        ]);

        // Filter out non-existent permissions
        $permissions = Permission::whereIn('id', $request->input('permissions', []))->pluck('id');

        // Attach permissions to the role
        if ($permissions->isNotEmpty()) {
            $role->syncPermissions($permissions);
        }

        // Redirect with success message
        return redirect()->back();
    }

public function role_permission($roleId)
{
    
    $user= Auth::User();

    $userId = $user->id;

    $role = Role::where('user_id',$userId)->findOrFail($roleId);

    $permissions = Permission::all();
    return view('backend.permissions.role_permission', compact('role', 'permissions'));
}

public function storePermissions(Request $request, $roleId)
{
 $user= Auth::User();

    $userId = $user->id;

    $role = Role::where('user_id',$userId)->findOrFail($roleId);

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

    $userId = $user->id;

    $role = Role::where('user_id',$userId)->findOrFail($roleId);
    
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

        $userId = $user->id;
    
        $role = Role::where('user_id',$userId)->findOrFail($id);
        $role->permissions()->detach();
        $role->delete();

        return redirect()->back();
    }
}
