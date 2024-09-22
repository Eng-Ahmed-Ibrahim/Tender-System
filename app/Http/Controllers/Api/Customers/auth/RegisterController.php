<?php

namespace App\Http\Controllers\Api\Customers\auth;

use App\Models\Customers;
use Illuminate\Http\Request;

use Illuminate\Validation\Rules;
use App\Events\CustomerRegistered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    
    public function registerEmailPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:20|unique:customers,phone',
        
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $verificationCode = rand(100000, 999999); // Generate 6-digit verification code

        // Create or update the customer record
        $customer = Customers::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => 'password',
                'phone' => $request->phone,
                'verification_code' => $verificationCode,
            ]
        );

        event(new CustomerRegistered($customer));


        return response()->json([
            'message' => 'Verification code sent successfully.',
            'verification_code' => $verificationCode, // For testing purposes; remove this in production
        ], 201);
    }
    
    public function completeRegistration(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|integer|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Retrieve the customer using the verification code
        $customer = Customers::where('verification_code', $request->verification_code)
                            ->first();

        if (!$customer) {
            return response()->json(['message' => 'Invalid verification code.'], 400);
        }

        // Clear the verification code
        $customer->verification_code = null;
        $customer->save();

        // Generate a new token for the customer
        $token = $customer->createToken('customer-token')->plainTextToken;

        return response()->json([
            'message' => 'Verification successful. Proceed to the next step.',
            'token' => $token,
        ], 200);
    }


    public function social(Request $request)
    {
        // Validate the request
        $request->validate([
            'instgram' => ['nullable', 'string', 'max:255'],
            'linkedIn' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'other' => ['nullable', 'string', 'max:255'],
        ]);
    
        // Retrieve the authenticated customer
        $customer = Auth::guard('customer')->user();
    
        // Check if customer is authenticated
        if (!$customer) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Update only the fields that are provided
        $customer->update(array_filter([
            'instgram' => $request->input('instgram'),
            'linkedIn' => $request->input('linkedIn'),
            'twitter' => $request->input('twitter'),
            'facebook' => $request->input('facebook'),
            'youtube' => $request->input('youtube'),
            'other' => $request->input('other'),
        ]));
    
        return response()->json([
            'message' => 'Social media links updated successfully.',
            'customer' => $customer
        ], 200);
    }
    
    

}
