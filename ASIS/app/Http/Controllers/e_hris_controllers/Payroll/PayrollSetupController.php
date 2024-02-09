<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\agency\agency_employees;
use App\Models\Payroll\Contribution_Emp;
use App\Models\Payroll\Rates;
use App\Models\Payroll\Salary;
use App\Models\Payroll\SG_Step;
use App\Models\tblemployee;
use Illuminate\Http\Request;
use App\Models\Payroll\LoanAssignment;
use App\Models\Payroll\Loan;
use App\Models\Payroll\Incentive_Emp;
use App\Models\Payroll\Incentive;
use App\Models\Payroll\Deduction_Emp;
use App\Models\Payroll\Deduction;


class PayrollSetupController extends Controller
{
    //
    public function index(){

        return view('payroll.setup');

    }

    public function loadsetup(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';
        $loan = '';
        $late = '';


        $employee = agency_employees::with('get_user_profile','get_salary','get_contribution.get_contribution','get_incentive','get_deduction.deduction_details')->where('active',1)->get();
        foreach ($employee as $dt) {

            $salary='';
            $contribution=0;
            $con=0;
            $inc=0;
            $incentive=0;
            $ded=0;
            $deduction=0;



            foreach ($dt->get_incentive as $i){
                if($i->active==1){
                    $inc+=$i->amount;
                }
                $incentive= number_format($inc, 2);
            }

            foreach ($dt->get_contribution as $d){
                if($d->active==1){
                    $con+=$d->amount;
                }
                $contribution= number_format($con, 2);
            }


            foreach ($dt->get_deduction as $d){
                if($d->deduction_details){
                    $ded+=$d->deduction_details->amount;
                }
                $deduction= number_format($ded, 2);
            }




            if ($incentive==0 or $incentive==0.00){
                $incentive= '<div class="justify-left items-left float-right">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Add">
                    <a class="flex justify-center items-center openincentive" data-id="'.$dt->agency_id.'" href="javascript:;" aria-expanded="false" data-tw-toggle="modal" data-tw-target="#set_incentive"> <i class="fa fa-plus items-center text-center text-primary"></i> </a>
                    </div>
                    </div>';
            }else{
                $incentive= '<a href="javascript:;" class="underline decoration-dotted whitespace-nowrap openedit_inc" data-tw-toggle="modal" data-tw-target="#set_incentive" data-id="'.$dt->agency_id.'">'.$incentive.'</a>';
            }




            if ($contribution==0 or $contribution==0.00){
                $contribution= '<div class="justify-left items-left float-right">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Add">
                    <a id="add_salary_modal" class="flex justify-center items-center opencontribution" data-id="' .$dt->agency_id.'" href="javascript:;" aria-expanded="false" data-tw-toggle="modal" data-tw-target="#set_contribution"> <i class="fa fa-plus items-center text-center text-primary"></i> </a>
                    </div>
                    </div>';
            }else{
                $contribution= '<a href="javascript:;" class="underline decoration-dotted whitespace-nowrap openedit_con" data-tw-toggle="modal" data-tw-target="#set_contribution" data-id="'.$dt->agency_id.'">'.$contribution.'</a>';
            }


            if ($deduction==0 or $deduction==0.00){
                $deduction= '<div class="justify-left items-left float-right">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Add">
                    <a id="add_salary_modal" class="flex justify-center items-center addnewdeduction" data-id="' .$dt->agency_id.'" href="javascript:;" aria-expanded="false" data-tw-toggle="modal" data-tw-target="#set_deduction"> <i class="fa fa-plus items-center text-center text-primary"></i> </a>
                    </div>
                    </div>';
            }else{
                $deduction= '<a href="javascript:;" class="underline decoration-dotted whitespace-nowrap openedit_ded" data-tw-toggle="modal" data-tw-target="#set_deduction" data-id="'.$dt->agency_id.'">'.$deduction.'</a>/min';
            }


            if($dt->get_salary){
                $sal=$dt->get_salary->salary;
                $salary= number_format($sal, 2);
                $salary='<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#set_salary" data-sal_id="'.$dt->get_salary->id.'" data-emp_id="'.$dt->agency_id.'" class="underline decoration-dotted whitespace-nowrap editsalary">'.$salary.'</a>';
            }else{
                $salary= '<div class="justify-left items-left float-right">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Add">
                    <a id="add_salary_modal" class="flex justify-center items-center addnewsalary" data-id="'.$dt->agency_id.'" href="javascript:;" aria-expanded="false" data-tw-toggle="modal" data-tw-target="#set_salary"> <i class="fa fa-plus items-center text-center text-primary"></i> </a>
                    </div>
                    </div>';
            }

            if($dt->get_user_profile){
                $td = [
                    "id" => $dt->id,
                    "name"=>$dt->get_user_profile->lastname.', '.$dt->get_user_profile->firstname.' '.$dt->get_user_profile->mi.' '.$dt->get_user_profile->extension,
                    "salary" => $salary,
                    "contribution"=>$contribution,
                    "incentive"=>$incentive,
                    "deduction"=>$deduction
                ];
                $tres[count($tres)] = $td;
            }
        }

        echo json_encode($tres);
    }

