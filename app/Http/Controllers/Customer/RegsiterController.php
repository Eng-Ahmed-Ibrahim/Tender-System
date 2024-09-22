<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Events\CustomerRegistered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegsiterController extends Controller
{
    public function create()
    {
        return view('customers.auth.register');
    }


    public function store(Request $request) {

        $request->validate([
            'name'    =>['required','string','max:255'],
            'email'   =>['required','string','lowercase','max:255','email', 'unique:'.Customers::class],
            'password'=>['required','confirmed', Rules\Password::defaults()]
        ]);

        $customer = Customers::create([

            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),

        ]);

        event(new CustomerRegistered($customer));
        
        Auth::guard('customer')->login($customer);


        return redirect()->route('customer.dashboard');

    }

}
