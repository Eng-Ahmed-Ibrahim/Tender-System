<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login(Request $request){
    // Validate the request
    $validator = Validator::make($request->all(), [
        'identifier' => 'required|string', // This will be either email or phone
        'password' => 'required|string',
        'fcm_token' => 'required|string', // Ensure fcm_token is a string
    ]);

    if ($validator->fails()) {
        $errors = collect($validator->errors()->toArray())->mapWithKeys(function ($messages, $field) {
            return [$field => array_map(fn($msg) => __($msg), $messages)];
        });
    
        return response()->json(['errors' => $errors], 422); 
    } 
    
 
    // Check if the identifier is an email or phone 
    $user = User::where('email', $request->identifier)
                ->orWhere('phone', $request->identifier)
                ->first();
 
    // Check if user exists and password matches
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => __('Invalid credentials.')], 401);
    }

    // Check if the user has the "applicant" role

    if ($user->role !== 'applicant') {
        return response()->json(['message' => __('Access denied. Only applicants can log in.')], 403);
    }
 
 
    // Update the FCM token
    $user->update([ 
        'fcm_token' => $request->fcm_token,
    ]);

    // Create a new token for the user session
    $token = $user->createToken('token-name')->plainTextToken;

    return response()->json([
        'message' => __('Login successful.'),
        "email"=>$user->email,
        'token' => $token,
    ], 200);
}
    
}


