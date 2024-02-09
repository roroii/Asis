<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll\Contribution;

class ContributionController extends Controller
{
    //
    public function index(){
        return view('payroll.contribution');
    }

    public function assignment(){
        return view('payroll.assignment.contribution');
    }
}
