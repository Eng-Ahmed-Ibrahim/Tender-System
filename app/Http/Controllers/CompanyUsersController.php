<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:company,admin_company',
            'company_id' => 'required|exists:companies,id'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'company_id' => $validated['company_id'],
            'is_active' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => __('User created successfully'),
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Define validation rules
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'phone' => 'nullable|string|min:11|max:11',
                'role' => 'required|string|in:company,admin_company',
            ];
            
            // Only validate password if it's being changed
            if ($request->has('password') && !empty($request->password)) {
                $rules['password'] = 'required|min:8|confirmed';
            }
            
            // Validate the request
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            
            // Update user data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->role = $request->role;
            
            // Update password if provided
            if ($request->has('password') && !empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();
            
            return response()->json([
                'success' => true, 
                'message' => 'User updated successfully',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error updating user: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy(User $user)
    {
        $user->delete();
        
        return response()->json([ 
            'success' => true, 
            'message' => __('User deleted successfully')
        ]);
    }
}
