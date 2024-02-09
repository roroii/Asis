<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\enrollment\enrollment_settings;
use App\Models\ASIS_Models\pre_enrollees\pre_enrollees;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname'     =>  ['required', 'string', 'max:255'],
            'lastname'      =>   ['required', 'string', 'max:255'],
            'middlename'    => ['required', 'string', 'max:255'],
//            'email'         =>   ['required', 'string', 'email', 'max:255'],
            'email'         =>   ['required', 'string', 'email', 'max:255', 'unique:portal.pre_enrollees'],
            'password'      =>   ['required', 'string', 'min:4', 'confirmed'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User|\Illuminate\Http\RedirectResponse
     */
    protected function create(array $data)
    {

        $enrollee_id = account_id_generator();
        $active_sem = enrollment_settings::where('description', 'sem')->where('active', 1)->first();
        $active_year = enrollment_settings::where('description', 'year')->where('active', 1)->first();

        return pre_enrollees::create([
            'pre_enrollee_id'   => $enrollee_id,
            'firstname'         => strtoupper($data['firstname']),
            'midname'           => strtoupper($data['middlename']),
            'lastname'          => strtoupper($data['lastname']),
            'email'             => $data['email'],
            'password'          => $data['password'],
            'sem'               => $active_sem->key_value,
            'year'              => $active_year->key_value,
            'account_status'    => 1,
            'active'            => 1,
        ]);

//        DB::table('admin_user')->where('id', $user->id)->update([
//            'profile_id' => $get_user_id->id,
//        ]);
//
//        //Add Privilege for newly created users
//        reloadAddUsers($user->employee);
//
//        $this->guard()->login($user);
//
//        return redirect('/home');
//        return redirect()->intended('/home');
    }
}
