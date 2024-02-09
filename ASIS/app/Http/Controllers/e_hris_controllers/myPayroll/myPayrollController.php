<?php

namespace App\Http\Controllers\myPayroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\agency\agency_employees;

class myPayrollController extends Controller
{
    public function myPayrollDetail(){
        return view('myPayroll.myPayroll_page');
    }
    public function _pera_others(){
        return view('myPayroll.PERA_Other_page');
    }
    public function my_deduction(){
        return view('myPayroll.myDeduction_page');
    }

    public function fetch_MyPayrollDetail(){
        
        $check_agency = agency_employees::where('user_id', auth()->user()->id)->where('active', 1)->first();
        $employment_type = $check_agency->employment_type;
        
    }
}
