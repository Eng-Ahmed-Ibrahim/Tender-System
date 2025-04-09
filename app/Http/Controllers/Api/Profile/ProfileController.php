<?php

namespace App\Http\Controllers\Api\Profile;


use Exception;
use App\Models\User;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function user_profile()
    {
        // Get the authenticated user directly
        $user = auth()->user();
    
        if ($user) {
            return response()->json([
                'profile' => new ProfileResource($user)
            ]);
        }
    
        // Handle the case where no authenticated user is found
        return response()->json(['message' => __('User not authenticated')], 401);
    }
    

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => __('Logged out successfully')], 200);
    }


    
    public function updateProfile(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'nullable|string|max:255', // Make name nullable
            'email' => 'nullable|email|unique:users,email,' . $request->user()->id, // Make email nullable
            'phone' => 'nullable|string|max:15', // Make phone nullable
            'password' => ['required', Password::defaults()], // Password remains required for verification
        ]);
    
        $user = $request->user();
    
        // Check if the provided password matches the current password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => __('Password is incorrect')], 422);
        }
    
        // Update user details only if they are provided
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }
    
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
    
        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }
    
        // Save the updated user information
        $user->save();
    
        // Return a response
        return response()->json(['message' => __('Profile updated successfully')]);
    }
    
    public function changePassword(Request $request)
    {
        // Validate the current password, new password, and password confirmation
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Retrieve the authenticated user
        $user = $request->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => __('Current password is incorrect')], 422);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => __('Password changed successfully')]);
    }

    public function changePhoto(Request $request)
    {
        // Validate the photo upload
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Retrieve the authenticated user
        $user = $request->user();
    
        // Handle the uploaded photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_photos', $filename, 'public');
    
            // Optionally, delete the old photo if it exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
    
            // Update the user's photo path
            $user->photo = $path;
            $user->save();
        }
    
        return response()->json(['message' => __('Photo updated successfully'), 'photo_url' => asset('storage/' . $user->photo)]);
    }
    
    public function deleteAccount(Request $request)
    {
        // Validate the password for security
        $request->validate([
            'password' => 'required',
        ]);
    
        // Get the authenticated user
        $user = $request->user();
    
        // Verify the password matches
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password is incorrect'
            ], 422);
        }
    
        try {
            // Begin a database transaction
            DB::beginTransaction();
    
            // Delete all Sanctum tokens for the user
            $user->tokens()->delete();
    
            // Delete related tender applications
            Applicant::where('user_id', $user->id)->delete();
    
            // Delete user's favorite tenders
            $user->favoriteTenders()->detach();
    
            // Delete any notifications related to the user
            $user->notifications()->delete();
    
            // Delete any associated files (like profile photo)
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
    
            // Delete the user
            $user->delete();
    
            // Commit the transaction
            DB::commit();
    
            // Clear session after successful deletion
            auth()->guard('web')->logout();
        
    
            return response()->json([
                'message' => __('Account deleted successfully')
            ], 200);
    
        } catch (Exception $e) {
            // Rollback in case of error
            DB::rollBack();
    
            Log::error('Account deletion failed: ' . $e->getMessage());
    
            return response()->json([
                'message' => __('Failed to delete account'),
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
