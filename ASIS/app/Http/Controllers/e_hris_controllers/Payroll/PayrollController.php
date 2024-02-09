<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payroll\Incentive_Emp;
use App\Models\Payroll\LoanAssignment;
use App\Models\Payroll\Payroll_Emp;
use App\Models\Payroll\PayrollDetails_Deduction;
use App\Models\Payroll\PayrollDetails_Incentive;
use App\Models\Payroll\PayrollDetails_Loan;
use App\Models\Payroll\PayrollDetails_Tax;
use App\Models\Payroll\Salary;
use Illuminate\Http\Request;
use App\Models\Payroll\Payroll;
use App\Models\agency\agency_employees;
use App\Models\Payroll\PayrollDetails_Salary;
use Illuminate\Support\Facades\Auth;
use App\Models\Payroll\Deduction;

class PayrollController extends Controller
{
    public function index(){
        return view('payroll.payroll')->with('get');
    }
    public function createpayroll(){
        return view('payroll.create');
    }

    public function savepayroll(Request $request){
        $payroll_id = Payroll::create([
            'group_name'=>$request->group_name,
            'date_desc'=>$request->date_desc,
            'date_month'=>$request->date_month,
            'date_year'=>$request->date_year,
            'date_from'=>$request->date_from,
            'date_to'=>$request->date_to,
            'processed_by'=>Auth::user()->id,
        ])->id;

        return $payroll_id;
    }

    public function savepayrolldetails(Request $request){
        PayrollDetails_Salary::create([
            'payroll_id'=>$request->payroll_id,
            'employee_id'=>$request->employee_id,
            'salary'=>$request->salary,
            'net_salary'=>$request->net_salary,
        ]);

        $incentive_assigned = Incentive_Emp::with('get_incentive')->where('active',1)->where('employee_id',$request->employee_id)->get();
        foreach ($incentive_assigned as $ia) {
            PayrollDetails_Incentive::create([
                'incentive_id'=>$ia->get_incentive->id,
                'employee_id'=>$request->employee_id,
                'payroll_id'=>$request->payroll_id,
                'amount'=>$ia->amount
            ]);
        }

        $deduction_assigned = Deduction::with('get_contribution')->where('active',1)->where('employee_id',$request->employee_id)->get();
        foreach ($deduction_assigned as $da) {
            PayrollDetails_Deduction::create([
                'deduction_id'=>$da->get_contribution->id,
                'employee_id'=>$request->employee_id,
                'payroll_id'=>$request->payroll_id,
                'amount'=>$da->amount
            ]);
        }

        $loan_assigned = LoanAssignment::with('get_loan')->where('active',1)->where('employee_id',$request->employee_id)->get();
        foreach ($loan_assigned as $da) {
            PayrollDetails_Loan::create([
                'loan_id'=>$da->get_loan->id,
                'employee_id'=>$request->employee_id,
                'payroll_id'=>$request->payroll_id,
                'amount'=>$da->amount
            ]);
        }

        return response()->json(['success' => 'SAVED']);
    }

    public function savepayrolltax(Request $request){
        PayrollDetails_Tax::create([
            'payroll_id'=>$request->payroll_id,
            'employee_id'=>$request->employee_id,
            'tax'=>$request->tax,
        ]);

        return response()->json(['success' => 'SAVED']);
    }

    public function getsalary(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';



        $employee = agency_employees::with('get_user_profile','get_salary','get_deduction.get_contribution','get_loan','get_incentive')->where(['active'=>1,'agency_id'=>$request->agency_id])->get();
        foreach ($employee as $dt) {

            $salary=0;
            $deduction=0;
            $ded=0;
            $loa=0;
            $loan=0;
            $inc=0;
            $incentive=0;
            $classification = '';



            foreach ($dt->get_incentive as $i){
                if($i->active==1){
                    $inc+=$i->amount;
                }
                $incentive= number_format($inc, 2);
            }

            foreach ($dt->get_deduction as $d){
                if($d->active==1){
                    $ded+=$d->amount;
                }
                $deduction= number_format($ded, 2);
            }

            foreach ($dt->get_loan as $d){
                if($d->active==1){
                    $loa+=$d->amount;
                }
                $loan= number_format($loa, 2);
            }



            if($dt->get_salary){
                $sal=$dt->get_salary->salary;
                $salary= number_format($sal, 2);
                $classification = $dt->get_salary->classification;
            }

            if($dt->get_user_profile){
                $td = [
                    "id" => $dt->id,
                    "name"=>$dt->get_user_profile->lastname.', '.$dt->get_user_profile->firstname.' '.$dt->get_user_profile->mi.' '.$dt->get_user_profile->extension,
                    "salary" => $salary,
                    "deduction"=>$deduction,
                    "loan"=>$loan,
                    "incentive"=>$incentive,
                    "agencyid"=>$dt->agency_id,
                    "classification"=>$classification
                ];
                $tres[count($tres)] = $td;
            }

        }

        echo json_encode($tres);
    }

    public function getsalary_hourly(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';



        $rate = Salary::where(['classification'=>2,'agency_id'=>$request->id])->first();
        echo json_encode($rate);
    }

    public function loadpayroll(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $payroll = Payroll::with('employee')->get();
        foreach ($payroll as $dt) {
            $td = [
                "id" => $dt->id,
                "group_name" => $dt->group_name,
                "date_desc"=> $dt->date_desc,
                "date_month"=> $dt->date_month,
                "date_year"=>$dt->date_year,
                "employee"=>$dt->employee->count(),
                "processed_by"=>getProfile($dt->processed_by)->firstname,
                "status"=>$dt->status
            ];
            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }

    public function loadpayrollemp (Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $employee = Payroll_Emp::where('payroll_id',1)->get();
        foreach ($employee as $dt) {

            $td = [
                "id" => $dt->id,
                "name" => $dt->user_id,
                "salary"=> $dt->payroll_id,
            ];
            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }

    public function loadpayrollemp_select (Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $employee = agency_employees::with('get_user_profile')->where('active',1)->get();
        foreach ($employee as $dt) {

//            $name=
//            if($dt->mi!='' and $dt->extension!=''){
//
//            }else if($dt->mi){
//                $name=getProfile($dt->user_id)->lastname.', '.getProfile($dt->user_id)->firstname.' '.getProfile($dt->user_id)->mi;
//            }else if($dt->extension){
//                $name=getProfile($dt->user_id)->lastname.', '.getProfile($dt->user_id)->firstname.' '.getProfile($dt->user_id)->extension;
//            }else{
//                $name=getProfile($dt->user_id)->lastname.', '.getProfile($dt->user_id)->firstname;
//            }

            if($dt->get_user_profile){
                $td = [
                    "user_id" => $dt->agency_id,
                    "name"=>$dt->get_user_profile->lastname.', '.$dt->get_user_profile->firstname.' '.$dt->get_user_profile->mi.' '.$dt->get_user_profile->extension
                ];
                $tres[count($tres)] = $td;
            }
        }

        echo json_encode($tres);
    }
}
