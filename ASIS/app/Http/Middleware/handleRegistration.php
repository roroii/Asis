<?php

namespace App\Http\Middleware;

use App\Models\tblemployee;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class handleRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            if(Auth::user()->role != 'Admin')
            {
                abort(403, 'Restricted Access: Your account does not have the necessary privileges to access this feature. Please reach out to the system administrator for help.');
            }
        }

        return $next($request);
    }
}
