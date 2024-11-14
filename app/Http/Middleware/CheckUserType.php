<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user is an industry_partner
        if (auth()->check() && auth()->user()->usertype === 'industry_partner') {
            return $next($request);
        }

        // Redirect or show an error if the user doesn't have access
        return redirect()->route('home')->with('error', 'Access Denied');
    }
}
