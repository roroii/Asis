<?php

namespace App\Http\Controllers\ratingController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rating\ratingtCriteria_model;
use App\Models\Hiring\tbl_position;
use App\Models\applicant\applicants_list;
use App\Models\rating\ratedAppcants_model;
use App\Models\rating\ratedCriteria_model;
use App\Models\rating\areas_model;
use App\Models\rating\ratedArea_model;
use App\Models\Hiring\tbl_positionType;
use App\Models\Hiring\tbl_hiringlist;
use App\Models\rating\ratedDone_model;
use App\Models\document\_user_privilege;
use App\Models\Hiring\tblpanels;
use App\Models\Hiring\tbljob_info;
use App\Models\User;
use App\Models\document\doc_notification;
use App\Models\tblemployee;
use App\Models\system\default_settingNew;
use App\Models\status_codes;
use App\Models\Hiring\tbl_shortlisted;
use App\Models\rating\hiredNotification;
use App\Models\agency\agency_employees;
use App\Models\rating\competency_dictionary;
use App\Models\competency_dictionary_skills;
use App\Models\competency_skills;
use Carbon\Carbon;

use PDF;

class ratingContoller extends Controller
{

    private function userAdmin(){
        if(auth()->user()->role_name == "Admin"){
            return true;
        }else{
            return false;
        }
    }
    // ---COTROLLER BEGIN FOR CRITERIA ---//
    public function criteria_page(){
        $positionCategories = tbl_positionType::where('active', 1)->get();
        // dd($applicants);
        return view('ratingCriteria.criteria_page', compact('positionCategories'));
    }

    public function fetchedCriteria(Request $request){
        // dd($request->position_id);
        $ratingCriteria ='';

        if($request->position_id==null || $request->position_id=="All"){

            $ratingCriteria = ratingtCriteria_model::with('get_Position', 'get_competency')->where('active', 1)->get();
        }else{
            $ratingCriteria = ratingtCriteria_model::with('get_Position', 'get_competency')->where('position_id',$request->position_id)->where('active', 1)->get();
        }

        $output = '<table id="tbl_criteria" class="table table-report table-hover text-center align-middle">
        <thead>

                <tr>
                    <th class="text-center whitespace-nowrap ">Criteria</th>
                    <th class="text-center whitespace-nowrap ">Areas</th>
                    <th class="text-center whitespace-nowrap ">Position</th>
                    <th class="text-center whitespace-nowrap ">Max Rate</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>

        </thead>
        <tbody>';
        // $ratingCriteria = ratingtCriteria_model::with('getPosition_category')->where('active', 1)->get();


        if ($ratingCriteria->count() > 0) {

            foreach($ratingCriteria as $criteria){

                // dd($criteria);

                //    dd($position);
                $criteriad = '';
                $position = '';
                $position_idd = '';
                $competency_id = '';
                if($criteria->get_Position){
                    $positionnn = $criteria->get_Position;
                    $position = $positionnn->emp_position;
                    $position_idd = $positionnn->id;
                }else{

                }
                if($criteria->competency_id != null){
                    if($criteria->get_competency){
                        $competency = $criteria->get_competency;
                        $criteriad = $competency->name;
                        $competency_id = $competency->id;
                    }else{

                    }
                }else{
                    $criteriad = $criteria->creteria;
                    $competency_id = '';
                }
                $output .= '<tr class="text-center">

                                <td>

                                    '.$criteriad.'

                                </td>

                                <td>';

                                $ff = areas_model::whereHas('get_criteria')->where('criteria_id', $criteria->id)->first();

                                if ($ff) {
                                    // dd('kiko');
                                    $output .= '<div title="Criteria Areas">
                                                    <a id="'.$criteria->id.'"
                                                    data-criteria-name = "'.$criteriad.'"
                                                    data-criteria-points = "'.$criteria->maxrate.'"
                                                    data-competency-id="'.$competency_id.'"
                                                    class="flex justify-center items-center show_areas" href="javascript:;" data-tw-toggle="modal" data-tw-target="#arias_modal">
                                                        <h5 class="underline decoration-dotted underline-offset-4 text-primary dark:text-slate-400">
                                                            Sub-Criteria
                                                        </h5>
                                                    </a>
                                                    <div class="dropdown-menu w-40">

                                                    </div>
                                                </div>';
                                }else{
                                    // dd('kokak');
                                    $output .= '<div title="Criteria Areas">
                                                    <a id="'.$criteria->id.'"
                                                     data-criteria-name = "'.$criteriad.'"
                                                     data-criteria-points = "'.$criteria->maxrate.'"
                                                     data-competency-id="'.$competency_id.'"
                                                     class="flex justify-center items-center show_areas" href="javascript:;" data-tw-toggle="modal" data-tw-target="#arias_modal">
                                                        <h5 class="underline decoration-dotted underline-offset-4 text-primary dark:text-slate-400">
                                                        Sub-Criteria
                                                        </h5>
                                                    </a>
                                                    <div class="dropdown-menu w-40">

                                                    </div>
                                                </div>';
                                }
                                $output .= '</td>

                                <td>
                                    ' .$position.'
                                </td>
                                <td>
                                    ' .$criteria->maxrate. '
                                </td>

                               <td>

                                    <div class="flex justify-center items-center">';


                            $output .= '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <div class="dropdown-content">
                                                    <a id="'.$criteria->id.'"
                                                        data-criteria="'.$criteriad.'"
                                                        data-max-rate="'.$criteria->maxrate.'"
                                                        data-position="'.$position_idd.'"
                                                        data-competency-id="'.$competency_id.'"
                                                        href="javascript:;"
                                                        class="dropdown-item editCriteria_btn">

                                                        <i class="fa fa-edit w-4 h-4 mr-2 text-success"></i>

                                                        Edit

                                                    </a>
                                                    <a id="'.$criteria->id.'" href="javascript:;" class="dropdown-item deleteCriteria_btn"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </td>
                            </tr>';

            }


        }else{

        }
        $output .= '</tbody></table>';

        echo $output;
    }

    public function addCriteria(Request $request){

        foreach ($request->positionID as $key => $position) {
            $insert_criteria['position_id']      = $position;
            $insert_criteria['competency_id']      = $request->competencyID[$key];
            $insert_criteria['creteria']      = $request->criterias[$key];
            $insert_criteria['maxrate']       = $request->maxrate[$key];

            ratingtCriteria_model::Create($insert_criteria);

        }

        return response()->json(['status' => 200]);
        // dd($request->all());
    }

    public function onchangeCompetency_points($competency_id){
        $points = '';
        $competency_points = competency_dictionary::where('id', $competency_id)->first();
        if($competency_points){
            $points = $competency_points->points;
        }
        return response()->json(['points' => $points]);
    }

    public function updateCriteria(Request $request){
        $criteriaUpdate = ratingtCriteria_model::where('id', $request->critID);

        $updateExist = [
            'creteria' => $request->critersing,
            'competency_id' => $request->competensing,
            'position_id' => $request->positioning,
            'maxrate' => $request->maxrating,
        ];
        $criteriaUpdate->update($updateExist);

        return response()->json(['status' => 200]);

    }

    public function deleteCriteria(Request $request){
        $criteria_id = ratingtCriteria_model::where('id', $request->criteria_id)->first();

        $removeToRow = [
            'active' => 0,
        ];
        $criteria_id->update($removeToRow);

        return response()->json(['status' => 200]);
    }
    // ---COTROLLER END FOR CRITERIA ---//

    // ---//-- CRITERIA AREAS--//----------//
    public function storeArea(Request $request){
        // dd($request->all());
        // $criters = ratingtCriteria_model::whereHas('get_areas')->where('id', $request->critID)->get();
        // dd($criters);

        foreach ($request->areaname as $key => $areaName) {

            $insert_area['area']  = $areaName;
            $insert_area['criteria_id']     = $request->critID;
            $insert_area['rate']            = $request->arearate[$key];

            areas_model::updateOrCreate(['id' => $request->areasID[$key]], $insert_area);
        }
        return response()->json(['status' => 200]);

    }

    public function showAreas($id){

        $areas_all = [];
        $areas = areas_model::where('criteria_id', $id)->where('active', 1)->get();
        $area_sum = areas_model::where('criteria_id', $id)->where('active', 1)->sum('rate');

        foreach ($areas as $area) {

                    $td = [

                        "id" => $area->id,
                        "area" => $area->area,
                        "rate" => $area->rate,
                        "area_sum" => $area_sum,
                    ];
                    $areas_all[count($areas_all)] = $td;
        }
        // dd($areas_all);
        echo json_encode($areas_all);

    }

    public function onChangeSkill($skill_id){
        // dd($comp_id);
        $skill_points = '';
        $competency_skill = competency_skills::where('skillid', $skill_id)->get();

        foreach($competency_skill as $compet_skill){
            $skill_points = $compet_skill->default_points;

        }

        return response()->json(['skill_points' => $skill_points]);

    }

    public function deleteAreas($id){
        $area = areas_model::where('id', $id)->update(['active' => 0]);
    }

    // ---COTROLLER BEGIN FOR RATING ---//
    public function manageRating_page(){
        $positionCategory = tbl_positionType::where('active', 1)->get();


        return view('ratingCriteria.manageRating_page', compact('positionCategory'));
    }

