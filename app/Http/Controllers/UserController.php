<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Enums\DashboardTypeEnum;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{

    public function index(Request $request)
{
    $user = Auth::user();
    $query = User::query();

    // Apply company filters based on user role
    if ($user->role == 'admin') {
        $query->whereNull('company_id')->where('role','admin');
        $roles = Role::whereNull('company_id')->get();
    } else {
        $query->where('company_id', $user->company_id);
        $roles = Role::where('company_id', $user->company_id)->get();
    }

    // Filter by active status
    if ($request->filled('is_active')) {
        $query->where('is_active', $request->is_active);
    }

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    if ($request->filled('role')) {
        $query->where('role_id', $request->role);
    }

    // Date range filter
    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
    }

    // Sort filter
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
        }
    }

    if ($request->filled('bulk_action') && $request->filled('user_ids')) {
        $userIds = $request->user_ids;

        switch ($request->bulk_action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['is_active' => 1]);
                break;

            case 'deactivate':
                User::whereIn('id', $userIds)->update(['is_active' => 0]);
                break;

            case 'delete':
                User::whereIn('id', $userIds)->delete();
                break;
        }
    }
    $users = $query->paginate(12)->withQueryString();

    $statistics = [
        'total_users' => $query->count(),
        'new_users' => $query->where('created_at', '>=', now()->subDays(30))->count(),
        'total_roles' => $roles->count(),
        'active_users' => $query->where('is_active', 1)->count(),
        'inactive_users' => $query->where('is_active', 0)->count(),
    ];

    // Handle AJAX requests for user cards partial
    if ($request->ajax()) {
        return view('backend.users.partials.user-cards', compact('users'))->render();
    }

    // Return the view with data
    return view('backend.users.index', compact('users', 'roles', 'statistics'));
}

public function importUsers(Request $request)
{
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    try {
        Excel::import(new UsersImport, $request->file('excel_file'));

        return redirect()->route('AdminUsers.index')->with('success', 'Users imported successfully.');
    } catch (\Exception $e) {
        return back()->with('error', 'Import failed: ' . $e->getMessage());
    }
}

public function export(Request $request)
{
    $format = $request->format ?? 'csv';
    $user = Auth::user();
    
    $query = User::query()
        ->when($user->dashboard === 'company', function($query) use ($user) {
            return $query->where('company_id', $user->id);
        });



    if ($request->filled('role')) {
        $query->where('role_id', $request->role);
    }

    $users = $query->get();
    $roles = Role::all(); 
    

    switch ($format) {
        case 'excel':
            return Excel::download(new UsersExport($users), 'users.xlsx');
        case 'pdf':
            $pdf = app('dompdf.wrapper');
            return $pdf->loadView('pdf.users', compact('users','roles'))
                      ->download('users.pdf');
        default:
            return (new UsersExport($users))->download('users.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}

 
    public function create()
    {
        $user = Auth::user();
        if ($user->role === 'admin') { 
            $roles = Role::whereNull('company_id')->get();
        } else {
            $roles = Role::where('company_id',$user->company_id)->get();
        }   
       
        return view('backend.users.create',compact('roles')); 
    }
 
    /** 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user= Auth::User();

        if($user->role == 'admin_company'){

            $company_id = $user->company_id;
            $rolee = 'admin_company';
        }else {

            $company_id = null;
            $rolee =   'admin';


        }
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
            'address' => 'required|string',
            'role_id' => 'required|exists:roles,id', 
        ]); 
    
        // Begin a database transaction
        DB::beginTransaction();
    
        try {
            $user = new User();
            $user->fill($validatedData);
            $user->password = Hash::make($validatedData['password']);
            $user->company_id = $company_id;
            $user->role =  $rolee;
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
    
        // Retrieve the role by ID
        $role = Role::findOrFail($request->role_id);
    
        // Assign the role using Spatie's method
        $user->syncRoles([$role->name]);
    
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

        return redirect()->back()->with('success', __('Role updated successfully'));
    } catch (Exception $e) {
        // Rollback the transaction if an exception occurs
        DB::rollback();

        // Handle the error (e.g., log it or display a message)
        return redirect()->back()->with('error', __('Failed to update role: ' . $e->getMessage()));
    }
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $userauth = Auth::user();
        if ($userauth->role === 'admin') { 
            $roles = Role::whereNull('company_id')->get();
        } else {
            $roles = Role::where('company_id',$user->company_id)->get();
 
        }   
         
        return view('backend.users.edit', compact('user', 'roles'));
    } 
    public function edit_user($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'name' => [
            'required',
            'string',
            'max:255',
            'regex:/^[A-Za-z0-9\s.,!?@#$%^&*()_\-+=[\]{}|:;<>\'"\\/\\\\]+$/' // English characters regex
        ],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users,email,' . $user->id
        ],
        'password' => [
            'nullable',
            'string',
            'min:8'
        ],
        'phone' => [
            'nullable',
            'regex:/^\d{11}$/'
        ],
        'address' => [
            'nullable',
            'string',
            'regex:/^[A-Za-z0-9\s.,!?@#$%^&*()_\-+=[\]{}|:;<>\'"\\/\\\\]+$/' // English characters regex
        ],
        'role_id' => [
            'required',
            'exists:roles,id'
        ]
    ], [
        'name.regex' => __('Name must contain only English characters.'),
        'phone.regex' => __('Phone number must be exactly 11 digits.'),
        'address.regex' => __('Address must contain only English characters.')
    ]);

    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Update user data
    $user->name = $request->name;
    $user->email = $request->email;
    
    // Only update password if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->role_id = $request->role_id;
    
    $user->save();
    
    return redirect()
        ->route('AdminUsers.index')
        ->with('success', __('User updated successfully.'));
}


    /**
     * Remove the specified resource from storage.
     */
   /**
 * Remove the specified user from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User deleted successfully'));
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', __('Failed to delete user: ') . $e->getMessage());
    }
}

/**
 * Toggle the active status of the specified user.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function toggleStatus($id)
{
    try {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        
        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', __("User {$status} successfully"));
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', __('Failed to update user status: ') . $e->getMessage());
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