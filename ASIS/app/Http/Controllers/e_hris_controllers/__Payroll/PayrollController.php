<?php

namespace App\Http\Controllers\e_hris_controllers\__Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    //Payroll Management
    public function payroll_mng(){

        return view('payroll__.manage_payroll');
    }

    public function payroll_set(){

        return view('payroll__.set_payroll');
    }
}