    public function filterRatedApplicants(){

        $getApplicants = tbl_shortlisted::doesntHave('get_applicant_rated')
        ->whereHas('get_job_info.getPanelist')
        ->with(['get_profile',
                'get_job_info.get_Position',
                'get_job_info.getPanels',
                'get_job_info.get_position_type',
                'get_stat'])->where('stat', 10)
        ->where('active', 1)
        ->get();

        // if($getApplicants->rate_sched)
        // dd($getApplicants);
        $output = ' <table id="tbl_applicant_rated" class="table table-report table-hover text-center align-middle">
        <thead>

                <tr>
                    <th class="text-center whitespace-nowrap ">Applicant Name</th>
                    <th class="text-center whitespace-nowrap ">Position Applied</th>
                    <th class="text-center whitespace-nowrap ">Interview Date</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>

        </thead>
        <tbody>';

        if($getApplicants->count() > 0){


            foreach ($getApplicants as $getApplicant) {

                    $clock_btn ='';
                    $rate_class = '';
                    $btnClass_status = '';
                    $status = '';
                    $stats_class = '';
                    $sched_date = $getApplicant->rate_sched;
                    $rate_datess = (new Carbon)->parse($sched_date);
                    // dd($rate_datess);

                    $hr =  $rate_datess->hour;
                    $min = $rate_datess->minute;
                    $sec = $rate_datess->second ;

                    $hr_to_min = 60 * $hr;
                    $hr_to_min_min = $hr_to_min + $min;
                    $sec_to_min = $sec / 60;
                    // dd($rate_datess, $sec_to_min, $sec);


                    $rate_date = $rate_datess->subMinutes($hr_to_min_min+$sec_to_min);
                    $date_today =  Carbon::now()->shiftTimezone('Asia/Manila'); // today
                    // dd($rate_date, $hr_to_min_min, $sec);

                    // $diff_of_days = $date_today->diffInHours($rate_date);

                    // dd($rate_date->subMinutes(1440));
                    if($rate_date <= $date_today){
                        $rate_class = 'rate_Icon';
                        $btnClass_status = 'primary';
                        $stats_class = 'success';
                        $status_st = 'Ready to Rate';
                        $clock_btn = '';
                    }else{
                        $rate_class = '';
                        $btnClass_status = '';
                        $stats_class = 'pending';
                        $status_st = $getApplicant->get_stat->name;
                        $clock_btn = '<i class="fa fa-solid fa-clock"></i>';
                    }

                    $applicant_id = '';
                    $applicant_name = '';
                    $position = '';
                    $position_id = '';
                    $rate_sched = '';
                    $position_type_id = '';
                    $user_id = '';
                    $job_refference = '';

                    if($getApplicant){
                        $rate_sched = $getApplicant->rate_sched;
                        $applicant_id = $getApplicant->id;

                        $get_profile = $getApplicant->get_profile;
                        $get_jobIinformation = $getApplicant->get_job_info;

                        if($get_profile){
                            $applicant_name = $get_profile->lastname.' '.$get_profile->lastname.' '.$get_profile->mi;
                            $user_id = $get_profile->user_id;
                        }else{
                            $applicant_name = 'no profile record found';
                        }

                        if($get_jobIinformation){
                            $job_refference = $get_jobIinformation->jobref_no;
                            $get_positions = $get_jobIinformation->get_Position;
                            $get_position_type = $get_jobIinformation->get_position_type;

                            if($get_positions){
                                $position = $get_jobIinformation->get_Position->emp_position;
                                $position_id = $get_jobIinformation->get_Position->id;
                            }else{
                                $position = 'no position record.';
                                $rate_class = '';
                                $btnClass_status = '';
                            }

                            if($get_position_type){
                                $position_type_id = $get_position_type->id;
                            }else{
                                $position_type_id = 'no position Type record.';
                                $rate_class = '';
                                $btnClass_status = '';
                            }



                        }else{
                            $position = 'no position info.';
                            $rate_class = '';
                            $btnClass_status = '';
                        }



                    }
                    // dd($position_type_id);
                // dd($getApplicant->get_job_info->get_Position->emp_positiono);
                // dd($getApplicant);

                $output .= '<tr class="text-center" style="text-align: center">

                                <td>

                                    '.$applicant_name.'

                                </td>

                                <td>
                                    '.$position.'
                                </td>

                                <td>

                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-'.$stats_class.' rounded-full mr-3"></div>
                                            <span class="truncate">'.$rate_sched.'</span>


                                        <div class="ml-auto cursor-pointer tooltip">
                                           <div>
                                                <p id="timer" class = "timer text-xs ml-auto">
                                                    <span id="timer-days" class = "timer-days"></span>
                                                    <span id="timer-hours" class = "timer-hours"></span>
                                                    <span id="timer-mins" class = "timer-mins"></span>
                                                    <span id="timer-secs" class = "timer-secs"></span>
                                                </p>
                                            </div>

                                            <a class="flex justify-center items-center text-primary timer_btn" href="javascript:;"
                                                data-rate-date = "'.$rate_date.'">

                                                '.$clock_btn.'

                                            </a>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div class="flex justify-center items-center">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Rate">
                                                <a data-position-type="'.$position_type_id.'"
                                                data-position-id="'.$position_id.'"
                                                data-applicant-id="'.$user_id.'"
                                                data-applicant-list-id="'.$applicant_id.'"
                                                data-applicant-job-ref="'.$job_refference.'"
                                                class="flex justify-center items-center text-'.$btnClass_status.' '.$rate_class.'"
                                                href="javascript:;">
                                                <i class="fa-solid fa-ranking-star"></i>
                                                </a>
                                            </div>
                                        </div>
                                </td>
                            </tr>';

            }
            $output .= '</tbody></table>';

        }

        echo $output;
    }


    public function filterPositionBy_applicant($id){
        $output = '';
        $appPosition = [];
        $applicantPost = tbl_hiringlist::with('get_job_info.getPos')->where('applicant_id', $id)->where('active', 1)->get();
        // dd($applicantPost);
        $output .= '<label for="position">Position Applied:</label>
                            <select id="ApplicantPosition_select" name="ApplicantPosition" class="select2 form-control"><option disabled selected>Please Select Position</option>';

                                foreach ($applicantPost as $getAvailPos) {

                                    foreach ($getAvailPos->get_job_info as $getPosit) {

                                        foreach($getPosit->getPos as $position){
                                            // dd($position->id);

                                           $output .= '<option value="'.$position->id.'">'. $position->emp_position.'</option>';

                                        }
                                    }

                                }

                            $output .= '</select>';

        // dd($output);
        echo $output;
    }

    public function filter_ratingCriteria(Request $request, $id){
        // dd($request->all());
        $position = [];

        // $getType =  tbljob_info::where('pos_title', $id)->where('active', 1)->first();
        $filterCriteria =  ratingtCriteria_model::with('get_Position', 'get_competency')->where('position_id', $id)->where('active', 1)->get();
        $totalSum =  ratingtCriteria_model::with('get_Position')->where('active', 1)->where('position_id', $id)->sum('maxrate');

        // dd($filterCriteria);
        $count_criteria = $filterCriteria->count();

        $max_ave = $totalSum/$count_criteria;

        foreach ($filterCriteria as $criteria) {
            $criteria_content = '';
            if($criteria->competency_id !=null){
                if($criteria->get_competency){
                    $competency = $criteria->get_competency;
                    $criteria_content =  $competency->name;
                }else{
                    $criteria_content = 'unknown competency';
                }
            }else{
                $criteria_content = $criteria->creteria;
            }
            // dd($criteria);

            $ratedArea = ratedArea_model::where('criteria_id', $criteria->id)
                            ->where('short_list_id', $request->applicant_s_list_id)
                            ->where('position_id', $id)
                            ->where('applicant_id', $request->applicantid)
                            ->where('rated_by', auth()->user()->employee)
                            ->get();

            // foreach($ratedArea as $rArea){
                // dd($rArea);
                // dd($rArea->sum('rate'));
            // }
            // dd($ratedArea);
            // dd($ratedCriteria->sum('rate'));
            $area_sum_all = '';
            $sumOf_ratedArea = '';
            if($ratedArea){
               $sumOf_ratedAreass = ratedArea_model::where('criteria_id', $criteria->id)
                                            ->where('position_id', $id)
                                            ->where('short_list_id', $request->applicant_s_list_id)
                                            ->where('applicant_id', $request->applicantid)
                                            ->where('rated_by', auth()->user()->employee)
                                            ->sum('rate');
               if($sumOf_ratedAreass == 0){
                    $sumOf_ratedArea = '';
               }
               else{
                $sumOf_ratedArea = $sumOf_ratedAreass;
               }
               $area_sum_all = ratedArea_model::where('position_id', $id)
                                                ->where('short_list_id', $request->applicant_s_list_id)
                                                ->where('applicant_id', $request->applicantid)
                                                ->where('rated_by', auth()->user()->employee)->sum('rate');
            }
            // dd($sumOf_ratedArea);


                $td = [

                        "id" => $criteria->id,
                        "criteria" => $criteria_content,
                        "positionID" => $criteria->position_id,
                        "maxrate" => $criteria->maxrate,
                        "totalMax_rate" => $totalSum,
                        "areaSum" => $sumOf_ratedArea,
                        "area_sum_all" => $area_sum_all,
                        "count_criteria" => $count_criteria,
                        "max_ave" => $max_ave,

                ];
                    $position[count($position)] = $td;


        }
        // dd($position);
        echo json_encode($position);
    }

