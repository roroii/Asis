<?php

namespace App\Http\Middleware;

use App\Models\ASIS_Models\system\system_modules;
use App\Models\ASIS_Models\system\user_privilege;
use App\Models\doc_modules;
use App\Models\doc_user_privilege;
use App\Models\User;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;

class handleUserPriv
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Ensure the auto_add_url function is called
            auto_add_url();

            // Get the current request path
            $link = request()->path();

            // Find the associated module for the current link
            $getModules = system_modules::where('link', 'like', '%' . $link . '%')
                ->where('important', 1)
                ->where('active', 1)
                ->first();

            $request->session()->forget('get_user_priv');

            if ($getModules) {
                $getUser = auth()->user();
                $get_user_priv = user_privilege::where('module_id', $getModules->id)
                    ->where('user_id', $getUser->employee)
                    ->where('active', 1)
                    ->first();

                // Check if the user has read access or is an admin
                if (($get_user_priv && $get_user_priv->read == 1) || $getUser->role_name == 'Admin') {
                    // Add user privileges to the session
                    Session::push('get_user_priv', $get_user_priv);
                } else {
                    // __notification_set(-1, 'Notice', 'You dont have privilege to access this module, Contact System Administrator.');

                    // Return a 403 Forbidden response when the user doesn't have access
                    abort(403, 'Restricted Access: Your account does not have the necessary privileges to access this feature. Please reach out to the system administrator for help.');
                }
            }
        }

        return $next($request);
    }
}
