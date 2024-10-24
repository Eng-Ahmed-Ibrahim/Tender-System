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
        'fcm_token' => 'required|string', // Ensure fcm_token is a string
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $verificationCode = 4444; // Generate a 6-digit verification code

    // Create or update the customer record
    $customer = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'company',
        'password' => bcrypt($request->password), // Hash the password
        'phone' => $request->phone,
        'verification_code' => $verificationCode,
        'fcm_token' => $request->fcm_token, // Store the FCM token
    ]);

    // Here, you should implement your SMS/email service to send the verification code
    // For demonstration, we return the code in the response
    return response()->json([
        'message' => 'Verification code sent successfully.',
        'verification_code' => $verificationCode, // For testing purposes; remove this in production
    ], 201);
}

    
    public function verify(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|integer', // Ensure it's a 6-digit code
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Retrieve the user using the verification code
        $user = User::where('verification_code', $request->verification_code)->first();
    
        if (!$user) {
            return response()->json(['message' => 'Invalid verification code.'], 400);
        }
    
        // Clear the verification code
        $user->verification_code = null; // Optionally, you might want to consider expiration or one-time use for security
        $user->save();
    
        // Generate a new token for the customer
        $token = $user->createToken('token-name')->plainTextToken;
    
        return response()->json([
            'message' => 'Verification successful. Proceed to the next step.',
            'token' => $token,
        ], 200);
    }
    
}

    