    public function showRatingArea(Request $request, $id){
        // dd($request->all());
        $ar = [];
        $rated_areaID = '';
        $td = [];
        $rate = '';
        $ratedID = 0;
        $sumall ='';
        $max_average = '';
        $areass = areas_model::where('criteria_id', $id)->where('active', 1)->get();
        $areass_sum = areas_model::where('criteria_id', $id)->where('active', 1)->sum('rate');
        // dd($areass);
        $cout_areass = $areass->count();
        if ($cout_areass > 0) {


            $max_average = $areass_sum/$cout_areass;
            // $rated_id = ratedArea_model::where('criteria_id', $id)->where('position_id', $request->positionID)->where('applicant_id',$request->applicantID)->where('rated_by', auth()->user()->employee)
            $rated_id = ratedArea_model::where('criteria_id', $id)
                                        ->where('short_list_id', $request->applicant_list_id)
                                        ->where('job_ref', $request->applicant_job_ref)
                                        ->where('applicant_id',$request->applicantID)
                                        ->where('rated_by', auth()->user()->employee)
                                        ->exists();
            // dd($rated_id);

            if($rated_id){
                // $ratedArea_ave = 0;
                // dd($rated_id);
                $rated_data = ratedArea_model::with(['get_area'])
                                                ->where('criteria_id', $id)
                                                ->where('short_list_id', $request->applicant_list_id)
                                                ->where('job_ref', $request->applicant_job_ref)
                                                ->where('applicant_id',$request->applicantID)
                                                ->where('rated_by', auth()->user()->employee)
                                                ->get();

                $rated_area_count = $rated_data->count();
                // $rated_data = ratedArea_model::with('get_area')->where('criteria_id', $id)->where('position_id', $request->positionID)->where('applicant_id',$request->applicantID)->where('rated_by', auth()->user()->employee)->sum('rate');
                $sumall = ratedArea_model::with(['get_area'])
                                            ->where('criteria_id', $id)
                                            ->where('short_list_id', $request->applicant_list_id)
                                            ->where('job_ref', $request->applicant_job_ref)
                                            ->where('applicant_id',$request->applicantID)
                                            ->where('rated_by', auth()->user()->employee)
                                            ->sum('rate');

                $ratedArea_ave =  $sumall/ $rated_area_count;


                foreach ($rated_data as $key => $value) {
                            $max_rate = '';
                            $area_name = '';
                            $area_id = '';
                    // dd($value->get_area);
                    if($value->get_area){
                        $max_rate = $value->get_area->rate;
                        $area_name = $value->get_area->area;
                        $area_id =$value->get_area->id;
                    }else{
                        $max_rate = "";
                    }
                    $ratedID = $value->id;
                    // foreach ($value->get_area as $area) {


                        if($value->rate == 0){
                            $rate = '';
                        }else{
                            $rate = $value->rate;
                        }


                        $td = [
                                "rated_id" => $ratedID,
                                "id" =>  $area_id,
                                "area" => $area_name,
                                "max_rate" => $max_rate,
                                "max_average" => $max_average,
                                "rate" => $rate,
                                "sumAll" => $sumall,
                                "ratedArea_ave" => $ratedArea_ave,


                        ];
                        $ar[count($ar)] = $td;
                    // }
                }

            } else{

                foreach ($areass as $areas) {
                    // dd($areas);
                    $td = [
                            "rated_id" => $ratedID,
                            "id" => $areas->id,
                            "area" => $areas->area,
                            "rate" => $rate,
                            "max_rate" => $areas->rate,
                            "max_average" => $max_average,
                            "sumAll" => $sumall,
                    ];
                        $ar[count($ar)] = $td;
                }

            }

        // dd($ar);

        }
        echo json_encode($ar);
    }

    public function saveRating(Request $request){
        // dd($request->all());
        $check = $request->checkbox;
        $ratedUse = 0;
        if($check == null || $check == 0){
            $ratedUse = 0;
        }else{
            $ratedUse = 1;
        }

            $saverated = new ratedAppcants_model;
            $saverated->applicantID = $request->input('applicant_ids');
            $saverated->position_type = $request->input('position_type');
            $saverated->positionID = $request->input('position');
            $saverated->applicant_listID = $request->input('applicant_list_id');
            $saverated->applicant_job_ref = $request->input('applicant_job_ref');
            $saverated->remarks = $request->input('remarks');
            $saverated->rate = $request->total_rate;
            $saverated->average = $request->total_average_rate;
            $saverated->rate_use = $ratedUse;
            $saverated->rated_by   = auth()->user()->id;
            $saverated->rater_agency_id   = auth()->user()->employee;
            $saverated->save();

            foreach( $request->rate as $key => $rate)
            {

                $saveRate['rated']        = $rate;
                $saveRate['applicant_id']  = $request->applicant_ids;
                $saveRate['criteria_id']   = $request->criteriaID[$key];
                $saveRate['position_id']   = $request->position;
                $saveRate['applicant_job_ref']  = $request->applicant_job_ref;
                $saveRate['short_listID']  = $request->applicant_list_id;
                $saveRate['rated_by']  = auth()->user()->id;
                $saveRate['rater_ag_id']  = auth()->user()->employee;

                ratedCriteria_model::create($saveRate);
                // dd($saveRate);
            }

            return response()->json(['status' => 200]);


    }

    public function storeRated_areas(Request $request){
        // dd($request->all());

        foreach( $request->rate_area as $key => $area_rate)
        {

            $saveRate['rate']        = $area_rate;
            $saveRate['areas_id']   = $request->areas_id[$key];
            $saveRate['applicant_id']  = $request->applicant_id;
            $saveRate['criteria_id']  = $request->criteria_id;
            $saveRate['position_id']  = $request->position_id;
            $saveRate['short_list_id']  = $request->applicant_list_ids;
            $saveRate['job_ref']  = $request->applicant_job_refs;
            $saveRate['rated_by']  = auth()->user()->employee;

            ratedArea_model::updateOrCreate(['id' => $request->ratedArea_id[$key]],$saveRate);
            // areas_model::updateOrCreate(['id' => $request->areasID[$key]], $insert_area);
            // dd($saveRate);
        }

        return response()->json(['status' => 200]);

    }

    // ---COTROLLER END FOR RATING ---//

    //===== SUMMARY OF RATING -----//
    public function summary_page(){
        $ratedApplicant = ratedAppcants_model::with(['get_applicant', 'get_position', 'get_ratedcriteria.get_criteria' ])->where('active', 1)->where('rater_agency_id', auth()->user()->employee)->get();
        return view('ratingCriteria.summary_page', compact(['ratedApplicant'] ));
    }

    public function fetched_Applicant_summary($position_id){
        // dd($postype_id);


        $ratedApplicants = '';

        $checkUser = User::where('id', auth()->user()->id)->first();
        $output = '<table id="tbl_summary" class="table table-report -mt-2 table-bordered">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap"> Applicant Name </th>
                        <th class="text-center whitespace-nowrap"> Position Applied </th>
                        <th class="text-center whitespace-nowrap"> Rating Status </th>
                        <th class="text-center whitespace-nowrap"> Action </th>
                    </tr>
                </thead>
                <tbody>';

        $checkUser = User::where('id', auth()->user()->id)->first();

        if($position_id == "undefined" || $position_id == "all"){
           if($checkUser->role_name == "Admin"){
                $ratedApplicants = ratedAppcants_model::doesntHave('get_rated_done')->with(['get_applicant_profile', 'get_positionee', 'get_panels'])
                ->get()->unique('applicant_listID');
           }else{
                $ratedApplicants = ratedAppcants_model::doesntHave('get_rated_done')->with(['get_applicant_profile', 'get_positionee', 'get_panels'])
                ->where('rater_agency_id', auth()->user()->employee)->get();
           }

        }else{
            if($checkUser->role_name == "Admin"){
                $ratedApplicants = ratedAppcants_model::doesntHave('get_rated_done')->with(['get_applicant_profile', 'get_positionee', 'get_panels'])
                ->where('positionID', $position_id)
                ->get()->unique('applicant_listID');
           }else{
                $ratedApplicants = ratedAppcants_model::doesntHave('get_rated_done')->with(['get_applicant_profile', 'get_positionee', 'get_panels'])
                ->where('rater_agency_id', auth()->user()->employee)
                ->where('positionID', $position_id)->get();
           }

        }

        if($ratedApplicants->count() > 0){

            foreach ($ratedApplicants as $applicants) {

                // dd($applicants->id);


                $_ratercount = '';
                $status = '';
                $status_class = '';
                $status_stag = '';
                $panels_count = '';
                $approval_btn = '';
                if($applicants->get_panels){

                    foreach($applicants->get_panels as $panels){
                        $pans = $panels->where('available_ref', $applicants->applicant_job_ref)->where('active', 1)->get();
                            $panels_count = $pans->count();

                    }

                }

                    $_count_rater = ratedAppcants_model::where('applicant_job_ref', $applicants->applicant_job_ref)->where('applicantID', $applicants->applicantID)->get();
                        $_ratercount = $_count_rater->count();
                        // dd($_ratercount);
                        // if($count_panels > 0){
                        //     $rater_count = $_ratercount;
                        // }else{
                        //     $rater_count = 'Not Rated Yet';
                        // }

                $applicantname = '';
                $applicantPosition = '';
                $positionID = '';
                $profileID = '';
                if($applicants->get_applicant_profile){
                    $profileID = $applicants->get_applicant_profile->id;
                    $applicantname = $applicants->get_applicant_profile->lastname.', '. $applicants->get_applicant_profile->firstname.' '. $applicants->get_applicant_profile->mi;

                }else{
                    $applicantname = ' Applicant Profile is No longger Exist!';
                }
                // dd($applicants->get_positionee);
                if($applicants->get_positionee){
                    $positionID = $applicants->get_positionee->id;
                    $applicantPosition = $applicants->get_positionee->emp_position;
                }else{
                    $applicantPosition = 'Position is No longger Exist';
                }

            $rated = ratedDone_model::where('applicant_id', $applicants->applicantID)
                ->where('applicant_job_ref', $applicants->applicant_job_ref)
                ->where('shortList_id', $applicants->applicant_listID)
                ->where('position_id', $positionID)->first();

                $rated_done_id = '';
                $href = '';
                if( $rated){
                    $rated_done_id = $rated->id;
                    $href = '/rating/applicant-information-page/'.$rated_done_id.'';
                }else{
                    $href = 'javascript:;';
                }
                // dd( $rated);
                // $get_status = new status_codes;
                // dd($rated_done_id);
                if($panels_count == $_ratercount){
                    $check_status = status_codes::where('id', 7)->first();
                    $status =  $check_status->name;
                    $status_class =  $check_status->class;
                    $status_stag =  $check_status->stag;

                    $check_hr = tbljob_info::where('jobref_no', $applicants->applicant_job_ref)->first();
                    if( $check_hr->email_through === auth()->user()->employee){
                        $approval_btn =     '<div class="flex justify-center items-center">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                                        <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                                        <div class="dropdown-menu w-auto">

                                                            <div class="dropdown-content">

                                                                <a id="'.$applicants->id.'"
                                                                    data-shortlist-id="'.$applicants->applicant_listID.'"
                                                                    data-applicant-id="'.$applicants->applicantID.'"
                                                                    data-position-id="'.$positionID.'"
                                                                    data-profile-id="'.$profileID.'"
                                                                    data-completing-id="16"
                                                                    data-ref-num="'.$applicants->applicant_job_ref.'"
                                                                    href="javascript:;"
                                                                    class="dropdown-item complete_class" data-tw-toggle="modal" data-tw-target="#approve_modal">
                                                                    <i class="fas fa-forward text-success"></i>
                                                                <span class="ml-2"> Complete </span>
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                    }else{
                        $approval_btn = '<div class="flex justify-center items-center">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                                <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-slate-500"></i> </a>

                                            </div>
                                        </div>';
                    }

                }else{
                    $check_status = status_codes::where('id', 15)->first();
                    $status =  $check_status->name;
                    $status_class =  $check_status->class;
                    $status_stag =  $check_status->stag;

                    $approval_btn = '<div class="flex justify-center items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                        <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-slate-500"></i> </a>

                    </div>
                </div>';
                }

                // dd($applicants);
                $output .= '<tr>
                                <td>
                                    '.$applicantname.'
                                </td>

                                <td>
                                    '.$applicantPosition.'
                                </td>

                                <td>

                                    <div class="flex items-center">
                                    <div class="w-2 h-2 bg-'.$status_class.' rounded-full mr-3"></div>
                                            <span class="truncate">'.$status.'</span>

                                        <div class="ml-auto cursor-pointer tooltip" title="'.$status_stag.'">';

                                        // $get_panels = tblpanels::where('available_ref', $applicants->applicant_job_ref);

                                        $output .= '<a id="raterStatus"
                                                        data-job-ref="'.$applicants->applicant_job_ref.'"
                                                        data-applicant-id="'.$applicants->applicantID.'"
                                                        data-position-id="'.$applicants->positionID.'"
                                                        class="underline decoration-dotted underline-offset-4 text-primary dark:text-slate-400 cursor-pointer">
                                                rater
                                            </a>
                                            &nbsp; '.$_ratercount.'  /  '. $panels_count .'
                                        </div>
                                    </div>

                                </td>

                                <td>

                                    '.$approval_btn.'



                                </td>
                            </tr>';
            }

        }

        $output .= '</tbody></table>';

        echo $output;
    }

