<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    } 

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();
    
        // Regenerate the session to prevent session fixation
        $request->session()->regenerate();
    
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
    
            // Redirect based on the user's dashboard role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); 
            } elseif ($user->role === 'company') {
                return redirect()->route('company.dashboard'); 
            }
        }
    
        // Fallback: Redirect to a default page if no conditions were met
        return redirect()->back(); // Change 'home' to a suitable route for your application
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
