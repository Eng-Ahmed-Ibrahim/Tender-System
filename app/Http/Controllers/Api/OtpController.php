<?php

namespace App\Http\Controllers\Api;

use App\CPU\Helpers;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    use ResponseTrait;
    
    public function send_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "identifier" => "required",
        ]);

        if ($validator->fails()) {
            return $this->Response($validator->errors()->first(), "Data Not Valid", 422);
        }

        $user = User::where("email", $request->identifier)
        ->orWhere('phone', $request->identifier)
        ->first();
        if (! $user) {
            return $this->Response(null, __('User Not Found'), 422);
        }
        
        Helpers::send_otp($user);

        return response()->json(['message' => __('OTP sent successfully.')]);
    }

    public function verify_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "identifier" => "required",
            "otp" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return $this->Response($validator->errors()->first(), "Data Not Valid", 422);
        }

        $user = User::where("email", $request->identifier)->orWhere('phone', $request->identifier)->first();
        if (! $user) {
            return $this->Response(null, __('User Not Found'), 422);
        }
        if ($user->verification_code != $request->otp) {
            return $this->Response(null, __("Invalid OTP"), 422);
        }
        $user->update([
            "verification_code" => null,
            "email_verified_at" => now(),
        ]);
        return response()->json(['message' => __('Account verified successfully.')]);
    }
}