    public function rater_details(Request $request){
        $get_panelss = tblpanels::where('available_ref', $request->job_ref)->where('active', 1)->with('get_employee')->get();
        // dd($request->job_ref);
        if($get_panelss->count() > 0){
            $output ='';
            foreach($get_panelss as $panels){
                $panel_class = '';
                $panel_status = '';
                $panel_name = '';


            $check_rater = ratedAppcants_model::where('applicant_job_ref', $panels->available_ref)
                    ->where('applicantID', $request->applicant_id)
                    ->where('rater_agency_id', $panels->panel_id)->first();
                // DD($check_rater);

                    if($check_rater){
                        $panel_class = 'success';
                        $panel_status = '<i class="fa-solid fa-check"></i>';
                    }else{
                        $panel_class = 'danger';
                        $panel_status = '<i class="fa-solid fa-xmark"></i>';
                    }

                    $panel_id = $panels->panel_id;
                    $profileee = get_profile_image($panel_id);

                    // dd($panels->get_employee);

                    if($panels->get_employee){
                        $panel_name = $panels->get_employee->lastname.', '.$panels->get_employee->firstname.' '.$panels->get_employee->middlename;
                    }
                    // dd($panel_name);
                $output .= ' <div class="intro-x relative flex items-center mb-3">
                                <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Midone - HTML Admin Template" src="'.$profileee.'">
                                    </div>
                                </div>
                                <div class="box px-5 py-3 ml-4 flex-1">
                                    <div class="flex items-center">
                                        <div class="text-slate-600 dark:text-slate-500 block">'.$panel_name.'</div>
                                        <div class="text-xs text-slate-500 ml-auto text-'.$panel_class.'">'.$panel_status.'</div>
                                    </div>

                                </div>
                            </div>';
            }
            echo $output;

        }


    }

    public function printSummary($app_id, $ref_num, $short_listID, $rated_check_in_value ){
        // dd($app_id, $ref_num, $short_listID, $rated_check_in_value);
        $check_panels = '';

        $details = ratedAppcants_model::with(['get_applicant_profile', 'get_positionee', 'get_rater_profile'])
                                        ->where('applicantID', $app_id)
                                        ->where('applicant_listID', $short_listID)
                                        ->where('applicant_job_ref', $ref_num);
        $rated_applicant_length = $details->count();
        $detailed = $details->get();
        // dd($detailed);
        $details = $details->first();
        $critering = ratingtCriteria_model::with('get_competency')->where('position_id', $details->positionID)->where('active', 1);
        $criterias = $critering->get();

        // percent
        $marateSum = $critering->sum('maxrate');
        $marateCount =  $criterias->count();
        //get average
        $maxAverage = $marateSum/$marateCount;
        $maxPoints = '';

        if($rated_check_in_value != 0){
            $maxPoints =  $marateSum.'%';
        }else{
            $maxPoints =  $maxAverage;
        }


        // dd($maxAverage);

        $now = date('m/d/Y g:ia');
        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');

        $filename = 'Summary of Rating';

        // $long_BondPaper = array(0, 0, 612.00, 936.0);
        $system_image_header ='';
        $system_image_footer ='';

        if(system_settings()){
            $system_image_header = system_settings()->where('key','image_header')->first();
            $system_image_footer = system_settings()->where('key','image_footer')->first();
        }

        $pdf = PDF::loadView('ratingCriteria.print_blade.print_rated_summary',
                    compact('rated_check_in_value',
                        'filename',
                        'system_image_header',
                        'system_image_footer',
                        'current_date',
                        'details',
                        'detailed',
                        'criterias',
                        'check_panels',
                        'rated_applicant_length',
                        'critering',
                        'maxAverage',
                        'maxPoints'))
                        ->setPaper('legal','landscape');
        return $pdf->stream($filename . '.pdf');
    }


    public function approving_applicants(Request $request, $shortListID){
        // dd($request->all());
        $shortList =  tbl_shortlisted::where('id', $shortListID)->first();
        $update_stat = ['stat' => $request->approving_id];

        $max_score = ratingtCriteria_model::where('position_id', $request->position_id)->where('active', 1)->sum('maxrate');

        // dd($max_score);
        $from_rated = ratedAppcants_model::where('applicantID', $request->applicant_id)
                                        ->where('applicant_job_ref', $request->ref_num)
                                        ->where('applicant_listID', $shortListID);
        // dd( $request->applicant_id, $request->ref_num, $shortListID);
        // dd($from_rated);
        $average = 0;

        $sumofRate = $from_rated->sum('rate');

        $sumOf_rate = number_format($sumofRate);
        // dd($sumOf_rate);
        $sumofAverage = $from_rated->sum('average');
        $get_rated = $from_rated->get();
        $rator_count =  $get_rated->count();


        //Get Percent
        $maxOF_score = number_format($max_score);
        $max_to_length = $maxOF_score * $rator_count;
        $percent = $maxOF_score/100;

        $divissio_perce = ( $sumOf_rate/$max_to_length ) * 100;
        $t_percent = round((float) $divissio_perce * $percent );
        //Get Average
        $average =$sumofAverage/$rator_count;


        $saverated = new ratedDone_model;
        $saverated->applicant_id = $request->applicant_id;
        $saverated->applicant_job_ref = $request->ref_num;
        $saverated->shortList_id = $shortListID;
        $saverated->position_id = $request->position_id;
        $saverated->approved_by =  auth()->user()->employee;
        $saverated->status = 18;
        $saverated->average = $average;
        $saverated->percent = $t_percent;
        $saverated->remarks = $request->remarks;
        $saverated->save();

        $shortList->update( $update_stat);

        return response()->json(['status' => 200]);

    }


    //===== RATED APPLICANT -----//
    public function rated_applicant_page(){
        return view('ratingCriteria.ratedApplicant_page');
    }

