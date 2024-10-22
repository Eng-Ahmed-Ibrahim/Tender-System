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
        $request->validate(['email' => 'required|email']);

        // Check if the email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email does not exist'], 404);
        }

        // Generate a random verification code
        $verificationCode = Str::random(6);

        // Save the code to the password_resets table
        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => $verificationCode, 'created_at' => Carbon::now()]
        );

        // Send the verification code via email
  //      Mail::raw("Your verification code is: $verificationCode", function ($message) use ($request) {
         //   $message->to($request->email)->subject('Password Reset Verification Code');
       // });

        return response()->json(['message' => 'Verification code sent successfully']);
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

