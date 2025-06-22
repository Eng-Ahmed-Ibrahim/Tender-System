<?php

namespace App\Http\Controllers\Api\Auth;

use App\CPU\Helpers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ResponseTrait;

class RegisterController extends Controller
{
    use ResponseTrait;

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



        // Create or update the customer record
        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'applicant',
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'verification_code' => null,
            'fcm_token' => $request->fcm_token,
        ]);

        Helpers::send_otp($customer);

        // Use Laravel's translation function with the string directly
        // The middleware will have already set the locale based on Accept-Language
        $message = __('Verification code sent successfully.');
        $token = $customer->createToken('token-name')->plainTextToken;

        return response()->json([
            'message' => $message,
            "email"=>$customer->email,
            "token"=>$token,

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

        if ($user->verification_code != $request->verification_code) {
            return $this->Response(null, __("Invalid OTP"), 422);
        }
        // Clear the verification code
        $user->verification_code = null; // Optionally, you might want to consider expiration or one-time use for security
        $user->email_verified_at = now();
        $user->save();

        // Generate a new token for the customer
        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json([
            'message' => __('Verification successful. Proceed to the next step.'),
            'token' => $token,
        ], 200);
    }
}
