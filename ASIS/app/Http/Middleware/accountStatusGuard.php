<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class accountStatusGuard
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
        if (auth()->guard('enrollees_guard')->check())
        {
            if(auth()->guard('enrollees_guard')->user()->account_status === '7')
            {
                return $next($request);
            }else
            {
                return redirect('/pre/enrollees/home')->with('message', 'Please complete your personal information to proceed!');
            }
        }

        return redirect('/'); // Redirect to the login page or any other route
    }
}
