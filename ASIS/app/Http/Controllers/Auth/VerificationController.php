<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\system\default_settingNew;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (auth()->guard('enrollees_guard')->check())
        {

            $this->middleware('enrollees_auth');

        }elseif(Auth::check())
        {
            $this->middleware('auth');
        }


        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {

        $agency_name = \App\Models\ASIS_Models\system\default_setting::where('key', 'agency_name')->first();
        $employee_data = $request->user();

        if (auth()->guard('enrollees_guard')->check())
        {
            $students_email = auth()->guard('enrollees_guard')->user()->email;
            Session::put('students_email', $students_email);

            if ($request->user('enrollees_guard')->hasVerifiedEmail())
            {

                return redirect()->route('enrollees_home')
                    ->with(compact('agency_name'));

            }else
            {
                return view('auth.verify', compact('agency_name'));
            }


        }elseif(Auth::check())
        {
            return view('auth.verify', compact('agency_name'));
        }else
        {
            return redirect()->route('login');
        }



//        if(Session::has('students'))
//        {
//            $students_data = Session::get('students');
//            $default_password = '12345678';
//
//            User::updateOrCreate(
//                [
//                    'studid'=> $students_data->studid,
//                    'email'=> $students_data->studemail,
//                ],
//
//                [
//                    'studid'=> $students_data->studid,
//                    'email'=> $students_data->studemail,
//                    'fullname'=> $students_data->studlastname.' '.$students_data->studfirstname.' '.$students_data->studmidname,
//                    'password'=> Crypt::encrypt($default_password),
//                    'active'=> 1,
//                ]
//            );
//        }
    }

}
