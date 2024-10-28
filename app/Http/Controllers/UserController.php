<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Enums\DashboardTypeEnum;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Your existing index method remains the same
        // But let's add some additional statistics
        $user = Auth::user();
        $query = User::query()
            ->with(['roles']) // Change 'role' to 'roles' if using spatie/laravel-permission
            ->when($user->role === 'admin_company', function($query) use ($user) {
                return $query->where('company_id', $user->id);
            });

        // Add status check if you have a status column
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->status);
        }

        // Your existing search, role, and date filters...

        // Get users with pagination
        $users = $query->paginate(12)->withQueryString();

        // Get roles based on company context
        $roles = Role::when($user->role === 'admin_company', function($query) use ($user) {
            return $query->where('company_id', $user->company_id);
        })->get();

        // Enhanced statistics
        $statistics = [
            'total_users' => $query->count(),
            'new_users' => $query->where('created_at', '>=', now()->subDays(30))->count(),
            'total_roles' => $roles->count(),
            'active_users' => $query->where('is_active',1)->count(),
            'inactive_users' => $query->where('is_active', 0)->count(),
        ];

        if ($request->ajax()) {
            return view('backend.users.partials.user-cards', compact('users'))->render();
        }

        return view('backend.users.index', compact('users', 'roles', 'statistics'));
    }
    public function export(Request $request)
    {
        $format = $request->format ?? 'csv';
        $user = Auth::user();
        
        $query = User::query()
            ->when($user->dashboard === 'company', function($query) use ($user) {
                return $query->where('company_id', $user->id);
            });

        // Apply filters if any
        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }

        $users = $query->get();

        // Handle different export formats
        switch ($format) {
            case 'excel':
                return Excel::download(new UsersExport($users), 'users.xlsx');
            case 'pdf':
                return PDF::loadView('exports.users', compact('users'))
                    ->download('users.pdf');
            default:
                return (new UsersExport($users))->download('users.csv', \Maatwebsite\Excel\Excel::CSV);
        }
    }
  

 
    public function create()
    {
        $roles = Role::all();
        return view('backend.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user= Auth::User();
        $userId = $user->id;
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
        ]);
    
        // Begin a database transaction
        DB::beginTransaction();
    
        try {
            $user = new User();
            $user->fill($validatedData);
            $user->password = Hash::make($validatedData['password']);
            //$user->company_id = $userId;
            $user->save();
    
            // Assign the role to the user
            $role = Role::findOrFail($validatedData['role_id']);
            $user->assignRole($role);
    
            // Commit the transaction
            DB::commit();
    
    
            return redirect()->route('AdminUsers.index');
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();
    
            // Log the error
            Log::error('Failed to create user', ['error' => $e->getMessage()]);
    
            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

 public function assignRole(Request $request, $userId)
{
// Validate the incoming request data
$request->validate([
    'role_id' => 'required|exists:roles,id',
]);

// Find the user by ID
$user = User::findOrFail($userId);

// Update the user's role
$user->role_id = $request->role_id;
$user->save();

    return redirect()->back()->with('success', 'Role assigned successfully.');
}


public function updateRole(Request $request, $userId)
{
    $request->validate([
        'role_id' => 'required|exists:roles,id',
    ]);

    $user = User::findOrFail($userId);
    $roleId = $request->role_id;

    // Find the role
    $role = Role::findOrFail($roleId);

    // Start a transaction
    DB::beginTransaction();

    try {
        // Update the role_id field of the user
        $user->role_id = $roleId;
        $user->save();

        // Sync the roles and permissions
        $user->syncRoles([$role]);

        // Commit the transaction
        DB::commit();

        return redirect()->back()->with('success', 'Role updated successfully');
    } catch (Exception $e) {
        // Rollback the transaction if an exception occurs
        DB::rollback();

        // Handle the error (e.g., log it or display a message)
        return redirect()->back()->with('error', 'Failed to update role: ' . $e->getMessage());
    }
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
    public function update(Request $request, User $user)
    {
        

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
    
        if (Auth::user()->can('delete.user')) {
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'You do not have permission to delete this user.');
        }
    }
    

    public function updateRoleUser(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,doctor,employee,keeper',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->back();
    }
}