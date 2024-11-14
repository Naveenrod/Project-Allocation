<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if the user is an industry partner and is approved
        if (auth()->user()->industryPartner->approved) {
            // If approved, proceed with the request
            return $next($request);
        }

        return redirect()->back()->with('error', 'Approval Pending.');
    }
}
