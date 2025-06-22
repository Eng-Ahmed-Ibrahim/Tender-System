<?php

namespace App\Http\Controllers\Api\Profile;


use Exception;
use App\CPU\Helpers;
use App\Models\User;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PendingProfileUpdates;
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


        if ($request->filled("name")) {

            $user->update([
                "name" => $request->name,
            ]);
        }
        if ($request->filled('email') || $request->filled('phone')) {
            $otp=rand(10000, 99999);
            $email=$request->email;
            Helpers::send_otp($user,$otp,$email);
            PendingProfileUpdates::create([
                "user_id" => $user->id,
                "email" => $request->email,
                "phone" => $request->phone,
                "otp"=>$otp,
            ]);
            $message = __('Verification code sent successfully.');
            return response()->json([
                'message' => $message,
            ], 201);
        }

        // Return a response
        return response()->json(['message' => __('Profile updated successfully')]);
    }

    public function verifyProfileUpdates(Request $request)
    {
        $request->validate([
            "otp" => "required",
        ]);
        $user = $request->user();
        $pendingUpdates = PendingProfileUpdates::where("user_id", $user->id)->where('is_verified',false)->latest()->first();
        if (! $pendingUpdates)
            return response()->json([
                'message' => __("Something Happen , Try Again"),
            ], 422);
        if ($pendingUpdates->otp == $request->otp) {
            $user->update([
                "email" => $pendingUpdates->email != null ? $pendingUpdates->email : $user->email,
                "phone" => $pendingUpdates->phone != null ? $pendingUpdates->phone : $user->phone,
            ]);
            $pendingUpdates->delete();
            return response()->json([
                'message' => __("Updated Successfully"),
            ], 201);
        } else {
            return response()->json([
                'message' => __("OTP Invaild"),
            ], 201);
        }
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
                'message' => __('Password is incorrect')
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