    public function fetch_ratedApplicant(Request $request, $position_id, $stutus_id){
        // dd($request->all());
        $ratedApplicants = '';
        $output = '<table id="tbl_ratedApplicant" class="table table-report -mt-2 table-bordered">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap"> # </th>
                        <th class="text-center whitespace-nowrap"> Applicant Name </th>
                        <th class="text-center whitespace-nowrap"> Position Applied </th>
                        <th class="text-center whitespace-nowrap"> Rating Status </th>
                        <th class="text-center whitespace-nowrap"> Points </th>
                        <th class="text-center whitespace-nowrap"> Remarks </th>
                        <th class="text-center whitespace-nowrap"> Action </th>
                    </tr>
                </thead>
                <tbody>';

        $checkUser = User::where('id', auth()->user()->id)->first();
        // dd( $position_id);
        if($position_id == "undefined" || $position_id == "all"){
            if($stutus_id == "undefined" || $stutus_id == "all"){
                $ratedApplicants = ratedDone_model::with('get_applicant_profile', 'get_jof_info.get_Position')->where('active', 1)->get();
            }else{
                $ratedApplicants = ratedDone_model::with('get_applicant_profile', 'get_jof_info.get_Position')->where('status', $stutus_id)->where('active', 1)->get();
            }


                // $ratedApplicants = ratedAppcants_model::with(['get_applicant_profile', 'get_positionee', 'get_panels'])->where('rated_by', auth()->user()->id)->get();


        }else{
            if($stutus_id == "undefined" || $stutus_id == "all"){
                $ratedApplicants = ratedDone_model::with('get_applicant_profile', 'get_jof_info.get_Position')->where('active', 1)->where('position_id', $position_id)->get();
            }else{
                $ratedApplicants = ratedDone_model::with('get_applicant_profile', 'get_jof_info.get_Position')->where('active', 1)->where('position_id', $position_id)->where('status', $stutus_id)->get();
            }

        }
        // dd($ratedApplicants);
        $count = $ratedApplicants->count();
        $i = 1;
        if($count > 0){
            // $i += 1;
            foreach($ratedApplicants as $ratedApplicant){

                // dd($ratedApplicant);
                $name = '';
                $position = '';
                $button = '';
                $position_idd = '';
                $button_icon = '';
                $btn_class = '';
                $btn_title = '';
                $text_class = '';
                $lastname ='';

                if($ratedApplicant->get_applicant_profile){
                    $lastname =$ratedApplicant->get_applicant_profile->lastname;
                    $name = $ratedApplicant->get_applicant_profile->lastname. ', '.$ratedApplicant->get_applicant_profile->firstname.' '.$ratedApplicant->get_applicant_profile->mi;
                }else{
                    $name = 'No relation in profile';
                }
                if($ratedApplicant->get_jof_info){
                    $job_info = $ratedApplicant->get_jof_info;
                    if( $job_info->get_Position){
                        $position = $job_info->get_Position->emp_position;
                        $position_idd = $job_info->get_Position->id;
                    }else{
                        $position = 'no Position';

                    }

                }else{
                    $position = 'No relation in job-info';
                }



                // GET STATUS
                    $get_stat = status_codes::where('id', $ratedApplicant->status)->first();
                // END OF GET STATUS

                //GET Proceeding officer
                    $proceeding_officer = '';
                    $profile = tblemployee::where('agencyid', $ratedApplicant->final_proceed_by)->first();
                // dd($profile);
                    if($profile){
                        $proceeding_officer = $profile->firstname.' '.$profile->mi.' '.$profile->lastname.' '.$profile->extension;
                    }


                // BUTTUN VIEW
                        if($ratedApplicant->status == 18){

                            $button = '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-auto">
                                                <div class="dropdown-content">
                                                    <a id="'.$ratedApplicant->id.'"
                                                        data-position-id="'.$position_idd.'"
                                                        data-position-name="'.$position.'"
                                                        data-job-ref="'.$ratedApplicant->applicant_job_ref.'"
                                                        data-name="'.$name.'"
                                                        data-status="'.$get_stat->name.'"
                                                        data-recommend-by="'.$proceeding_officer.'"
                                                        data-applicant-id="'.$ratedApplicant->applicant_id.'"
                                                        class="dropdown-item proceed"
                                                        href="javascript:;">
                                                        <i class="fa-solid fa-thumbs-up text-success"></i>
                                                        <span class="ml-2"> Final List</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>';

                        }else if($ratedApplicant->status == 22){

                            $button = '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-slate-500"></i> </a>
                                            <div class="dropdown-menu w-40">

                                            </div>
                                        </div>';
                        }else if($ratedApplicant->status == 23){

                            $button = '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <div class="dropdown-content">
                                                <a  href="javascript:;"
                                                data-name="'.$name.'"
                                                    data-position-id="'.$position_idd.'"
                                                    data-applicant-id="'.$ratedApplicant->applicant_id.'"
                                                    data-shortlist-id="'.$ratedApplicant->shortList_id.'"
                                                    data-job-ref="'.$ratedApplicant->applicant_job_ref.'"
                                                    data-rated-id="'.$ratedApplicant->id.'"
                                                        class="dropdown-item text-success hired_class">
                                                        <i class="fa-solid fa-send-back text-success"></i>
                                                        <span class="ml-2"> Hire </span>
                                                    </a>

                                                    <a id="'.$ratedApplicant->id.'"
                                                        data-notify = "'.$ratedApplicant->notified.'"
                                                        href="javascript:;"
                                                        data-status = "'.$ratedApplicant->status.'"
                                                        class="dropdown-item text-danger disapprove_class">
                                                        <i class="fa-solid fa-send-back text-danger"></i>
                                                        <span class="ml-2"> Disapprove </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>';
                        }else if($ratedApplicant->status == 20){
                            $button = '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <div class="dropdown-content">

                                                    <a id="'.$ratedApplicant->id.'"
                                                        data-position-id="'.$position_idd.'"
                                                        data-applicant-id="'.$ratedApplicant->applicant_id.'"
                                                        href="javascript:;"
                                                        class="dropdown-item end_contruct">
                                                        <i class="fa-solid fa-send-back text-success"></i>
                                                        <span class="ml-2"> End Contruct </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>';
                        }else{
                            $button = '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <div class="dropdown-content">

                                                    <a id="'.$ratedApplicant->id.'"
                                                        data-position-id="'.$position_idd.'"
                                                        href="javascript:;"
                                                        class="dropdown-item _changeStat">
                                                        <i class="fa fa-exchange text-success" aria-hidden="true"></i>
                                                        <span class="ml-2"> Return as Rated </span>
                                                    </a>

                                                    <a id="'.$ratedApplicant->id.'"
                                                        href="javascript:;"
                                                        class="dropdown-item remove_applicant">
                                                        <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                                        <span class="ml-2"> Remove </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>';
                        }
                // END BUTTUN VIEW

                // GET REMARKS
                    //     $applicant_remark = '';

                    // if($ratedApplicant->status == 20 || $ratedApplicant->status == 23){

                    //     if($ratedApplicant->agency_head_note != null){
                    //         $applicant_remark = $ratedApplicant->agency_head_note;
                    //     }else{
                    //         $applicant_remark = 'The Head dont leave any Notes';
                    //     }
                    // }else{
                    //     $applicant_remark = $ratedApplicant->remarks;
                    // }
                    // $applicant_remark = $ratedApplicant->agency_head_note;


                // GET THE AVERAGE
                    $average_rate = '';
                    $percent_rate = '';


                    // $rated_check_in_value = $request->rated_check_in_value;
                    $points = '';
                    // GET POINTS
                        if($request->rated_check_in_value == 1){
                            $points = $ratedApplicant->percent.'%';
                        }else{
                            $points = $ratedApplicant->average;
                        }


                        $applicant_rates = ratedAppcants_model::where('applicantID', $ratedApplicant->applicant_id)
                                                                ->where('applicant_listID', $ratedApplicant->shortList_id)
                                                                ->where('applicant_job_ref', $ratedApplicant->applicant_job_ref)->get();
                        $sumPercent = ratedAppcants_model::where('applicantID', $ratedApplicant->applicant_id)
                                                                ->where('applicant_listID', $ratedApplicant->shortList_id)
                                                                ->where('applicant_job_ref', $ratedApplicant->applicant_job_ref)->sum('rate');
                        $percent_sum = number_format($sumPercent);

                        $sumAverage = ratedAppcants_model::where('applicantID', $ratedApplicant->applicant_id)
                                                                ->where('applicant_listID', $ratedApplicant->shortList_id)
                                                                ->where('applicant_job_ref', $ratedApplicant->applicant_job_ref)->sum('average');
                        $count_rator = $applicant_rates->count();
                        // dd($sumPercent );

                        foreach($applicant_rates as $applicant_rates){
                            // dd($total_applicant_rate);
                            $sumfoCritering = ratingtCriteria_model::where('position_id', $applicant_rates->positionID)->where('active', 1)->sum('maxrate');
                            // $critering = ratingtCriteria_model::where('position_id', $applicant_rates->positionID)->where('active', 1)->get();
                            // $count_criteria = $critering->count();

                            $max_to_length = $sumfoCritering * $count_rator;
                            // dd($max_to_length);
                            $sumPercent_div_maxLength = ($percent_sum/$max_to_length) * 100;
                            // dd($sumPercent_div_maxLength);


                        }

                        // dd($count_rator);
                    //average
                    // dd($count_rator);
                        // $average_rate = $sumAverage/$count_rator;

                        // dd($average_rate);
                    //percent
                        // $percent_rate = $sumPercent_div_maxLength;
                // END OF GET AVERAGE

                // TABLE ROW
                    $output .= '<tr>
                                    <td>
                                                 '.$i++.'
                                    </td>

                                    <td>
                                                '.$name.'
                                    </td>

                                    <td>
                                                '.$position.'
                                    </td>

                                    <td>
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-'.$get_stat->class.' rounded-full mr-3"></div>
                                                <span class="truncate">'.$get_stat->name.'</span>
                                            </div>
                                    </td>

                                    <td>

                                                '.$points.'

                                    </td>

                                    <td>

                                                '.$ratedApplicant->remarks.'

                                    </td>

                                    <td >

                                    <div class="flex justify-center items-center">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown">

                                                    <a id="'.$ratedApplicant->id.'"
                                                        data-position-id="'.$position_idd.'"
                                                        data-position-name="'.$position.'"
                                                        data-job-ref="'.$ratedApplicant->applicant_job_ref.'"
                                                        data-name="'.$name.'"
                                                        data-status="'.$get_stat->name.'"
                                                        data-recommend-by="'.$proceeding_officer.'"
                                                        data-applicant-id="'.$ratedApplicant->applicant_id.'"
                                                        class="flex justify-center items-center text-primary"
                                                            href="/rating/applicant-information-page/'.$ratedApplicant->id.'/'.$request->rated_check_in_value.'">
                                                            <i class="fa fa-info-circle text-success" aria-hidden="true"></i>
                                                    </a>



                                                </div>

                                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Print">
                                                    <a class="flex justify-center items-center text-primary"
                                                        target="_blank" href="/rating/print-summary/'.$ratedApplicant->applicant_id.'/'.$ratedApplicant->applicant_job_ref.'/'.$ratedApplicant->shortList_id.'/'.$request->rated_check_in_value.'">
                                                        <i class="fa fa-print" aria-hidden="true"></i>
                                                    </a>

                                                </div>';

                                                $check_hr = tbljob_info::where('jobref_no', $ratedApplicant->applicant_job_ref)->first();
                                                if( $check_hr->email_through === auth()->user()->employee){
                                                    $output .= ''.$button.'';
                                                }else{
                                                    $output .=  '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-slate-500"></i> </a>
                                                            <div class="dropdown-menu w-auto">

                                                            </div>
                                                        </div>';
                                                }

                                            $output .= '</div>



                                </td>

               </tr>';
                // END OF TABLE ROW
            }
        }

        $output .= '</tbody></table>';

        echo $output;
    }

