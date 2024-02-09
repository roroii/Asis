<?php

namespace App\Http\Middleware;

use App\Models\document\doc_modules;
use App\Models\document\_user_privilege;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class handleApplicants
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $previous_session = Auth::User()->session_id;

        if ($previous_session !== Session::getId()) {

            Session::getHandler()->destroy($previous_session);

            $request->session()->regenerate();
            Auth::user()->session_id = Session::getId();

            Auth::user()->save();
        }
        return $next($request);
    }
}
