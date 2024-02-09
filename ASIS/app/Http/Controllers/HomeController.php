<?php

namespace App\Http\Controllers;

use App\Models\ASIS_Models\enrollment\enrollment_settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('asis_auth');
        //$this->middleware(['auth', 'single_session']);
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);
    }

    public function not_found()
    {
        return view('layouts.404');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check())
        {
            $studid = auth()->user()->studid;

            $enrollmentDetails = enrollment_settings::where('active', 1)
                ->whereIn('description', ['status', 'sem', 'year', 'warning_message', 'notification_header', 'link'])
                ->pluck('key_value', 'description');

            $enrollmentSettings = [
                'enrollmentStatus' => $enrollmentDetails['status'] ?? 0,
                'studid' => auth()->user()->studid,
                'semester' => $enrollmentDetails['sem'] ?? '',
                'academicYear' => $enrollmentDetails['year'] ?? '',
                'enrollmentWarningMessage' => $enrollmentDetails['warning_message'] ?? '',
                'notificationHeader' => $enrollmentDetails['notification_header'] ?? '',
                'link' => $enrollmentDetails['link'] ?? '',
            ];
        }else if (Auth::guard('enrollees_guard'))
        {
            $enrollmentSettings = '';

        }else if (Auth::guard('employee_guard'))
        {
            $enrollmentSettings = '';
        }else
        {
            $enrollmentSettings = '';
        }




        return view('admin.dashboard.home', compact('enrollmentSettings'));
    }
}