    public function storesetup(Request $request){
        Salary::create([
            'classification'=>$request->choice,
            'sg'=>$request->sg,
            'step'=>$request->step,
            'salary'=>$request->amount,
            'agency_id'=>$request->id,
            'rate_id'=>$request->rate_id
        ]);
        return response()->json(['success' => 'SAVED']);
    }

    public function updatesetup(Request $request){

        Salary::where('agency_id',$request->id)->update([
            'classification'=>$request->choice,
            'sg'=>$request->sg,
            'step'=>$request->step,
            'salary'=>$request->amount,
            'agency_id'=>$request->id,
            'rate_id'=>$request->rate_id
        ]);
        return response()->json(['success' => 'SAVED']);
    }


    public function getsalary_sg(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $salary = SG_Step::where(['sg_id'=>$request->sg,'stepnum'=>$request->step])->first();

        echo json_encode($salary);
    }
    public function getrate_amount(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $rate = Rates::where(['id'=>$request->id])->first();

        echo json_encode($rate);
    }

    public function getdeduction(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $rate = Deduction_Emp::with('deduction_details')->where(['employee_id'=>$request->id])->first();

        echo json_encode($rate);
    }

    public function getdeduction_amount(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $rate = Deduction::where(['id'=>$request->id])->first();

        echo json_encode($rate);
    }

    public function loadsalary_toedit(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';


        $salary = Salary::where(['agency_id'=>$request->emp_id,'id'=>$request->sal_id])->first();

        echo json_encode($salary);
    }

    public function load_emp_incentive(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';



        $incentive = Incentive_Emp::with('get_incentive')->where('employee_id',$request->emp_id)->where('active',1)->get();
        foreach ($incentive as $dt) {
            $td = [
                "id" => $dt->id,
                "name"=>$dt->get_incentive->name,
                "amount" => '<input id="incentive_amount" type="text" class="form-control" value="'.$dt->amount.'">',
            ];
            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }
    public function load_emp_contribution(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';



        $deduction = Contribution_Emp::with('get_contribution')->where('employee_id',$request->emp_id)->where('active',1)->get();
        foreach ($deduction as $dt) {
                $td = [
                    "id" => $dt->id,
                    "name"=>$dt->get_contribution->name,
                    "amount" => '<input id="deduction_amount" type="text" class="form-control" value="'.$dt->amount.'">',
                ];
                $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }
    public function load_emp_loan(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';



        $loan = LoanAssignment::with('get_loan')->where('employee_id',$request->emp_id)->where('active',1)->get();
        foreach ($loan as $dt) {
            $td = [
                "id" => $dt->id,
                "name"=>$dt->get_loan->name,
                "amount" => '<input id="loan_amount" type="text" class="form-control" value="'.$dt->amount.'">',
            ];
            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }

    public function insert_emp_incentive(Request $request){
        $data = new Incentive_Emp();
        $data->incentive_id = $request->incentive_id;
        $data->amount = $request->amount;
        $data->employee_id=$request->employee_id;
        $data->save();

        return response()->json(['success' => 'SAVED']);
    }
    public function insert_emp_contribution(Request $request){
        $deduction = new Contribution_Emp();
        $deduction->contribution_id = $request->contribution_id;
        $deduction->amount = $request->amount;
        $deduction->employee_id=$request->employee_id;
        $deduction->save();

        return response()->json(['success' => 'SAVED']);
    }

    public function insert_emp_deduction(Request $request){
        $deduction = new Deduction_Emp();
        $deduction->deduction_id = $request->deduction_id;
        $deduction->employee_id=$request->employee_id;
        $deduction->save();

        return response()->json(['success' => 'SAVED']);
    }

    public function update_emp_deduction(Request $request){
        Deduction_Emp::where('employee_id',$request->employee_id)->update([
            'employee_id'=>$request->employee_id,
            'deduction_id'=>$request->deduction_id,
        ]);
        return response()->json(['success' => 'SAVED']);
    }

    public function insert_emp_loan(Request $request){
        $loan = new LoanAssignment();
        $loan->loan_id = $request->loan_id;
        $loan->amount = $request->amount;
        $loan->employee_id=$request->employee_id;
        $loan->save();
        return response()->json(['success' => 'SAVED']);
    }

    public function delete_emp_incentive(Request $request){
        Incentive_Emp::where('id',$request->id)->update([
            'active'=>'0',
        ]);
        return response()->json(['success' => 'SAVED']);
    }

    public function delete_emp_contribution(Request $request){
        Contribution_Emp::where('id',$request->id)->update([
            'active'=>'0',
        ]);
        return response()->json(['success' => 'SAVED']);
    }

    public function delete_emp_loan(Request $request){
        LoanAssignment::where('id',$request->id)->update([
            'active'=>'0',
        ]);
        return response()->json(['success' => 'SAVED']);
    }
}
