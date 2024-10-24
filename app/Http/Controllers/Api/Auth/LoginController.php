<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string', // This will be either email or phone
            'password' => 'required|string',
            'fcm_token' => 'required|string', // Ensure fcm_token is a string
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Check if the identifier is an email or phone
        $user = User::where('email', $request->identifier)
                    ->orWhere('phone', $request->identifier)
                    ->first();
    
        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }
    
        // Update the FCM token
        $user->update([
            'fcm_token' => $request->fcm_token,
        ]);
    
        // Create a new token for the user session
        $token = $user->createToken('token-name')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
        ], 200);
    }
    
}


