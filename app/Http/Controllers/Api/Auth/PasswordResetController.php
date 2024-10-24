<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    public function sendVerificationCode(Request $request)
{
    // Validate the request to ensure either email or phone is provided
    $request->validate([
        'identifier' => 'required|string', // This will be either email or phone
    ]);

    // Check if the identifier is an email or phone
    $user = User::where('email', $request->identifier)
                ->orWhere('phone', $request->identifier)
                ->first();

    if (!$user) {
        return response()->json(['message' => 'Identifier does not exist'], 404);
    }

    $verificationCode = 5555; // You can replace this with dynamic code generation logic

    // Check if the password reset record exists
    $passwordReset = PasswordReset::where('email', $user->email)->first();

    if ($passwordReset) {
        // Update the existing record
        $passwordReset->token = $verificationCode;
        $passwordReset->created_at = Carbon::now();
        $passwordReset->save(); // Save the updated record
    } else {
        // Create a new record
        $passwordReset = new PasswordReset();
        $passwordReset->email = $user->email; // Use the user's email
        $passwordReset->token = $verificationCode;
        $passwordReset->created_at = Carbon::now();
        $passwordReset->save(); // Save the new record
    }

    return response()->json([
        'message' => 'Verification code sent successfully',
        'code' => $verificationCode // For testing purposes; remove this in production
    ]);
}



    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);
    
        $passwordReset = PasswordReset::where('token', $request->code)
            ->first();
    
        if (!$passwordReset) {
            return response()->json(['message' => 'Invalid verification code'], 400);
        }
    
        if (Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['message' => 'Verification code has expired'], 400);
        }
    
        return response()->json(['message' => 'Verification code is valid']);
    }
    
    public function resetPassword(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'email' => 'required|email|exists:users,email', // Ensure email is required, valid, and exists in users table
            'password' => 'required|string|confirmed|min:6', // Validate password and confirmation
        ]);
    
        // Find the user by email
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        // Reset the user's password
        $user->password = bcrypt($request->password);
        $user->save();
    
        // Optional: Send email confirmation (if needed)
        // Mail::to($user->email)->send(new PasswordResetSuccess($user));
    
        return response()->json(['message' => 'Password has been reset successfully.']);
    }
    
    








}

