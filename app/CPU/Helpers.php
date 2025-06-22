<?php

namespace App\CPU;

use App\Mail\OtpMail;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\ResponseTrait;

class Helpers
{
    use ResponseTrait;

    public static function send_otp($user , $otp=null,$email=null)
    {
        $otp = $otp == null ?  rand(10000, 99999) : $otp;
        $email = $email == null ? $user->email : $email; 
        Mail::to($email)->send(new OtpMail(['otp' => $otp]));

        $user->update([
            "verification_code" => $otp,
        ]);
    }

}
