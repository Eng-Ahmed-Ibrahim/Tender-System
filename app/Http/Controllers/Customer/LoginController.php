<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    
    public function create(){

        return view('customers.auth.login');
    }


    public function store(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('customer.dashboard'));
        }
        return Redirect::back()->withErrors([
            'email' => __('The provided  Email do not match our records.'),
        ]);
        
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ],[
            'email.required' => __('The email field is required.'),
            'email.email' => __('The email must be a valid email address.'),
            'password.required' => __('The password field is required.'),
        ]);
    
    
    
    }


    protected function attemptLogin(Request $request)
    {
        return Auth::guard('customer')->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

   
   

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/customer/login');
    }

}
