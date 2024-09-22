<?php

namespace App\Http\Controllers\Api\Customers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customers;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20', // Adjust validation as needed
        ]);

        $customer = Customers::where('phone', $request->phone)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        $verificationCode = random_int(100000, 999999);

        // Save the verification code and its expiration time
        $customer->verification_code = $verificationCode;
        $customer->save();

        // Send verification code to the customer (e.g., via SMS)
        // You need to implement your SMS sending logic here
        return response()->json([
            'message' => 'Verification code sent successfully.',
            'verification_code' => $verificationCode, // For testing purposes; remove this in production
        ], 201);
    }
    
    

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }
}
