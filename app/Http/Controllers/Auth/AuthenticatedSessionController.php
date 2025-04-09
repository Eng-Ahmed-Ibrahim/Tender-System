<?php

namespace App\Http\Controllers\Auth;

use App\Models\Company;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

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
    
        // Get authenticated user
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Authentication failed.']);
        }
    
        // Check if the user is active
        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['email' => 'Your account is inactive. Please contact support.']);
        }
    
        // Check company status if the user is a company admin
        if (in_array($user->role, ['admin_company', 'company'])) {
            $company = \App\Models\Company::find($user->company_id);
    
            if (!$company || $company->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors(['email' => 'Your company account is inactive. Please contact support.']);
            }
        }
    
        // Regenerate the session for security
        $request->session()->regenerate();
    
        // Redirect based on role
        return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'company.dashboard');
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
