<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user is a student
        if (auth()->check() && auth()->user()->usertype === 'teacher') {
            return $next($request);
        }

        // Redirect or show an error if the user doesn't have access
        return redirect()->back()->with('error', 'Access Denied Only Teacher');
    }
}
