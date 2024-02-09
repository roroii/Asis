<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmployeeAuth
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
        if (auth()->guard('employee_guard')->check()) {

            return $next($request);

        }else if (auth()->guard('enrollees_guard')->check())
        {
            return redirect('/pre/enrollees/home');

        }else if (auth()->guard('web')->check())
        {
            return redirect('/home');
        }

        return redirect('/'); // Redirect to the login page or any other route
    }
}
