<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
            'fcm_token' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            $errors = collect($validator->errors()->toArray())->mapWithKeys(function ($messages, $field) {
                return [$field => array_map(fn($msg) => __($msg), $messages)];
            });
    
            return response()->json(['errors' => $errors], 422);
        }
    
    
        $verificationCode = 4444; // Generate a verification code 
        
        // Create or update the customer record
        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'applicant',
            'password' => bcrypt($request->password),
            'phone' => $request->phone, 
            'verification_code' => $verificationCode, 
            'fcm_token' => $request->fcm_token,
        ]);
    
        // Use Laravel's translation function with the string directly
        // The middleware will have already set the locale based on Accept-Language
        $message = __('Verification code sent successfully.');
        
        return response()->json([
            'message' => $message,
            'verification_code' => $verificationCode, // For testing purposes
        ], 201);
    }
    
    public function verify(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|integer',
            'email' => 'required|email' // or 'phone' => 'required|string'
        ]);
        
        // Look up the user by both email and verification code
        $user = User::where('email', $request->email)
                   ->where('verification_code', $request->verification_code)
                   ->first();
                   
        if (!$user) {
            return response()->json(['message' => __('Invalid verification code or email.')], 400);
        }
    
        // Clear the verification code
        $user->verification_code = null; // Optionally, you might want to consider expiration or one-time use for security
        $user->save();
    
        // Generate a new token for the customer
        $token = $user->createToken('token-name')->plainTextToken;
    
        return response()->json([
            'message' => __('Verification successful. Proceed to the next step.'),
            'token' => $token,
        ], 200);
    }
    
}

    


