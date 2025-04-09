<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // First check if this is an API request with a locale parameter
        if ($request->is('api/*') && $request->has('locale')) {
            App::setLocale($request->locale); 
        }   
        // Then check for Accept-Language header
        elseif ($request->is('api/*') && $request->hasHeader('Accept-Language')) {
            $locale = substr($request->header('Accept-Language'), 0, 2);
            // You might want to validate against allowed locales
            if (in_array($locale, ['en','ar'])) { // example allowed locales
                App::setLocale($locale);
            } 
        }
        // Fall back to session for web requests 
        elseif (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}


