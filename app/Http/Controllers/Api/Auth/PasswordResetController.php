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

        $verificationCode =5555;

        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => $verificationCode, 'created_at' => Carbon::now()]
        );

      //  Mail::raw("Your verification code is: $verificationCode", function ($message) use ($request) {
        //    $message->to($request->email)->subject('Password Reset Verification Code');
        //});

        return response()->json([
            'message' => 'Verification code sent successfully',
            'code' =>   $verificationCode 
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

