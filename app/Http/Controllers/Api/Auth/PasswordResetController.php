<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'Email does not exist'], 404);
        }
    
        $verificationCode = 5555; // You can replace this with dynamic code generation logic
    
        // Check if the password reset record exists
        $passwordReset = PasswordReset::where('email', $request->email)->first();
    
        if ($passwordReset) {
            // Update the existing record
            $passwordReset->token = $verificationCode;
            $passwordReset->created_at = Carbon::now();
            $passwordReset->save(); // Save the updated record
        } else {
            // Create a new record
            $passwordReset = new PasswordReset();
            $passwordReset->email = $request->email;
            $passwordReset->token = $verificationCode;
            $passwordReset->created_at = Carbon::now();
            $passwordReset->save(); // Save the new record
        }
    
        return response()->json([
            'message' => 'Verification code sent successfully',
            'code' => $verificationCode 
        ]);
    }
    


    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string'
        ]);
    
        $passwordReset = PasswordReset::where('email', $request->email)
            ->where('token', $request->code)
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
        $request->validate([
            'password' => 'required|string|confirmed|min:6'
        ]);
    
        // Assuming the user's identity is already established (e.g., through a middleware or token)
        $user = auth()->user(); // Get the currently authenticated user
    
        // Reset the user's password
        $user->password = bcrypt($request->password);
        $user->save();
    
        return response()->json(['message' => 'Password has been reset successfully']);
    }
    








}