    public function applicant_info_page($id, $rated_check_in_value){
        // dd($id, $rated_check_in_value);
        $applicant = ratedDone_model::with(['get_applicant_profile', 'get_position', 'get_status', 'get_approve_officer', 'get_proceeding_officer','get_selection_officer'])->where('id', $id)->first();
        // dd($applicant);
        $pointsss = '';
        $firstNote = '';
        $secondNote = '';
        $applicant_id = '';
        $applicant_name = '';
        $applicant_email = '';
        $applicant_mobile = '';
        $applicant_telephone = '';
        $applicant_position = '';
        $applicant_status = '';
        $status_class = '';
        $status_id = '';
        $approve_by = '';
        $proceeded_by = '';
        $selected_by = '';
        $average = '';
        $raters = '';
        $applied_position = '';
        if($applicant){
            $first_note = $applicant->remarks;
            $second_note = $applicant->agency_head_note;
            $profile = $applicant->get_applicant_profile;
            $position = $applicant->get_position;
            $status = $applicant->get_status;
            $approve_profile = $applicant->get_approve_officer;
            $proceed = $applicant->get_proceeding_officer;

            $job_ref = $applicant->applicant_job_ref;
            $short_listID = $applicant->shortList_id;
            $average = $applicant->average;
            $percent = $applicant->percent.'%';
            $approved_by = $applicant->approved_by;
            $recomended_by = $applicant->final_proceed_by;
            $select_by = $applicant->get_selection_officer;
            $applicant_id = $applicant->applicant_id;
            if($status){
                $applicant_status = $status->name;
                $status_class = $status->class;
                $status_id = $status->id;
            }
            if($profile){
                $applicant_name =  $profile->firstname.' '.$profile->mi.' '.$profile->lastname.' '.$profile->extension;

                $_email        = $profile->email;
                $_mobile       = $profile->mobile_number;
                $_telephone    = $profile->telephone;

                if($_email == null ){
                    $applicant_email        = 'N/A';
                }else{
                    $applicant_email        = $_email;
                }

                if($_mobile == null){
                    $applicant_mobile       = 'N/A';
                }else{
                    $applicant_mobile       = $_mobile;
                }

                if($_mobile == null){
                    $applicant_telephone    = 'N/A';
                }else{
                    $applicant_telephone    = $_telephone;
                }
            }else{
                $applicant_name  = 'No Profile';
                $applicant_email = 'N/A';


            }
            if($position){
                $applied_position = $position->emp_position;
                if( $status_id !=20){
                    $applicant_position = 'Applicant';
                }else{
                    $applicant_position = $position->emp_position;
                }

            }else{
                $applicant_position = 'No Position';
            }
            if($approve_profile){

                    $approve_by = $approve_profile->firstname.' '.$approve_profile->mi.' '.$approve_profile->lastname.' '.$approve_profile->extension;


            }else{
                $approve_by = 'No Profile';
            }

            if($proceed){

                    $proceeded_by = $proceed->firstname.' '.$proceed->mi.' '.$proceed->lastname.' '.$proceed->extension;

            }else{
                $proceeded_by = 'Not yet Proceeded';
            }
            if($select_by){

                $selected_by = $select_by->firstname.' '.$select_by->mi.' '.$select_by->lastname.' '.$select_by->extension;

            }else{
                $selected_by = 'Not Yet Selected';
            }
            if( $first_note != ''){
                $firstNote =  $first_note;
            }else{
                $firstNote = 'Not Leaving Any Note';
            }if( $second_note != ''){
                $secondNote =  $second_note;
            }else{
                $secondNote = 'N/A';
            }
            if($rated_check_in_value != 0){
                $pointsss =  $percent;
            }else{
                $pointsss =  $average;
            }

           $raters =  ratedAppcants_model::with(['get_rater_prof', 'get_rater_position.get_position'])
                        ->where('applicant_job_ref',  $applicant->applicant_job_ref)
                        ->where('applicant_listID',  $applicant->shortList_id)
                        ->where('applicantID',  $applicant->applicant_id)
                        ->where('active', 1)->get();
            // dd( $raters);
        }

        return view('ratingCriteria.applicantinformation_page',
                compact(['applicant_name',
                        'applied_position',
                        'applicant_position',
                        'applicant_id',
                        'job_ref',
                        'short_listID',
                        'applicant_email',
                        'applicant_mobile',
                        'applicant_telephone',
                        'proceeded_by',
                        'selected_by',
                        'approve_by',
                        'applicant_status',
                        'status_class',
                        'average',
                        'raters',
                        'firstNote',
                        'secondNote',
                        'pointsss',
                        'rated_check_in_value',
                    ]));
    }

    public function rater_criteria_points(Request $request){
        // dd($request->all());

        $remarks = '';
        $remarking = ratedAppcants_model::where('applicantID', $request->applicant_id)->where('applicant_job_ref', $request->job_ref)->where('applicant_listID', $request->short_list)->where('rater_agency_id', $request->rater_id)->first();

        $remarks = $remarking->remarks;
        $ratedCriterias = ratedCriteria_model::with('get_criteri.get_competency')->where('applicant_id', $request->applicant_id)->where('applicant_job_ref', $request->job_ref)->where('short_listID', $request->short_list)->where('rater_ag_id', $request->rater_id)->get();
        // dd($ratedCriteria);
        $output = '<table class="table table-border table-hover">
                        <thead>
                            <th style="width: 70%">Criteria/s</th>
                            <th>Max Points</th>
                            <th>Total Points</th>
                        </thead>
                        <body>';
        if($ratedCriterias->count() > 0){

            foreach ($ratedCriterias as $ratedCriteria) {
                $criteria_id = '';
                $criteria_name = '';
                $max_criteria = '';
                $criteria_Points = '';
                $point_ex = '';
                if($ratedCriteria){
                    $criterias = $ratedCriteria->get_criteri;
                    // dd($criterias);
                    $criteria_Points = $ratedCriteria->rated;
                    if($criterias){

                        $criteria_id =  $criterias->id;
                        $max_criteria =  $criterias->maxrate;

                        $criteria_competency =  $criterias->competency_id;
                            if($criteria_competency == null){
                                $criteria_name = $criterias->creteria;

                            }else{
                                $competency =  $criterias->get_competency;
                                // dd( $competency);
                                if($competency){
                                    $competency_name = $competency->name;
                                    if( $competency_name == null){
                                        $criteria_name = 'no competency';
                                    }else{

                                        $criteria_name = $competency_name;
                                    }


                                }else{
                                    $criteria_name =' Competency is no nore existed';
                                }
                            }

                            if($request->check_value !=0){
                                $point_ex = '%';
                            }else{
                                $point_ex = '';
                            }

                    }
                }
            // dd($criteria_Points);
                $output .= '<tr   id="'.$criteria_id.'"
                            data-criteria-name="'.$criteria_name.'"
                            data-rater-agency-id="'.$request->rater_id.'"
                            class="cursor-pointer tr_criteria">
                                <td>
                                    '.$criteria_name.'
                                </td>
                                <td class="text-center">
                                        '.$max_criteria.''.$point_ex.'
                                </td>


                                <td class="text-center">
                                        '.$criteria_Points.''.$point_ex.'
                                </td>
                            </tr>';
            }

        }

        $output .='</body></table>';
        return response()->json(['criteria' => $output, 'remark' => $remarks]);

    }

    public function rater_aria_points(Request $request){
        // dd($request->all());
        $rater_areaPoints = '<table id="raterArea_points_tbl" class="table table-bordered form-control">
                                <thead>
                                        <th style = "width: 70%">Area</th>
                                        <th>Max Points</th>
                                        <th>Score Points</th>
                                </thead>
                                <tbody>';

                $areas = areas_model::where('criteria_id', $request->crit_id)->where('active', 1)->get();

                // dd( $area);
                if($areas->count() > 0){

                    foreach($areas as $area){
                        if($area){

                            $max_points = '';
                            if($area->rate != null){
                                $max_points = $area->rate;
                            }else{
                                $max_points = 'Not Set';
                            }

                            //GET RATE
                            $points = '';
                            $area_rate = ratedArea_model::where('areas_id',  $area->id)
                                        ->where('applicant_id', $request->_applicant_id)
                                        ->where('job_ref', $request->_job_ref)
                                        ->where('criteria_id', $request->crit_id)
                                        ->where('rated_by', $request->rater_agency_id)
                                        ->where('short_list_id', $request->_short_listID)->first();
                            // dd($area_rate);
                            if($area_rate){
                                $rate = $area_rate->rate;
                                if($rate != null){
                                    $points = $rate;
                                }else{
                                    $points = 'No Points';
                                }
                            }else{
                                $points = 'No Points';
                            }

                            $rater_areaPoints .= '<tr>
                                                    <td>'.$area->area.'</td>
                                                    <td>'.$max_points.'</td>
                                                    <td>'.$points.'</td>
                                                </tr>';
                        }


                                            }
                }else{
                    $rater_areaPoints .= '<tr>
                                                <td colspan="3" class="text-center">No Area Save from this Criteria</td>

                                            </tr>';
                }



        $rater_areaPoints .= '</tbody></tbody>';

                echo $rater_areaPoints;
    }

    //Summary Print
    public function interview_summary_Print(Request $request){
        // dd($request->all());
        $get_interviewed_applicant = '';

        $now = date('m/d/Y g:ia');
        $status_text = '';
        $from = $request->interview_from;
        $to = $request->interview_to;
        $to = $request->interview_to;
        $toggleCheck_value =  $request->toggleCheck_value;

        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');

        $filename ='Interviewed Applicant '. $request->from.'/'.$request->to. ' pdf';
        //SayMeow169
        if($from &&  $to){
            $date_from = new Carbon($from);
            $date_to = new Carbon($to);
            if($request->interview_position  != 'all'){

                if($request->interview_status != 'all'){
                    // dd('position dili all / status dili all');
                    $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile', 'get_position', 'get_status')->whereBetween('created_at', [$date_from->format('Y-m-d')." 00:00:00", $date_to->format('Y-m-d')." 23:59:59"])->where('status',$request->interview_status)->where('position_id',$request->interview_position)->where('active',1)->get();
                }else{
                    // dd('position dili all / status all');
                    $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile', 'get_position', 'get_status')->whereBetween('created_at', [$date_from->format('Y-m-d')." 00:00:00", $date_to->format('Y-m-d')." 23:59:59"])->where('position_id',$request->interview_position)->where('active',1)->get();
                }

                // $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile', 'get_position', 'get_status')->whereBetween('created_at', [$dateS->format('Y-m-d')." 00:00:00", $dateE->format('Y-m-d')." 23:59:59"])->where('status',$request->interview_status)->where('active',1)->get();

                // $get_documents = doc_file::with('get_track_sent_to','get_track_received_by')->where('created_by',Auth::user()->employee)->get();
            }else{

                if($request->interview_status != 'all'){
                    // dd('position is all / status dili all');
                    $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile', 'get_position', 'get_status')->whereBetween('created_at', [$date_from->format('Y-m-d')." 00:00:00", $date_to->format('Y-m-d')." 23:59:59"])->where('status',$request->interview_status)->where('active',1)->get();
                }else{
                    // dd('position is all/ status all');
                    $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile', 'get_position', 'get_status')->whereBetween('created_at', [$date_from->format('Y-m-d')." 00:00:00", $date_to->format('Y-m-d')." 23:59:59"])->where('active',1)->get();
                    // dd($get_interviewed_applicant);
                }



                // $get_documents = doc_file::with('get_track_sent_to','get_track_received_by')->where('created_by',Auth::user()->employee)->get();
            }
        }
        else{

            if($request->interview_position != 'all'){

                if($request->interview_status != 'all'){
                    // dd('position dili all / status dili all');
                    $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile','get_position', 'get_status')->where('status',$request->interview_status)->where('position_id',$request->interview_position)->where('active',1)->get();
                }else{
                    // dd('position dili all / status all');
                    $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile','get_position', 'get_status')->where('position_id',$request->interview_position)->where('active',1)->get();
                }


            }else{
                if($request->interview_status != 'all'){
                     // dd('position all / status dili all');
                    $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile','get_position', 'get_status')->where('status',$request->interview_status)->where('active',1)->get();
                }else{
                     // dd('position all / status all');
                    $get_interviewed_applicant = ratedDone_model::with('get_applicant_profile','get_position', 'get_status')->where('active',1)->get();
                }


            }
        }

         $system_image_header ='';
         $system_image_footer ='';

         if(system_settings()){
             $system_image_header = system_settings()->where('key','image_header_landscape')->first();
             $system_image_footer = system_settings()->where('key','image_footer_landscape')->first();
         }

         $pdf = PDF::loadView('ratingCriteria.print_blade.summary_printAll',compact('get_interviewed_applicant',
                                                                            'system_image_header',
                                                                            'system_image_footer',
                                                                            'filename',
                                                                            'current_date',
                                                                            'status_text',
                                                                            'toggleCheck_value',
                                                                            'from',
                                                                            'to'))->setPaper('a4', 'landscape');

         return $pdf->stream($filename . '.pdf');

    }

