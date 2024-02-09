<?php

namespace App\Http\Controllers\IDP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\agency\agency_employees;
use App\Models\tblemployee;
use App\Models\Hiring\tbl_position;
use App\Models\tbluserassignment;
use App\Models\tbl_responsibilitycenter;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

use App\Models\IDP\idp_created_by;
use App\Models\IDP\idp_target;
use App\Models\IDP\idp_acrtivity;
use App\Models\IDP\activity_plan;
use PDF;
use Carbon\Carbon;
use Svg\Tag\Rect;

class idp extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');

    }

    public function index(){
            return view('IDP.IDP');
    }

    public function save_idp(Request $request){
        // dd($request->all());

        $yearTo = '';

        if($request->to_year == 0 || $request->to_year == null){
            $yearTo = null;
        }else{
            $yearTo = $request->to_year;
        }

        // dd($yearTo);
        $saveCreated = ['emp_id' => auth()->user()->employee,
                        'position_id' => $request->my_position,
                        'sg_id' => $request->my_sg,
                        'year_n_position' => $request->year_n_postision,
                        'year_n_agency' => $request->year_n_agency,
                        'year_to' => $yearTo,
                        'year_from' => $request->from_year,
                        'three_y_period' => $request->period,
                        'division' => $request->division,
                        'office' => $request->office,
                        'develop_year' => $request->check_year,
                        'superior_id' => $request->my_supervisor];


        idp_created_by::create($saveCreated);

        return response()->json(['status' => 200]);

    }

    public function fetch_idpData(){
        $ipdData = [];
        $idpcreate = idp_created_by::where('active', 1)->where('emp_id', auth()->user()->employee)->latest('id')->get();

        foreach ($idpcreate as $idp) {

                $getTarget = idp_target::where('idp_id',  $idp->id)->where('active', 1)->get();
                $countTarget = $getTarget->count();

                $getActivity = idp_acrtivity::where('idp_id',  $idp->id)->where('active', 1)->get();
                $countActivity = $getActivity->count();

                $target = '';
                if( $countTarget > 0){
                    $target =  '<div class="flex justify-center items-center">
                                    <a id="'.$idp->id.'" data-target-count="'.$countTarget.'" class="flex justify-center items-center develop-target" href="javascript:;" data-tw-toggle="modal" data-tw-target="#addTarget_modal">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Show Target">
                                            '.$countTarget.'
                                        </div>
                                    </a>
                                </div>';
                }else{
                    $target =  '<div class="flex justify-center items-center">
                                    <a id="'.$idp->id.'" data-target-count="'.$countTarget.'" class="flex justify-center items-center develop-target" href="javascript:;" data-tw-toggle="modal" data-tw-target="#addTarget_modal">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Add Target">
                                            <i class="fa fa-plus items-center text-center text-primary"></i>
                                        </div>
                                    </a>
                                </div>';
                }

                $activity = '';
                if( $countActivity > 0){
                    $activity =  '<div class="flex justify-center items-center">
                                    <a id="'.$idp->id.'" data-activity-count="'.$countActivity.'" class="flex justify-center items-center development-activity" href="javascript:;" data-tw-toggle="modal" data-tw-target="#addDevelopment_activity_modal">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Show Activity">
                                            '.$countActivity.'
                                        </div>
                                    </a>
                                </div>';
                }else{
                    $activity =  '<div class="flex justify-center items-center">
                                    <a id="'.$idp->id.'" data-activity-count="'.$countActivity.'" class="flex justify-center items-center development-activity" href="javascript:;" data-tw-toggle="modal" data-tw-target="#addDevelopment_activity_modal">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Add Activity">
                                        <i class="fa fa-plus items-center text-center text-primary"></i>
                                        </div>
                                    </a>
                                </div>';
                }

                    $td = [

                        "id" => $idp->id,
                        "year_from" => $idp->year_from,
                        "year_to" => $idp->year_to,
                        "target" => $target,
                        "countTarget" => $countTarget,
                        "activity" => $activity,
                    ];
                    $ipdData[count($ipdData)] = $td;
        }
        // dd($ipdData);
        echo json_encode($ipdData);
    }

    public function saveDevelop_target(Request $request){
        // dd($request->all());
        foreach( $request->develop_target as $key => $develop_target)
        {

            $saveTarget['dev_target']   = $develop_target;
            $saveTarget['pg_support']   = $request->develop_goal[$key];
            $saveTarget['objective']    = $request->develop_objective[$key];
            $saveTarget['idp_id']       = $request->ridp_id;


            idp_target::updateOrCreate(['id' => $request->target_id[$key]],$saveTarget);
            // areas_model::updateOrCreate(['id' => $request->areasID[$key]], $insert_area);
            // dd($saveRate);
        }

        return response()->json(['status' => 200]);
    }

    public function show_tagetData(Request $request){
        // dd($request->all());
        $targetData = [];
        $getTarget = idp_target::where('idp_id',  $request->idp_id)->where('active', 1)->get();
        if($getTarget->count() > 0){
            foreach($getTarget as $target){
                $td = [

                    "target_id" => $target->id,
                    "dev_target" => $target->dev_target,
                    "pg_support" => $target->pg_support,
                    "objective" => $target->objective,
                ];
                $targetData[count($targetData)] = $td;
            }
            echo json_encode($targetData);
        }

    }

    public function delete_targetData(Request $request){

       $deleteTarget = idp_target::where('id', $request->targeting_id)->update(['active' => 0]);
        if($deleteTarget){
            return response()->json(['status' => 200]);
        }


    }

    public function saveDevelopment_plan(Request $request){

        // dd($request->all());
        $saveActivity = [
                            'idp_id' => $request->idp_id_plan,
                            'dev_activity' => $request->development_activity,
                            'support_needed' => $request->development_support,
                        ];


        idp_acrtivity::updateOrCreate(['id' => $request->activityID], $saveActivity);

        return response()->json(['status' => 200]);
    }

    public function show_Development_plan(Request $request){
        // dd($request->all());
        $activityData = [];
        $getActivity = idp_acrtivity::where('idp_id',  $request->idp_id)->where('active', 1)->get();
        if($getActivity->count() > 0){
            foreach($getActivity as $activity){


                $td = [

                    "activity_id" => $activity->id,
                    "dev_activity" => $activity->dev_activity,
                    "support_needed" => $activity->support_needed,
                    "planned" => $activity->planned,
                    "accom_mid_year" => $activity->accom_mid_year,
                    "accom_year_end" => $activity->accom_year_end,
                ];
                $activityData[count($activityData)] = $td;
            }
            echo json_encode($activityData);
        }
    }

    public function delete_Development_plan(Request $request){
        $deleteActivity= idp_acrtivity::where('id', $request->activity_id)->update(['active' => 0]);
        if($deleteActivity){
            return response()->json(['status' => 200]);
        }
    }

    public function print_IDP_data($idp_id){
        // dd($idp_id);

        $getIdp = idp_created_by::with(['get_employe_info', 'get_supervisor_info','get_position', 'get_salaryGrade'])->where('active', 1)->where('id', $idp_id)->first();
        $getTarget = idp_target::where('idp_id',  $idp_id)->where('active', 1)->get();
        $getActivity = idp_acrtivity::where('idp_id',  $idp_id)->where('active', 1)->get();

            $now = date('m/d/Y g:ia');

            $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
            $datetime->setTimezone('Asia/Manila');
            $current_date = $datetime->format('m-d-Y g:iA');

            $filename = 'My IDP';

        $system_image_header ='';
        $system_image_footer ='';

        if(system_settings()){
            $system_image_header = system_settings()->where('key','image_header')->first();
            $system_image_footer = system_settings()->where('key','image_footer')->first();
        }

        $emp_name = '';
        $supervisor_name = '';
        $position = '';
        $salaryGrade = '';
        if($getIdp){

            $emp_profile = $getIdp->get_employe_info;
            $supervisor_info = $getIdp->get_supervisor_info;
            $currentPosition = $getIdp->get_position;
            $salary = $getIdp->get_salaryGrade;

            if($emp_profile){

                $emp_name =  $emp_profile->lastname.', '. $emp_profile->firstname.' '. $emp_profile->mi.' '.$emp_profile->extension;
            }

            if($supervisor_info){
                $supervisor_name =  $supervisor_info->lastname.' '. $supervisor_info->firstname.' '. $supervisor_info->mi.' '.$supervisor_info->extension;
            }
            if( $currentPosition){
                $position = $currentPosition->emp_position;
            }
            if($salary){
                $salaryGrade = $salary->name.' ('.$salary->code.')';
            }


        }



        $pdf = PDF::loadView('IDP.print.print_idp', compact(
                                                            'system_image_footer', 'system_image_header',
                                                            'current_date','filename',
                                                            'getTarget', 'getActivity',
                                                            'emp_name', 'supervisor_name',
                                                            'position', 'salaryGrade',
                                                            'getIdp', 'idp_id'
                                                            ))->setPaper('a4', 'landscape');

        // if ($type == 'vw') {
            return $pdf->stream($filename . '.pdf');
        // } elseif ($type == 'dl') {
        //     return $pdf->download($filename . '.pdf');
        // }
    }

    public function saveActivityPlan(Request $request){

        foreach ($request->plans as $key => $plan) {

            $saveActivityPlan['planned']      = $plan;
            $saveActivityPlan['idp_id']      = $request->idp_idss;
            $saveActivityPlan['activity_id']      = $request->activity_ids;
            $saveActivityPlan['accom_mid_year']      = $request->mid_year[$key];
            $saveActivityPlan['accom_year_end']       = $request->year_end[$key];

            activity_plan::updateOrCreate(['id' => $request->activity_planID[$key]], $saveActivityPlan);

        }

        return response()->json(['status' => 200]);
        // dd($request->all());

    }

    public function idp_detail($idpID){

        $idp_data = idp_created_by::where('id', $idpID)->first();

        $getActivity = idp_acrtivity::where('idp_id',  $idpID)->where('active', 1)->get();

        $getTarget = idp_target::where('idp_id',  $idpID)->where('active', 1)->get();
        // $IDP_data = '';

        $getActivity_plan = activity_plan::where('idp_id',  $idpID)->where('active', 1)->get();

            $IDP_targetData = '';
            $IDP_activityData = '';

        if($getActivity->count() > 0){
            $IDP_activityData = $getActivity;
        }else{
            $IDP_activityData = '';
        }

        if($getTarget->count() > 0){
            $IDP_targetData = $getTarget;
        }else{
            $IDP_targetData = '';
        }


        return view('IDP.idp_detail', compact('idpID',
                                                'idp_data',
                                                'getActivity',
                                                'IDP_activityData',
                                                'IDP_targetData',
                                             'getActivity_plan'));
    }

    public function saveAll_idp(Request $request){
        // dd($request->all());

        $yearTo = '';
// dd($request->dev_target);
        if($request->to_year == 0 || $request->to_year == null){
            $yearTo = null;
        }else{
            $yearTo = $request->to_year;
        }

        // dd($yearTo);
        $saveCreated = ['emp_id' => auth()->user()->employee,
                        'position_id' => $request->my_position,
                        'sg_id' => $request->my_sg,
                        'year_n_position' => $request->year_n_postision,
                        'year_n_agency' => $request->year_n_agency,
                        'year_to' => $yearTo,
                        'year_from' => $request->from_year,
                        'three_y_period' => $request->period,
                        'division' => $request->division,
                        'office' => $request->office,
                        'develop_year' => $request->check_year,
                        'superior_id' => $request->my_supervisor];


        idp_created_by::updateOrCreate(['id' => $request->idp_ids], $saveCreated);

        if($request->dev_target != null){
            foreach( $request->dev_target as $key => $develop_target){

                $saveTarget['dev_target']   = $develop_target;
                $saveTarget['pg_support']   = $request->pg_support[$key];
                $saveTarget['objective']    = $request->objective[$key];
                $saveTarget['idp_id']       = $request->idp_ids;

                idp_target::updateOrCreate(['id' => $request->targetID[$key]],$saveTarget);
            }
        }

        if($request->dev_activity != null){
           foreach ($request->dev_activity as $activity_key => $develop_activity) {

                $saveActivity['dev_activity']   = $develop_activity;
                $saveActivity['support_needed']   = $request->support_needed[$activity_key];
                $saveActivity['idp_id']    = $request->idp_ids;

                idp_acrtivity::updateOrCreate(['id' => $request->activityID[$activity_key]], $saveActivity);
            }
        }


        return response()->json(['status' => 200]);
    }

    public function delete_targeting_data($tagetingID){
       $notActive =  idp_target::where('id', $tagetingID)->update(['active' => 0]);

       if($notActive){
        return response()->json(['status' => 200]);
       }
    }

    public function delete_activiting_data($activity_id){

        $notActive =  idp_acrtivity::where('id', $activity_id)->update(['active' => 0]);

       if($notActive){
        return response()->json(['status' => 200]);
       }
    }


    // public function get__Employee_position(Request $request)
    // {
    //      try {

    //         $get_position = '';
    //         $decrypted = '';
    //         $pos = '';
    //         $id = auth()->user()->employee;
    //         $fullname = '';

    //         if($id)
    //         {
    //             $get_position = $this->get_Position($id);
    //             $get_desig = $this->get_Employee_designation($id);
    //             $department = $this->get_department($id);
    //             $emp_name = $this->get_employee_name($id);
    //             $pic = get_profile_image($id);

    //             if($get_position != null)
    //             {

    //                 $pos = $get_position->emp_position;
    //                 $pos_id = $get_position->id;
    //             }
    //             else
    //             {
    //                 $pos = '';
    //                 $pos_id = '';
    //             }

    //              if($get_desig != null)
    //             {
    //                 $get_desig_id = $get_desig->id;
    //                 $get_desig = $get_desig->userauthority;
    //             }
    //             else
    //             {
    //                  $get_desig_id = '';
    //                  $get_desig = '';
    //             }
    //              if($department !=null)
    //             {
    //                 $dept_id = $department->responid;
    //                 $department = $department->centername;

    //             }
    //             else
    //             {
    //                   $dept_id = '';
    //                   $department = '';

    //             }

    //             if($emp_name != null)
    //             {
    //                 $fullname = $emp_name->firstname .' '. $emp_name->lastname;
    //             }
    //             else
    //             {
    //                 $fullname = '';
    //             }



    //                 return json_encode(array(
    //                     "position" => $pos,
    //                     "designation" => $get_desig,
    //                     "department" => $department,
    //                     "name" => $fullname,
    //                     "pic" => $pic,
    //                     "pos_id" => $get_position->id,
    //                     "desig_id" => $get_desig_id,
    //                     "dept" => $dept_id,
    //                 ));
    //         }


    //     } catch (DecryptException $e) {
    //         dd($e);
    //     }
    // }

    // private function get_Employee_designation($id)
    // {
    //     $get_designation = '';
    //     $get_designation_position = '';

    //     try
    //     {

    //             $get_designation = $this->get_agency_employees($id);

    //             $get_designation_position = tbluserassignment::where('id',$get_designation->designation_id)->first();

    //              return $get_designation_position;

    //     }catch(Exception $e)
    //     {
    //         dd($e);
    //     }
    // }

    // private function get_department($id)
    // {
    //     $dept ='';
    //     $assign_dept = '';

    //     try
    //     {
    //         $dept = $this->get_agency_employees($id);
    //         $assign_dept = tbl_responsibilitycenter::where('responid',$dept->office_id)->where('active',true)->first();

    //         return $assign_dept;


    //     }catch(Exception $e)
    //     {
    //         dd($e);
    //     }
    // }

    // private function get_Position($id)
    // {
    //     $get_position_id = '';
    //     $get_position = '';

    //     try
    //     {
    //         $get_position_id = $this->get_agency_employees($id);

    //         $get_position = tbl_position::where('id',$get_position_id->position_id)->first();

    //         return $get_position;

    //     }catch(Exception $e)
    //     {
    //         dd($e);
    //     }
    // }

    // private function get_agency_employees($id)
    // {
    //     try
    //     {
    //         $agency_employees = '';

    //         $agency_employees = agency_employees::where('agency_id',$id)->where(function($q){
    //             $q->whereNotNull('position_id')->orWhere('designation_id','!=','');
    //           })->first();

    //           return $agency_employees;
    //     }
    //     catch(Exception $e)
    //     {
    //         dd($e);
    //     }
    // }

    // private function get_employee_name($id)
    // {
    //     try
    //     {
    //         $get_emp_name = '';

    //         $get_emp_name = employee::where('agencyid',$id)->where('active',true)->first();

    //         return $get_emp_name;

    //     }catch(Exception $e)
    //     {
    //         dd($e);
    //     }
    // }


    // public function update_job_pos(Request $request)
    // {
    //     try
    //     {
    //         $id = auth()->user()->employee;

    //         if(($request->pos!='' && $request->desig!='') && $request->dept!='' )
    //         {
    //             $data = [
    //                 "position_id" =>  $request->pos,
    //                 "designation_id" => $request->desig,
    //                 "office_id" => $request->dept,
    //             ];

    //             $update_position = agency_employees::where('agency_id',$id)->update($data);

    //             return response()->json([
    //                 "status" => true,
    //                 "message" => 'Successfully updated'
    //             ]);
    //         }

    //     }catch(Exception $e)
    //     {
    //         dd($e);
    //     }
    // }

}
