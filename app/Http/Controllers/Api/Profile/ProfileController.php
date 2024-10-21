<?php

namespace App\Http\Controllers\Api\Profile;

use Storage;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Password;

class ProfileController extends Controller
{
    public function user_profile(){

        $user = Auth::User();

        $userId = $user->id;

        $profileDate = User::where('id',$userId)->first();


        return response()->json([
            'profile'=> new ProfileResource($profileDate)
        ]);


    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }


    public function updateProfile(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'phone' => 'required|string|max:15',
            'password' => ['required', Password::defaults()],
        ]);
    
        $user = $request->user();
    
        // Check if the provided password matches the current password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password is incorrect'], 422);
        }
    
        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
    
        // Save the updated user information
        $user->save();
    
        // Return a response
        return response()->json(['message' => 'Profile updated successfully']);
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
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
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
    
        return response()->json(['message' => 'Photo updated successfully', 'photo_url' => asset('storage/' . $user->photo)]);
    }
    

}