    public function hireApplicant(Request $request, $shortList_id){
        // dd($request->all(), $shortList_id);
        // dd($request->applicant_id);

        $salary_amount = '';
        $step_id = '';
        $tranch_id = '';
        $position_id = '';
        $Position_name = '';


        $position_info = tbljob_info::with('get_Position')->where('jobref_no', $request->ref_num)->first();
        if($position_info){
            $salary_amount = $position_info->salary;
            $step_id = $position_info->step;
            $tranch_id = $position_info->sg;
            $get_postition =  $position_info->get_Position;
            if($get_postition){
                $position_id =  $get_postition->id;
                $Position_name = $get_postition->emp_position;
            }
        }



        $check_agency = agency_employees::where('user_id', $request->applicant_id)->where('active', 1);
        $agency_id = '';
        if($check_agency->exists()){

            $ca = $check_agency->first();
            $agency_id =  $ca->agency_id;

            $update_ca = [
                            'end_date' => Carbon::now(),
                            'active' => 0,
                ];
            $check_agency->update($update_ca);


        }else{

            $agency_id = generate_employee_id(tblemployee::count());

        }

        $saverated = new agency_employees;
        $saverated->user_id = $request->applicant_id;
        $saverated->profile_id = '';
        $saverated->agency_id = $agency_id;
        $saverated->salary_amount = $salary_amount;
        $saverated->step_id = $step_id;
        $saverated->tranch_id = $tranch_id;
        $saverated->designation_id = '';
        $saverated->position_id = $position_id;
        $saverated->start_date =  Carbon::now();
        $saverated->created_by   = auth()->user()->employee;
        $saverated->save();

        tbl_shortlisted::where('id', $shortList_id)->update( ['stat' => 18]);
        // $update_stat = ['stat' => 18];
        // $shortList->update( $update_stat);

        $shortList =  ratedDone_model::where('id', $request->rated_id)->first();
        $update_stat = ['status' => 20];
        $shortList->update( $update_stat);

        // SAVE NOTIFICATION
            $notification = hiredNotification::where('id', 1)->first();
            $subject =  $notification->subject;
            $subject_id =  $request->ref_num;
            $notif_content =  $notification->notification .' '.$Position_name.'. '. $notification->notif_extenssion;
            $target_id =  $request->applicant_id;
            $target_type =  "user";
            $sender_type =  "user";
            $sender_id =  auth()->user()->employee;
            createNotification($subject,$subject_id,$sender_type,$sender_id,$target_id,$target_type,$notif_content);
        // END OF SAVING NOTIFICATION

        return response()->json(['status' => 200]);




    }

    public function disapproveApplicant($rated_id){
        $rated =  ratedDone_model::where('id', $rated_id)->first();

        // dd($_notify);


        $update_rated = ['status' => 12];
        $rated->update($update_rated);

        return response()->json(['status' => 200]);
    }

    public function changeStatus($rated_id, $position_ids){
        $rated =  ratedDone_model::where('id', $rated_id)->first();

        $update_rated = ['status' => 18];
        $rated->update($update_rated);

        return response()->json(['status' => 200]);
    }

    public function endContruct(Request $request){

        $rated =  ratedDone_model::where('id', $request->ratess_id)->first();

        $update_rated = ['status' => 21];
        $rated->update($update_rated);

        $check_agency = agency_employees::where('user_id', $request->applicant_id)->where('active', 1);

            $update_ca = [
                            'end_date' => Carbon::now(),
                            'active' => 0,
                ];
            $check_agency->update($update_ca);

        return response()->json(['status' => 200]);



    }

    public function final_proceed_Applicant($rated_doneID){
        $rated_applicant = ratedDone_model::where('id', $rated_doneID);
        $update_rated = [
                        'status' => 22,
                        'final_proceed_by' => auth()->user()->employee,
                        ];
        $rated_applicant->update($update_rated);
        return response()->json(['status' => 200]);
    }

    public function notifyApplicant(Request $request){
            // dd($request->all());
        // $ratedApplicant =
        $rated = ratedDone_model::where('id', $request->rated_id)->first();
        $notify = $rated->notified;

        $rated->update(['pres_interview_date' => $request->date, 'notified' => $notify+1]);
        // SAVE NOTIFICATION
        $date =  date("M-d-Y", strtotime($request->date));

        $notification = hiredNotification::where('id', 2)->first();
        $subject =  $notification->subject;
        $subject_id =  $request->job_ref;
        $notif_content =  $notification->notification .' '.$date.' '.$notification->notif_extenssion;
        $target_id =  $request->applicant_id;
        $target_type =  "user";
        $sender_type =  "user";
        $sender_id =  auth()->user()->employee;
        createNotification($subject,$subject_id,$sender_type,$sender_id,$target_id,$target_type,$notif_content);
        // END OF SAVING NOTIFICATION

        return response()->json(['status' => 200]);
    }

    public function remove_Applicant($rated_id){

        ratedDone_model::where('id', $rated_id)->update(['active' => 0]);


        return response()->json(['status' => 200]);
    }

    //Final Listed
    public function final_listed_Applicant_page(){
        return view('ratingCriteria.select_Applicant_page');
    }

