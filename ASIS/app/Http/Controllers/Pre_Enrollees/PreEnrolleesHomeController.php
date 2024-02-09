<?php

namespace App\Http\Controllers\Pre_Enrollees;

use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\enrollment\enrollment_settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreEnrolleesHomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('enrollees_auth');

    }

    public function index()
    {
        $isAccountVerified = GLOBAL_PRE_ENROLLEES_ACCOUNT_VERIFICATION();

        if(!$isAccountVerified)
        {
            $message = 'Please complete your personal information to proceed!';
        }else
        {
            $message = null;
        }

        return view('pre_enrollees.Dashboard', compact('isAccountVerified', 'message'));
    }
}
