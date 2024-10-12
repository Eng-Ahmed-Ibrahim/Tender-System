<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the current user
            $user = Auth::user();

            // Redirect based on the dashboard column value
            if ($user->dashboard === 'admin') {
                return redirect()->route('admin.dashboard'); // Adjust this route as needed
            } elseif ($user->dashboard === 'company') {
                return redirect()->route('company.dashboard'); // Adjust this route as needed
            }
        }

        // If not authenticated or no specific dashboard role, proceed with the request
        return $next($request);
    }
}
