<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ScheduleMailer;
use App\Mail\StudentsEmailVerification;
use App\Models\ASIS_Models\posgres\portal\srgb\student;
use App\Models\ASIS_Models\pre_enrollees\enrollees_appointment;
use App\Models\ASIS_Models\system\system_modules;
use App\Models\ASIS_Models\system\user_privilege;
use App\Models\e_hris_models\PDS\pds_educational_bg;
use App\Models\User;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Mail;

class AuthController extends Controller
{
    //

    public function index()
    {
        if (Auth::check())
        {
            // STUDENT is authenticated
            $this->logout();
        }
        if(auth()->guard('enrollees_guard')->check())
        {
            // ENROLLEES is authenticated
            $this->logout();
        }
        if(auth()->guard('employee_guard')->check())
        {
            // EMPLOYEES is authenticated
            $this->logout();
        }

        Session::forget(['full_name', 'student_info', 'students_email', 'students_full_name', 'students','studid']);
        return view('auth.login');

    }

    public function find_my_account()
    {
        return view('auth.find_account.find_my_account');
    }

    public function verify_my_account_view()
    {

        return view('auth.find_account.verify_my_account');

    }

    public function postLogin(Request $request)
    {
        Session::forget(['full_name', 'student_info', 'students_email', 'students_full_name', 'has_email']);

        $cookie = Cookie::make('remember_token', $request->remember);

        if($cookie)
        {
            $remember_me = $cookie;
        }else
        {
            $remember_me = '';
        }

        $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials, $request->filled('remember'))) {
        //     // Authentication passed...

        //     return redirect()->intended('/home');

        // }

        /* Authenticate a default user*/
//    if (Auth::guard('web')->attempt($credentials, $request->filled('remember')))
//    {
//
//        return redirect()->intended('/home');
//
//    } else
//    {
//        //authenticate a second user
//        if (Auth::guard('second_guard')->attempt(['username'=> $request->input('email'), 'password'=> $request->input('password')]))
//        {
//
//            return redirect()->intended('/home');
//
//        }
//        else
//        {
//
//                return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput();
//        }
//
//    }

        /* Authenticate a default user*/

//        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
//
//            return redirect()->intended('/home');
//
//        }
//
//        if (Auth::guard('second_guard')->attempt(['username'=> $request->input('email'), 'password'=> $request->input('password')])) {
//
//
//            return redirect()->intended('/home');
//
//        }
//        if (Auth::guard('enrollees_guard')->attempt($credentials, $request->filled('remember')))
//        {
//
//            return redirect()->intended('/home');
//
//        }


//        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
//            return redirect()->intended('/home');
//
//        } elseif (Auth::guard('second_guard')->attempt(['username' => $request->input('email'), 'password' => $request->input('password')])) {
//            return redirect()->intended('/home');
//
//        } elseif (Auth::guard('enrollees_guard')->attempt($credentials, $request->filled('remember'))) {
//
//            return redirect()->intended('/home');
//        } else {
//
//            return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput();
//        }



//        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
//
//            return redirect()->intended(route('home'));
//
//        }elseif (Auth::guard('enrollees_guard')->attempt($credentials, $request->filled('remember'))) {
//
//            if (auth()->guard('enrollees_guard')->check()) {
//                // User is authenticated
//
//                return redirect()->intended(route('enrollees_home'));
//            }
//        }
//        else {
//
//            return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput();
//        }

        if($request->input('login_type') === 'STUDENT')
        {
            if (Auth::guard('web')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $request->filled('remember'))) {

                if(Auth::user()->active)
                {
                    return redirect()->intended(route('home'));
                }else
                {
                    return redirect()->back()->with('message', 'This account has been deactivated!')->withInput([
                        'login_type' => $request->input('login_type'),
                        'email' => $request->input('email')
                    ]);
                }
            }
            else
            {
                return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput([
                    'login_type' => $request->input('login_type'),
                    'email' => $request->input('email')
                ]);
            }

        }
        elseif ($request->input('login_type') === 'GUEST')
        {
            if (Auth::guard('enrollees_guard')->attempt($credentials, $request->filled('remember'))) {

                if (auth()->guard('enrollees_guard')->check()) {
                    // User is authenticated

                    if(auth()->guard('enrollees_guard')->user()->active)
                    {
                        return redirect()->intended(route('enrollees_home'));
                    }else
                    {
                        return redirect()->back()->with('message', 'This account has been deactivated!')->withInput([
                            'login_type' => $request->input('login_type'),
                            'email' => $request->input('email')
                        ]);
                    }

                }else
                {
                    return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput([
                        'login_type' => $request->input('login_type'),
                        'email' => $request->input('email')
                    ]);
                }
            }else
            {
                return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput([
                    'login_type' => $request->input('login_type'),
                    'email' => $request->input('email')
                ]);
            }
        }
        elseif ($request->input('login_type') === 'EMPLOYEE')
        {
            if (Auth::guard('employee_guard')->attempt(['username' => $request->input('email'), 'password' => $request->input('password')], $request->filled('remember'))) {

                if (auth()->guard('employee_guard')->check()) {
                    // EMPLOYEE is authenticated

                    if(auth()->guard('employee_guard')->user()->active)
                    {
                        return redirect()->intended(route('enrollees_dashboard'));
                    }else
                    {
                        return redirect()->back()->with('message', 'This account has been deactivated!')->withInput([
                            'login_type' => $request->input('login_type'),
                            'email' => $request->input('email')
                        ]);
                    }

                }else
                {
                    return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput([
                        'login_type' => $request->input('login_type'),
                        'email' => $request->input('email')
                    ]);
                }
            }else
            {
                return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput([
                    'login_type' => $request->input('login_type'),
                    'email' => $request->input('email')
                ]);
            }
        }else
        {
            return redirect()->back()->with('message', 'Incorrect Username or Password')->withInput([
                'login_type' => $request->input('login_type'),
                'email' => $request->input('email')
            ]);
        }

    }

    public function admin_manage_check_account_notif(Request $request){
        $data = $request->all();

        __notification_set(-1,'Notice','You dont have privilege to access this operation, Contact System Administrator.');

        return json_encode(array(
            "data"=>$data,
        ));
    }



    public function find_account_now(Request $request)
    {
        Session::forget(['full_name', 'student_info', 'students_email', 'students_full_name', 'students', 'student_id']);

        $student_id_email = trim($request->student_id_email);

        $check_account = student::where('studid', $student_id_email)->orWhere('studemail', $student_id_email)->first();
        $check_account_from_mySQL = User::where('studid', $student_id_email)->orWhere('email', $student_id_email)->first();

        if($check_account_from_mySQL)
        {
            $student_id = trim($check_account_from_mySQL->studid);
            $full_name = $check_account_from_mySQL->fullname;

            if($check_account_from_mySQL->email)
            {
                $has_email = true;
            }else
            {
                $has_email = false;

            }

            return redirect()->back()->with('success', 'These accounts matched your search.')->with('student_id', $student_id)->with('full_name', $full_name)->with('student_info', $check_account)->with('has_email', $has_email)->withInput();

        }
        else if($check_account)
        {
            // Convert the FIRSTNAME binary data to a readable string
            $hexString_firstname = bin2hex($check_account->studfirstname);
            $binaryData_firstname = hex2bin($hexString_firstname);
            $readableString_firstname = utf8_encode($binaryData_firstname);


            // Convert the LASTNAME binary data to a readable string
            $hexString_lastname = bin2hex($check_account->studlastname);
            $binaryData_lastname = hex2bin($hexString_lastname);
            $readableString_lastname = utf8_encode($binaryData_lastname);


            $full_name = $readableString_lastname.', '.$readableString_firstname;
            $student_id = trim($check_account->studid);
            $contact = $check_account->studcontactno;

            Session::put('students_email', trim($check_account->studemail));
            Session::put('students_full_name', $full_name);
            Session::put('students', $check_account);
            Session::put('student_id', $student_id);


            User::updateOrCreate(
                [
                    'studid'  => $student_id,
                ],

                [
                    'studid'  => $student_id,
                    'password'  => $student_id,
                    'fullname'  => $full_name,
                    'contact'  => $contact,
                ]
            );

            if($check_account->studemail)
            {
                $has_email = true;
            }else
            {
                $has_email = false;

            }


            $currentDateTime = Carbon::now();
            $attempt_count = 0;


            $GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER = GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER(); // GET SYSTEM DEFAULT VERIFIER
            $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT = GLOBAL_STUDENTS_ATTEMPT_ACCOUNT(); // GET DEFAULT COUNT ATTEMPTS

            if($GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER === '1') // ACTIVE ATTEMPT VERIFIER
            {

                $check_attempts = User::where('studid', $student_id)->first();

                $email_verification_attempts = $check_attempts->email_verification_attempts;

                if ($email_verification_attempts > $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT)
                {
                    $attemptedAt = Carbon::parse($check_account_from_mySQL->attempted_at);
//                        $hoursDifference = $attemptedAt->diffInSeconds($currentDateTime);
                    $hoursDifference = $attemptedAt->diffInHours($currentDateTime);


                    // Check if the difference is greater than 24 hours
                    if ($hoursDifference > 24) {

                        // The attempted_at is more than 24 hours ago
                        // The Attempts was refreshed!

                        User::where('studid', $student_id)->update([

                            'email_verification_attempts' => $attempt_count,
                            'attempted_at' => null,

                        ]);
                        return redirect()->back()->with('success', 'These accounts matched your search.')->with('student_id', $student_id)->with('full_name', $full_name)->with('student_info', $check_account)->with('has_email', $has_email)->withInput();


                    } else {
                        // The attempted_at is within the last 24 hours
                        return redirect()->back()->with('error', 'Maximum Attempt Limit Reached! Retry after 24 hours')->withInput();
                    }
                }else
                {
                    return redirect()->back()->with('success', 'These accounts matched your search.')->with('full_name', $full_name)->with('student_info', $check_account)->with('has_email', $has_email)->withInput();

                }

            }
            else
            {
                return redirect()->back()->with('success', 'These accounts matched your search.')->with('full_name', $full_name)->with('student_info', $check_account)->with('has_email', $has_email)->withInput();

            }

        }
        else
        {
            return redirect()->back()->with('error', 'Nothing Found, Please Contact Admission Office!')->with('student_id', $student_id_email)->withInput();
        }
//        if($check_account)
//        {
//
//            // Convert the FIRSTNAME binary data to a readable string
//            $hexString_firstname = bin2hex($check_account->studfirstname);
//            $binaryData_firstname = hex2bin($hexString_firstname);
//            $readableString_firstname = utf8_encode($binaryData_firstname);
//
//
//            // Convert the LASTNAME binary data to a readable string
//            $hexString_lastname = bin2hex($check_account->studlastname);
//            $binaryData_lastname = hex2bin($hexString_lastname);
//            $readableString_lastname = utf8_encode($binaryData_lastname);
//
//
//            $full_name = $readableString_lastname.', '.$readableString_firstname;
//            $student_id = $check_account->studid;
//
//            Session::put('students_email', trim($check_account->studemail));
//            Session::put('students_full_name', $full_name);
//            Session::put('students', $check_account);
//            Session::put('student_id', $student_id);
//
//
//            User::updateOrCreate(
//                [
//                    'studid'  => $student_id,
//                ],
//
//                [
//                    'studid'  => $student_id,
//                    'password'  => $student_id,
//                    'fullname'  => $full_name,
//                ]
//            );
//
//            if($check_account->studemail)
//            {
//                $has_email = true;
//            }else
//            {
//                $has_email = false;
//
//            }
//
//
//            $currentDateTime = Carbon::now();
//            $attempt_count = 0;
//
//
//            $GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER = GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER(); // GET SYSTEM DEFAULT VERIFIER
//            $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT = GLOBAL_STUDENTS_ATTEMPT_ACCOUNT(); // GET DEFAULT COUNT ATTEMPTS
//
//            if($GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER === '1') // ACTIVE ATTEMPT VERIFIER
//            {
//
//                if($check_account_from_mySQL) {
//                    $email_verification_attempts = $check_account_from_mySQL->email_verification_attempts;
//
//                    if ($email_verification_attempts > $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT)
//                    {
//                        $attemptedAt = Carbon::parse($check_account_from_mySQL->attempted_at);
////                        $hoursDifference = $attemptedAt->diffInSeconds($currentDateTime);
//                        $hoursDifference = $attemptedAt->diffInHours($currentDateTime);
//
//
//                        // Check if the difference is greater than 24 hours
//                        if ($hoursDifference > 24) {
//
//                            // The attempted_at is more than 24 hours ago
//                            // The Attempts was refreshed!
//
//                            User::where('studid', $student_id)->update([
//
//                                'email_verification_attempts' => $attempt_count,
//                                'attempted_at' => null,
//
//                            ]);
//                            return redirect()->back()->with('success', 'These accounts matched your search.')->with('student_id', $student_id)->with('full_name', $full_name)->with('student_info', $check_account)->with('has_email', $has_email)->withInput();
//
//
//                        } else {
//                            // The attempted_at is within the last 24 hours
//                            return redirect()->back()->with('error', 'Maximum Attempt Limit Reached! Retry after 24 hours')->withInput();
//                        }
//                    }else
//                    {
//                        return redirect()->back()->with('success', 'These accounts matched your search.')->with('full_name', $full_name)->with('student_info', $check_account)->with('has_email', $has_email)->withInput();
//
//                    }
//                }
//
//            }
//            else
//            {
//                return redirect()->back()->with('success', 'These accounts matched your search.')->with('full_name', $full_name)->with('student_info', $check_account)->with('has_email', $has_email)->withInput();
//
//            }
////            return redirect()->back()->with('success', 'These accounts matched your search.')->with('full_name', $full_name)->with('student_info', $check_account)->with('has_email', $has_email)->withInput();
//
//
//        }else
//        {
//            return redirect()->back()->with('error', 'Your search did not return any results. Please try again with other information.')->withInput();
//        }

    }

    public function find_my_birthDate(Request $request)
    {
        $student_id = trim($request->student_id);
        $student_bDate = trim($request->birtDate);
        $attempt_counter = trim($request->attempt_count);
        $email_input_field = '';
        $has_valid_birthDate = false;
        $modal_footer = '';
        $students_id = '';
        $now = Carbon::now();
        $email_verification_attempted_at = $now->format('Y-m-d H:i:s');

        $check_account = student::where('studid', $student_id)->where('studbirthdate', $student_bDate)->first();
        $check_attempts = User::where('studid', $student_id)->first();

//        if($attempt_counter == 0)
//        {
//            $counts = 1;
//        }else
//        {
//            $counts = $attempt_counter;
//        }
//        if($check_account)
//        {
//
//            $students_id = $check_account->studid;
//            $has_valid_birthDate = true;
//            $attempt_count = 0;
//            $email_input_field = '
//
//                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Your Email <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please provide an ACTIVE EMAIL</span> </label>
//                        <div class="input-group mt-2">
//                            <div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="mail" data-lucide="mail" class="lucide lucide-mail w-4 h-4"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></div>
//                            <input type="email" id="my_email" class="form-control pl-12 my_email" placeholder="juandelacruz@gmail.com">
//
//                        </div>';
//
//            $modal_footer = '
//                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
//                <button class="btn btn-primary mr-1 mb-2 btn_update_send_email"> Send</button>
//            ';
//
//            User::where('studid', $student_id)->update([
//
//                'email_verification_attempts' => $attempt_count,
//                'attempted_at' => $email_verification_attempted_at,
//
//            ]);
//
//        }
//        else
//        {
//            $has_valid_birthDate = false;
//            $attempt_count = $check_attempts->email_verification_attempts;
//
//            User::where('studid', $student_id)->update([
//
//                'email_verification_attempts' => $counts,
//                'attempted_at' => $email_verification_attempted_at,
//
//            ]);
//        }

        $GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER = GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER(); // GET SYSTEM DEFAULT VERIFIER
        $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT = GLOBAL_STUDENTS_ATTEMPT_ACCOUNT(); // GET DEFAULT COUNT ATTEMPTS


        if($GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER === '1')
        {
            if($check_account)
            {
                $students_id = $check_account->studid;
                $has_valid_birthDate = true;
                $attempt_count = 0;
                $email_input_field = '

                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Your Valid Email <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, email address format</span> </label>
                        <div class="input-group mt-2">
                            <div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="mail" data-lucide="mail" class="lucide lucide-mail w-4 h-4"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></div>
                            <input type="email" id="my_email" class="form-control pl-12 my_email" placeholder="juandelacruz@gmail.com">

                        </div>';

                $modal_footer = '
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button class="btn btn-primary mr-1 mb-2 btn_update_send_email"> Send</button>
            ';

                User::where('studid', $student_id)->update([

                    'email_verification_attempts' => $attempt_count,
                    'attempted_at' => $email_verification_attempted_at,

                ]);

                return json_encode(array(

                    'has_valid_birthDate' => $has_valid_birthDate,
                    'attempt_counter' => $attempt_count,
                    'global_total_attempt_count' => $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT,
                    'email_input_html' => $email_input_field,
                    'modal_footer' => $modal_footer,
                    'students_id' => $students_id,
                    'status' => 'success',
                    'is_attempts_activated' => true,

                ), JSON_THROW_ON_ERROR);

            }
            else
            {

                User::where('studid', $student_id)->update([

                    'email_verification_attempts' => $attempt_counter,
                    'attempted_at' => $email_verification_attempted_at,

                ]);

                return json_encode(array(

                    'has_valid_birthDate' => $has_valid_birthDate,
                    'attempt_counter' => $attempt_counter,
                    'global_total_attempt_count' => $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT,
                    'email_input_html' => $email_input_field,
                    'modal_footer' => $modal_footer,
                    'students_id' => $students_id,
                    'status' => 'warning',
                    'is_attempts_activated' => true,

                ), JSON_THROW_ON_ERROR);
            }

        }
        else
        {
            if($check_account)
            {
                $students_id = $check_account->studid;
                $has_valid_birthDate = true;
                $attempt_count = 0;
                $email_input_field = '

                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Your Email <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please provide an ACTIVE EMAIL</span> </label>
                        <div class="input-group mt-2">
                            <div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="mail" data-lucide="mail" class="lucide lucide-mail w-4 h-4"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></div>
                            <input type="email" id="my_email" class="form-control pl-12 my_email" placeholder="juandelacruz@gmail.com">

                        </div>';

                $modal_footer = '
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button class="btn btn-primary mr-1 mb-2 btn_update_send_email"> Send</button>
            ';

                User::where('studid', $student_id)->update([

                    'email_verification_attempts' => $attempt_count,
                    'attempted_at' => $email_verification_attempted_at,

                ]);

                return json_encode(array(

                    'has_valid_birthDate' => $has_valid_birthDate,
                    'attempt_counter' => $attempt_count,
                    'email_input_html' => $email_input_field,
                    'modal_footer' => $modal_footer,
                    'students_id' => $students_id,
                    'status' => 'success',
                    'is_attempts_activated' => false,

                ), JSON_THROW_ON_ERROR);

            }else
            {
                $has_valid_birthDate = false;
                return json_encode(array(

                    'has_valid_birthDate' => $has_valid_birthDate,
                    'email_input_html' => $email_input_field,
                    'modal_footer' => $modal_footer,
                    'students_id' => $students_id,
                    'status' => 'warning',
                    'is_attempts_activated' => false,

                ), JSON_THROW_ON_ERROR);
            }
        }
//        if($check_account)
//        {
//
//            $students_id = $check_account->studid;
//            $has_valid_birthDate = true;
//            $attempt_count = 0;
//            $email_input_field = '
//
//                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Your Email <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please provide an ACTIVE EMAIL</span> </label>
//                        <div class="input-group mt-2">
//                            <div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="mail" data-lucide="mail" class="lucide lucide-mail w-4 h-4"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></div>
//                            <input type="email" id="my_email" class="form-control pl-12 my_email" placeholder="juandelacruz@gmail.com">
//
//                        </div>';
//
//            $modal_footer = '
//                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
//                <button class="btn btn-primary mr-1 mb-2 btn_update_send_email"> Send</button>
//            ';
//
//            User::where('studid', $student_id)->update([
//
//                'email_verification_attempts' => $attempt_count,
//                'attempted_at' => $email_verification_attempted_at,
//
//            ]);
//
//            return json_encode(array(
//
//                'has_valid_birthDate' => $has_valid_birthDate,
//                'attempt_counter' => $attempt_count,
//                'email_input_html' => $email_input_field,
//                'modal_footer' => $modal_footer,
//                'students_id' => $students_id,
//                'status' => 'success',
//
//            ), JSON_THROW_ON_ERROR);
//
//        }else
//        {
//            return json_encode(array(
//
//                'has_valid_birthDate' => $has_valid_birthDate,
//                'attempt_counter' => $attempt_count,
//                'email_input_html' => $email_input_field,
//                'modal_footer' => $modal_footer,
//                'students_id' => $students_id,
//                'status' => 'error',
//
//            ), JSON_THROW_ON_ERROR);
//        }

//        return json_encode(array(
//
//            'has_valid_birthDate' => $has_valid_birthDate,
//            'attempt_counter' => $attempt_count,
//            'email_input_html' => $email_input_field,
//            'modal_footer' => $modal_footer,
//            'students_id' => $students_id,
//
//        ), JSON_THROW_ON_ERROR);

    }
    public function getMyAttempts(Request $request)
    {
        $student_id = trim($request->student_id);

        $Student_data = User::where('studid', $student_id)->first();

        $total_attempts = $Student_data->email_verification_attempts;

        $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT = GLOBAL_STUDENTS_ATTEMPT_ACCOUNT();

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => -1,
            'message' => 'Email Verification Sent Successfully!',
            'attempts' => $total_attempts,
            'global_attempts' => $GLOBAL_STUDENTS_ATTEMPT_ACCOUNT,
        ), JSON_THROW_ON_ERROR);
    }

    public function sendEmailVerification(Request $request)
    {
        $email_to = trim($request->email);
        $students_id = trim($request->students_id);

        $is_email_exist = User::where('email', $email_to)->first();

        if ($is_email_exist)
        {
            return json_encode(array(

                'status' => 'warning',
                'title' => 'Email Exist!',
                'status_code' => -1,
                'message' => 'Email provided already exist!',
            ), JSON_THROW_ON_ERROR);

        }else
        {
            $email_title = 'Email Verification';
            $message = 'Please click the button below to verify your email address.';
            $closing = 'If you did not create an account, no further action is required.';

            $closing_2 = 'Regards,';

            $username = $email_to;
            $encrypted_students_id = \Crypt::encrypt($students_id);
            $password = \Crypt::encrypt($students_id); //STUDENTS ID IS THE DEFAULT PASSWORD! NOTE: PASSWORD HAS BEEN ENCRYPTED!

            Mail::to($email_to)->send(new StudentsEmailVerification($email_title,$message, $closing, $closing_2, $encrypted_students_id , $username, $password));

            User::where('studid', $students_id)->update([

                'email' => $email_to,

            ]);

            return json_encode(array(

                'status' => 'success',
                'title' => 'Success!',
                'status_code' => 1,
                'message' => 'Email Verification Sent Successfully!',
            ), JSON_THROW_ON_ERROR);
        }


    }

    public function verifyMyEmailAddress($username, $students_id, $password)
    {
        $decrypted_student_id = \Crypt::decrypt($students_id);
        $decrypted_password = \Crypt::decrypt($password);

        $now = Carbon::now();
        $email_verified_at = $now->format('Y-m-d H:i:s');

        User::where('studid', $decrypted_student_id)->update([

            'email' => $username,
            'email_verified' => 1,
            'email_verified_at' => $email_verified_at,

        ]);


        if (Auth::guard('web')->attempt(['email' => $username, 'password' => $decrypted_password]))
        {
            return redirect()->intended(route('home'));
        }else
        {
            return redirect()->intended(route('login'));
        }

    }


    /* BIO LOGIN START */

    public function DB_SCHEMA() {

        return "primehrmo.";

    }

    public function DBTBL_USER() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "admin_user",
        ];
        return $result;
    }

    public function getUserData($user, $field) {
        $result = "";
        /***/
        $DBDRIVER = $this->DBTBL_USER()['driver'];
        $DBTBL = $this->DBTBL_USER()['table'];
        /***/
        $qry = " SELECT * FROM " . $DBTBL . "  WHERE active='1' AND ( TRIM(LOWER(employee))=TRIM(LOWER('" . $user . "')) ) LIMIT 1 ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $result = ($cd->$field);
            }
        }
        /***/
        return $result;
    }

    public function bioLogin(Request $request)
    {

        $result = [];

        $res_code = 0;
        $res_msg = 'Error';
        $res_data = [];

        $loguser = trim($request->username);
        $logpass = $this->getUserData($loguser,"password");
        $loguser2 = $this->getUserData($loguser,"username");


        $credentials = [
            'username' => $loguser2,
            'password' => $logpass,
        ];

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();

            $res_code = 1;
            $res_msg = 'Login successful.';

            $lastname = $this->getUserData($loguser,"lastname");
            $firstname = $this->getUserData($loguser,"firstname");
            $middlename = $this->getUserData($loguser,"middlename");
            $fullname = trim($firstname) . " " . trim($middlename) . " " . trim($lastname);
            $fullname = trim(strtolower($fullname));

            $res_data = [
                "name" => $fullname,
            ];

            $getModule = system_modules::where('active',1)->where('important',1)->get();

            foreach ($getModule as $module) {
                $getUserpriv = user_privilege::where('active',1)->where('user_id',Auth::user()->employee)->where('module_id',$module->id)->first();
                if(!$getUserpriv){
                    $add_priv = [
                        'module_id' =>  $module->id,
                        'user_id' =>  Auth::user()->employee
                    ];
                    $user_priv_id = user_privilege::create($add_priv)->id;
                }
            }
            //dd($getModule);

            $active_date = '';
            $expire_date = '';
            $go_no_go = '';
            $load_account = User::where('id', Auth::user()->id)->first();

            $date_today = date('Y-m-d');
            $date_today=date('Y-m-d', strtotime($date_today));


            if($load_account->active_date){
                $active_date =  date('Y-m-d', strtotime($load_account->active_date));

            }
            if($load_account->expire_date){
                $expire_date = date('Y-m-d', strtotime($load_account->expire_date));

            }

            if($active_date && $expire_date){
                if (($date_today >= $active_date) && ($date_today <= $expire_date)){
                    $go_no_go = 'Active';


                }else{
                    Auth::logout();
                    $go_no_go = 'No Go!';
                    /***/
                    $res_code = -1;
                    $res_msg = 'Incorrect username or password.';
                    $res_data = [];
                    /***/
                }
            }else if(!$active_date && $expire_date){

                if($date_today <= $expire_date){
                    $go_no_go = 'Active';


                }else{
                    Auth::logout();
                    $go_no_go = 'No Go!';
                    /***/
                    $res_code = -1;
                    $res_msg = 'Incorrect username or password.';
                    $res_data = [];
                    /***/
                }

            }else if($active_date && !$expire_date){
                if($date_today >= $active_date){

                    $go_no_go = 'Active';

                }else{
                    Auth::logout();
                    $go_no_go = 'No Go!';
                    /***/
                    $res_code = -1;
                    $res_msg = 'Incorrect username or password.';
                    $res_data = [];
                    /***/
                }

            }else{

                $go_no_go = 'Infinite';

            }

        }else{
            $res_code = -1;
            $res_msg = 'Incorrect username or password.';
        }

        $result = [
            "code" => $res_code,
            "message" => $res_msg,
            "data" => $res_data,
        ];

        return $result;

    }

    /* BIO LOGIN END */

    public function logout(){

//        Auth::user()->studid = null;
        Auth::logout();

        return redirect('/login');

    }

}
