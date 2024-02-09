<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\tblemployee;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Str;

class MyRegistrationController extends Controller
{


    public function index()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' =>  ['required', 'string', 'max:255'],
            'lastname' =>   ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'username' =>   ['required', 'string', 'email', 'max:255', 'unique:admin_user'],
            'password' =>   ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {

            return Redirect::to('/register')->withErrors($validator)->withInput();

        } else
        {

            $check_user_if_exist = employee::where('lastname', $request['lastname'])->where('firstname', $request['firstname'])->where('mi', $request['middlename'])->first();

            if($check_user_if_exist)
            {

                return redirect()->back()->with('message', 'User already exist!')->withInput();

            }else
            {

                $applicant_id = account_id_generator();

                $user = User::create([
                    'employee'  => $applicant_id,
                    'firstname' => $request['firstname'],
                    'middlename'=> $request['middlename'],
                    'lastname'  => $request['lastname'],
                    'username'  => $request['username'],
                    'password'  => $request['password'],
                ]);


                $insert_profile = [
                    'agencyid'  => $applicant_id,
                    'user_id'   => $user->id,
                    'firstname' => $request->firstname,
                    'lastname'  => $request->lastname,
                    'mi'        => $request->middlename,
                    'email'     => $request->username,
                    'active'    => true,
                ];
                $get_user_id = employee::create($insert_profile);

                DB::table('admin_user')->where('id', $user->id)->update([
                    'profile_id' => $get_user_id->id,
                ]);

                //Add Privilege for newly created users
                reloadAddUsers($user->employee);

                $this->guard()->login($user);

                return redirect('/home');
            }
        }
    }


    protected function guard()
    {
        return Auth::guard();
    }

}