    public function fetched_selectApplicant($position_id){

        $available_position = '';
        $output = '<table id="select_Applicant_tbl" class="table table-report -mt-2 table-bordered">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap"> # </th>
                        <th class="text-center whitespace-nowrap"> Job-Info </th>
                        <th class="text-center whitespace-nowrap"> Position </th>
                        <th class="text-center whitespace-nowrap"> Listed </th>
                    </tr>
                </thead>
                <tbody>';


        $checkUser = User::where('id', auth()->user()->id)->first();


        if($position_id == "undefined" || $position_id == "all"){

            $available_position  = tbljob_info::with('get_Position')->whereHas('get_rated_done')->where('active', 1)->get();

                // $ratedApplicants = ratedDone_model::with('get_applicant_profile', 'get_jof_info.get_Position')->where('status', 22)->orderBy('average', 'desc')->get();

                // $ratedApplicants = ratedAppcants_model::with(['get_applicant_profile', 'get_positionee', 'get_panels'])->where('rated_by', auth()->user()->id)->get();

        }else{

            $available_position  = tbljob_info::with('get_Position')->whereHas('get_rated_done')->where('active', 1)->where('pos_title', $position_id)->get();
            // $ratedApplicants = ratedDone_model::with('get_applicant_profile', 'get_jof_info.get_Position')->where('position_id', $position_id)->where('status', 22)->orderBy('average', 'desc')->get();
        }
        // dd($ratedApplicants);
        $count = $available_position->count();
        $i = 1;
        if($count > 0){
            // $i += 1;
            foreach($available_position as $ratedApplicant){

               $rankin_count =  ratedDone_model::where('applicant_job_ref', $ratedApplicant->jobref_no)->where('active', 1)->where('status', 22)->orWhere('status', 23)->orWhere('status', 20)->count();
               $rated_done =  ratedDone_model::where('applicant_job_ref', $ratedApplicant->jobref_no)->where('active', 1)->where('status', 22)->orWhere('status', 23)->orWhere('status', 20)->first();
                //   dd($rankin_count);
                if($rated_done){
                    $count_listed = '';

                    if($rankin_count > 0){
                        $count_listed = $rankin_count;
                    }else{
                        $count_listed = '';
                    }


                    $position_name = '';
                    if($ratedApplicant->get_Position){
                        $var_position = $ratedApplicant->get_Position;
                        $position_name = $var_position-> emp_position;
                    }
                    // $name = '';
                    // $position = '';
                    // $button = '';
                    // $position_idd = '';
                    // $button_icon = '';
                    // $btn_class = '';
                    // $btn_title = '';

                    // $lastname ='';
                    // if($ratedApplicant->get_applicant_profile){
                    //     $lastname =$ratedApplicant->get_applicant_profile->lastname;
                    //     $name = $ratedApplicant->get_applicant_profile->lastname. ', '.$ratedApplicant->get_applicant_profile->firstname.' '.$ratedApplicant->get_applicant_profile->mi;
                    // }else{
                    //     $name = 'No relation in profile';
                    // }
                    // if($ratedApplicant->get_jof_info){
                    //     $job_info = $ratedApplicant->get_jof_info;
                    //     if( $job_info->get_Position){
                    //         $position = $job_info->get_Position->emp_position;
                    //         $position_idd = $job_info->get_Position->id;
                    //     }else{
                    //         $position = 'no Position';
                    //     }

                    // }else{
                    //     $position = 'No relation in job-info';
                    // }
                    // dd($ratedApplicant->pres_interview_date);
                    // $interview_date = '';
                    // $sched_class = '';
                    // if($ratedApplicant->pres_interview_date == null){
                    //     // $text_class = 'slate-500';
                    //     $sched_class = 'text-slate-500 text-xs';
                    //     $interview_date = 'Schedule Not Set';
                    // }else{
                    //     // $text_class = 'primary';
                    //     $date =  date("M-d-Y", strtotime($ratedApplicant->pres_interview_date));
                    //     $sched_class = '';
                    //     $interview_date = $date;
                    // }
                    //Set Bell Notify Tittle
                    // $notify_tittle = '';
                    // $text_class = '';
                    // if($ratedApplicant->notified != 0){
                    //     $notify_tittle = 'Already Notified';
                    //     $text_class = 'primary';
                    // }else{
                    //     $notify_tittle = 'Notified Applicant';
                    //     $text_class = 'slate-500';
                    // }

                    // GET THE AVERAGE
                        $average_rate = '';
                        $percent_rate = '';



                            $applicant_rates = ratedAppcants_model::where('applicantID', $ratedApplicant->applicant_id)
                                                                    ->where('applicant_listID', $ratedApplicant->shortList_id)
                                                                    ->where('applicant_job_ref', $ratedApplicant->applicant_job_ref)->get();
                            $sumPercent = ratedAppcants_model::where('applicantID', $ratedApplicant->applicant_id)
                                                                    ->where('applicant_listID', $ratedApplicant->shortList_id)
                                                                    ->where('applicant_job_ref', $ratedApplicant->applicant_job_ref)->sum('rate');
                            $percent_sum = number_format($sumPercent);

                            $sumAverage = ratedAppcants_model::where('applicantID', $ratedApplicant->applicant_id)
                                                                    ->where('applicant_listID', $ratedApplicant->shortList_id)
                                                                    ->where('applicant_job_ref', $ratedApplicant->applicant_job_ref)->sum('average');
                            $count_rator = $applicant_rates->count();
                            // dd($sumPercent );

                            foreach($applicant_rates as $applicant_rates){
                                // dd($total_applicant_rate);
                                $sumfoCritering = ratingtCriteria_model::where('position_id', $applicant_rates->positionID)->where('active', 1)->sum('maxrate');
                                // $critering = ratingtCriteria_model::where('position_id', $applicant_rates->positionID)->where('active', 1)->get();
                                // $count_criteria = $critering->count();

                                $max_to_length = $sumfoCritering * $count_rator;
                                // dd($max_to_length);
                                $sumPercent_div_maxLength = ($percent_sum/$max_to_length) * 100;
                                // dd($sumPercent_div_maxLength);


                            }

                        //average
                            // $average_rate = $sumAverage/$count_rator;
                        //percent
                            // $percent_rate = $sumPercent_div_maxLength;
                    // END OF GET AVERAGE

                    // GET STATUS
                        // $get_stat = status_codes::where('id', $ratedApplicant->status)->first();
                    // END OF GET STATUS

                    //GET RECOMEND
                            // $proceeding_officer = '';
                            // $profile = employee::where('agencyid', $ratedApplicant->final_proceed_by)->first();
                            // // dd($profile);
                            // if($profile){
                            //     $proceeding_officer = $profile->firstname.' '.$profile->mi.' '.$profile->lastname.' '.$profile->extension;
                            // }



                    // TABLE ROW
                    // dd($count_listed);
                    $output .= '<tr>
                                    <td>
                                                # '.$i++.'
                                    </td>

                                    <td>
                                                '.$ratedApplicant->jobref_no.'
                                    </td>

                                    <td>
                                                '.$position_name.'
                                    </td>

                                    <td>

                                    <div class="flex justify-center items-center">


                                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in">
                                                <a id="'.$rated_done->id.'"
                                                        data-job-ref="'.$ratedApplicant->jobref_no.'"
                                                        data-position-name="'.$position_name.'"
                                                        href="javascript:;"
                                                        class="listed_countClass"
                                                        data-tw-toggle="modal" data-tw-target="#listed_modal">
                                                    '.$count_listed.'
                                                </a>
                                                </div>

                                    </div>

                                    </td>


                    </tr>';
                    // END OF TABLE ROW
                }
            }
        }

            $output .= '</tbody></table>';

            echo $output;

    }

    public function listed_modal_Applicant($job_ref){

        $output = '<table id="listed_tbl" class="table table-report -mt-2 table-bordered">
                        <thead>
                        <th class="whitespace-nowrap">Rank</th>
                        <th class="whitespace-nowrap">Applicant</th>
                        <th class="whitespace-nowrap">Points</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Interview Date</th>
                        <th class="whitespace-nowrap">Action</th>
                    </thead>

                    <tbody>';

                $ratedApplicants = ratedDone_model::with('get_applicant_profile', 'get_proceeding_officer')->where('applicant_job_ref', $job_ref)->where('status', 22)->orWhere('status', 23)->orWhere('status', 20)->where('active', 1)->orderBy('average', 'desc')->get();

        // dd($ratedApplicants);
        $count = $ratedApplicants->count();
        $i = 1;
        if($count > 0){
            // $i += 1;
            foreach($ratedApplicants as $ratedApplicant){

            //   dd($rankin_count);
              $count_listed = '';
              $applicant_name = '';
              $points = '';
              $position_name = '';
              if($ratedApplicant->get_Position){
                $var_position = $ratedApplicant->get_Position;
                $position_name = $var_position-> emp_position;
              }



              if($ratedApplicant->get_applicant_profile){
                $var_applicant = $ratedApplicant->get_applicant_profile;
                // dd( $var_applicant);
                $applicant_name = $var_applicant->firstname.' '.$var_applicant->mi.' '.$var_applicant->lastname.' '.$var_applicant->extension;
              }

                $interview_date = '';
                $sched_class = '';
                if($ratedApplicant->pres_interview_date == null){
                    // $text_class = 'slate-500';
                    $sched_class = 'text-slate-500 text-xs';
                    $interview_date = 'Schedule Not Set';
                }else{
                    // $text_class = 'primary';
                    $date =  date("M-d-Y", strtotime($ratedApplicant->pres_interview_date));
                    $sched_class = '';
                    $interview_date = $date;
                }

                $notifyClass = '';
                if($ratedApplicant->notified != 0){
                    $notifyClass = 'primary';
                }else{
                    $notifyClass = 'slate-500';
                }

                //Get Status
                $status = status_codes::where('id', $ratedApplicant->status)->first();
                $select_text = '';
                $select_icon = '';
                if($ratedApplicant->status == 22){
                    $select_text = 'Select';
                    $select_icon = '<i class="fa-regular fa-square"></i>';
                }else{
                    $select_text = 'Selected';
                    $select_icon = '<i class="far fa-check-square"></i>';
                }
                $proceeded_by = '';
                if($ratedApplicant->get_proceeding_officer){

                    $proceed = $ratedApplicant->get_proceeding_officer;
                    $proceeded_by = $proceed->firstname.' '.$proceed->mi.' '.$proceed->lastname.' '.$proceed->extension;
                }
                // TABLE ROW
                    $output .= '<tr>
                                    <td>

                                        <div class="flex justify-center items-center">


                                            <div class="w-6 h-6 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in">
                                                <a>
                                                    '.$i++.'
                                                </a>
                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                            '.$applicant_name.'
                                    </td>

                                    <td>
                                                '.$ratedApplicant->average.'
                                    </td>

                                    <td>

                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-'.$status->class.' rounded-full mr-3"></div>
                                                <span class="truncate">'.$status->name.'</span>
                                            </div>

                                    </td>

                                    <td class="'.$sched_class.'">
                                                '.$interview_date.'
                                    </td>

                                        <td>
                                            <div class="flex justify-center items-center">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown">

                                                    <a id="'.$ratedApplicant->id.'"
                                                        data-position-id="'.$ratedApplicant->position_id.'"
                                                        data-job-ref="'.$ratedApplicant->applicant_job_ref.'"
                                                        data-name="'.$applicant_name.'"
                                                        data-status="'.$status->name.'"
                                                        data-proceeded-by="'.$proceeded_by.'"
                                                        data-applicant-id="'.$ratedApplicant->applicant_id.'"
                                                        class="flex justify-center items-center text-primary notify_applicant"
                                                            href="javascript:;">
                                                            <i class="fa fa-bell text-'.$notifyClass.'"></i>
                                                    </a>



                                                </div>

                                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                                    <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                                    <div class="dropdown-menu w-auto">
                                                        <div class="dropdown-content">
                                                            <a id="'.$ratedApplicant->id.'"
                                                            data-aplicant-profile="'.get_profile_image($ratedApplicant->applicant_id).'"
                                                                data-name="'.$applicant_name.'"
                                                                data-job-ref="'.$ratedApplicant->applicant_job_ref.'"
                                                                data-remarks="'.$ratedApplicant->remarks.'"
                                                                class="dropdown-item text-success listed_pass"
                                                                href="javascript:;"
                                                                data-tw-toggle="modal" data-tw-target="#selection_modal">
                                                               '. $select_icon.'
                                                                <span class="ml-2">  '.$select_text.' </span>
                                                            </a>

                                                            <a id="'.$ratedApplicant->id.'"
                                                                data-job-ref="'.$ratedApplicant->applicant_job_ref.'"
                                                                data-name="'.$applicant_name.'"
                                                                class="dropdown-item text-danger listed_return"
                                                                href="javascript:;">
                                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                                                <span class="ml-2">  Return </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                    </td>


                                </tr>';
                // END OF TABLE ROW
            }
        }

        $output .= '</tbody></table>';

        echo $output;
    }

    public function select_Applicant(Request $request, $id){

        ratedDone_model::where('id', $id)->update(['status' => 23, 'agency_head_note' => $request->pres_notes, 'selected_by' => auth()->user()->employee]);

        return response()->json(['status' => 200]);
    }

    public function return_Applicant($id){

        ratedDone_model::where('id', $id)->update(['status' => 4, 'selected_by' => auth()->user()->employee]);
        return response()->json(['status' => 200]);
    }



}
