<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ASIS_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the enrollees is authenticated using the enrollees guard
        if (Auth::guard('enrollees_guard')->check()) {
            return $next($request);
        }

        // Check if the employee is authenticated using the employee guard
        if (Auth::guard('employee_guard')->check()) {
            return $next($request);
        }

        // Check if the students is authenticated using the web guard
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // If neither guard allows access, redirect or return an error response
        return redirect('/'); // Redirect to the login page or any other route
    }
}
