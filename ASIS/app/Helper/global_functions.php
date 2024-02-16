<?php


use App\Models\ASIS_Models\agency\agency_employees;
use App\Models\ASIS_Models\applicant\applicants;
use App\Models\ASIS_Models\applicant\gender;
use App\Models\ASIS_Models\Clearance\clearance_students;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\enrollment\enrollment_schedule;
use App\Models\ASIS_Models\enrollment\enrollment_settings;
use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\ASIS_Models\HRIS_model\tbl_position;
use App\Models\ASIS_Models\HRIS_model\tbl_responsibilitycenter;
use App\Models\ASIS_Models\HRIS_model\tblemployee;
use App\Models\ASIS_Models\HRIS_model\tbluserassignment;
use App\Models\ASIS_Models\notification\admin_notification;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;
use App\Models\ASIS_Models\posgres\portal\srgb\student;
use App\Models\ASIS_Models\pre_enrollees\pre_enrollees;
use App\Models\ASIS_Models\system\default_setting;
use App\Models\ASIS_Models\system\status_codes;
use App\Models\ASIS_Models\system\system_modules;
use App\Models\ASIS_Models\system\user_privilege;
use App\Models\ASIS_Models\system\user_rc_group;
use App\Models\ASIS_Models\posgres\enrollment\srgb\semstudent;
use App\Models\clearance\clearance_notes;
use App\Models\clearance\clearance_type;
use App\Models\competency\competency_skills;
use App\Models\e_hris_models\applicant\applicants_civil_status;
use App\Models\e_hris_models\clearance\clearance;
use App\Models\e_hris_models\document\doc_groups;
use App\Models\e_hris_models\document\doc_level;
use App\Models\e_hris_models\document\doc_notes;
use App\Models\e_hris_models\document\doc_notification;
use App\Models\e_hris_models\document\doc_status;
use App\Models\e_hris_models\document\doc_trail;
use App\Models\e_hris_models\document\doc_type_submitted;
use App\Models\e_hris_models\document\doc_user_rc_g;
use App\Models\e_hris_models\Profile;
use App\Models\e_hris_models\ref\ref_citymun;
use App\Models\e_hris_models\ref\ref_country;
use App\Models\e_hris_models\ref\ref_eligibility;
use App\Models\e_hris_models\ref\ref_province;
use App\Models\e_hris_models\ref\ref_region;
use App\Models\Hiring\tbl_competencies_list;
use App\Models\Hiring\tbl_competency_skills;
use App\Models\Hiring\tbl_hiringavailable;
use App\Models\Hiring\tbl_job_doc_requirements;
use App\Models\Hiring\tbl_positionType;
use App\Models\Hiring\tbl_salarygrade;
use App\Models\Hiring\tbl_step;
use App\Models\Hiring\tbleduc_req;
use App\Models\Hiring\tbljob_info;
use App\Models\others\admin_term_condition;
use App\Models\Payroll\Contribution;
use App\Models\Payroll\Deduction;
use App\Models\Payroll\Incentive;
use App\Models\Payroll\Loan;
use App\Models\Payroll\Rates;
use App\Models\posgres_db\pis\pis_employee;
use App\Models\e_hris_models\posgres_db\srgb\srgb_semsubject;
use App\Models\rating\competency_dictionary;
use App\Models\tbl\tblposition;
use App\Models\tbl\tblstep;
use App\Models\travel_order\to_travel_orders;
use App\Models\User;
use App\Models\user_roles;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


use App\Models\ASIS_Models\vote\voteType_model;
use App\Models\ASIS_Models\vote\votePosition_model;
use App\Models\ASIS_Models\vote\voteOpenApplication_Model;
use App\Models\ASIS_Models\posgres\portal\srgb\program;
use App\Models\ASIS_Models\vote\elect_participants_model;
use App\Models\ASIS_Models\vote\candidate_parties_member_model;
use App\Models\ASIS_Models\Program\program_mySQL;


function BASEPATH($postStr = "")
{
    return url('') . $postStr;
}

function GET_RES_TIMESTAMP($type = 0)
{

    $ts = date("YmdHis");

    $ts = "?ts=" . $ts;

    echo $ts;
}

function load_school_year() {
    $sy = registration::select('sy')
        ->groupBy('sy')
        ->orderBy('sy', 'desc')
        ->get();

    return $sy;
}

function loadProgram(){
    $programs = program::where('active', true)->get();
    return $programs;
}

function loadElectionType(){

    return voteType_model::where('active', 1)->get();

}

function loadElectionType_result(){

    return voteType_model::where('active', 1)->whereHas('get_openVoting')->get();

}

function get_candidate_profile_image($studid)
{
    $candidate_profile = '';
    if ($studid) {
        $get_image = elect_participants_model::where('participant_id', $studid)->first();
        $img = '';

        if ($get_image) {
            if ($get_image->profile != '') {
                $get_image = $get_image->profile;
                $profile =  asset('uploads/candidate_profile/'.$get_image);
                $candidate_profile = $profile;
            } else {
                $profile_pic = asset('uploads/settings/1_theG1686012355.png');
                $candidate_profile = $profile_pic;
            }
        } else {
            $profile_pic = asset('uploads/settings/1_theG1686012355.png');
            $candidate_profile = $profile_pic;
        }
    } else {
        $profile_pic = asset('uploads/settings/1_theG1686012355.png');
        $candidate_profile = $profile_pic;
    }

    return $candidate_profile;
}

function candidateParty($candidate_id){
    $member = candidate_parties_member_model::with( 'getParties')->where('candidate', $candidate_id)->first();
    $member_party = '';
    if($member){
        $member_party = $member->getParties;
    }
    return $member_party;
}

function loadUsers(){
    $users = User::where('active', 1)->get();
    return $users;
}

function loadEnrolled(){
    $users = enrollment_list::where('active', 1)->get();
    return $users;
}

function loadElectionPosition(){
    $elect_position = votePosition_model::where('active', 1)->get();
    return $elect_position;
}

function getProfile($id)
{
    $profile = Profile::where('user_id', $id)->first();
    return $profile;
}

function load_interview_status()
{
    $status = status_codes::whereHas('get_interStatus')->get();
    return $status;
}
function load_interview_position()
{
    $inter_position = tblposition::where('active', 1)->get();
    return $inter_position;
}

function load_employee()
{
    $_employee = employee::where('active', 1)->get();
    return $_employee;
}

function loadYears()
{
    $years = [];
    for ($year = 2015; $year <= 2099; $year++) $years[$year] = $year;
    return $years;
}

function load_salary_grade()
{
    $salarygrade = tbl_salarygrade::where('active', 1)->get();
    return $salarygrade;
}

function load_contribution()
{
    $deduction = Contribution::where('active', 1)->get();
    return $deduction;
}

function load_rate()
{
    $rate = Rates::where('active', 1)->get();
    return $rate;
}

function load_deduction()
{
    $deduction = Deduction::where('active', 1)->get();
    return $deduction;
}

function load_incentive()
{
    $incentive = Incentive::where('active', 1)->get();
    return $incentive;
}



function load_loan()
{
    $loan = Loan::where('active', 1)->get();
    return $loan;
}



function getApplicants()
{

    $getApplicants = applicants::doesntHave('get_applicant_rated')->whereHas('get_Hiring_List.get_job_info.getPanelist')->where('active', 1)->get();
    return $getApplicants;
}

function get_competency_dictionary()
{
    $get_competency = competency_dictionary::where('active', 1)->get();
    return $get_competency;
}
function get_competency_skill()
{
    $get_competency_skill = competency_skills::where('active', 1)->get();
    return $get_competency_skill;
}

function loaduser($id)
{
    if ($id) {
        $user = User::with('getUserinfo.getHRdetails.getPosition', 'getUserinfo.getHRdetails.getDesig')->where('employee', $id)->where('active', 1)->first();
    } else {

        $user = User::with('getUserinfo.getHRdetails.getPosition', 'getUserinfo.getHRdetails.getDesig')->where('active', 1)->get();
    }


    return $user;
}



function load_profile($id)
{
    if ($id) {
        $user = employee::where('agencyid', $id)->where('active', 1)->whereNotNull('lastname')->first();
    } else {

        $user = employee::where('active', 1)->whereNotNull('lastname')->get();
    }

    return $user;
}

function loadrc($id)
{
    if ($id) {
        $rc = tbl_responsibilitycenter::where('responid', $id)->where('active', 1)->first();
    } else {
        $rc = tbl_responsibilitycenter::where('active', 1)->get();
    }

    return $rc;
}

function __notification_set($code = 0, $title = "", $content = "")
{

    if (!is_numeric($code)) {
        $code = 0;
    }

    /*
        CODES:
                == 0  : normal
                > 0   : success
                == -1 : warning
                < -1  : danger
        */

    Session::put('__notif_code', $code);
    Session::put('__notif_title', trim($title));
    Session::put('__notif_content', trim($content));
}

function add_log($type, $type_id, $activity)
{

    $add_log = [
        'type' =>  $type,
        'type_id' =>  $type_id,
        'activity' =>  $activity,
        'user_id' =>  Auth::user()->employee,
    ];

    \App\Models\e_hris_models\document\doc_logs::create($add_log);
}

function auto_add_url()
{
    $link = request()->path();
    //dd( $link);
    $getModules = system_modules::where('link', 'like', '%' . $link . '%')->where('active', 1)->first();
    if (!$getModules) {
        $add_url = [
            'module_name' =>  '',
            'link' =>  $link,
        ];
        system_modules::create($add_url);
    }
}

function getModule()
{

    $getModule = system_modules::where('active', 1)->get();

    return $getModule;
}

function getUserPriv()
{

    $getUserPriv = user_privilege::where('active', 1)->where('user_id', Auth::user()->employee)->get();

    return $getUserPriv;
}

function reloadAddUsers($id)
{

    if ($id) {
        $getUser = User::where('employee', $id)->where('active', 1)->get();
    } else {
        $getUser = User::where('active', 1)->get();
    }
    // dd($getUser);
    foreach ($getUser as $user) {
        $getModule = system_modules::where('important', 1)->where('active', 1)->get();
        foreach ($getModule as $module) {
            $getUserpriv = user_privilege::where('active', 1)->where('user_id', $user->employee)->where('module_id', $module->id)->first();
            if (!$getUserpriv) {
                $add_priv = [
                    'module_id' =>  $module->id,
                    'user_id' =>  $user->employee
                ];
                $user_priv_id = user_privilege::create($add_priv)->id;
            }
        }
    }
    return $getModule;
}


// function getAuthUser()
// {
//     $return = Auth::user();
// }

function loadGroups()
{
    return doc_groups::where('active', 1)->get();
}


function createNotification($subject, $subject_id, $sender_type, $sender_id, $target_id, $target_type, $notif_content)
{
    $add_members = [
        'subject' =>  $subject,
        'subject_id' =>  $subject_id,
        'sender_type' =>  $sender_type,
        'sender_id' =>  $sender_id,
        'target_id' =>  $target_id,
        'target_type' =>  $target_type,
        'notif_content' =>  $notif_content,
        'created_by' =>  Auth::user()->employee,
    ];
    admin_notification::create($add_members);
}

function loadNotification()
{
    $getNotif = admin_notification::with(['getDocDetails', 'getGroupDetails', 'getUserDetails'])
        ->where('active', 1)
        ->get(); //

    return $getNotif->where('target_type', 'user')->where('target_id', Auth::user()->id);
}

function load_applicant_notifications()
{
    return doc_notification::with(['get_target_details', 'get_applicant_list'])
        ->where('active', 1)
        ->where('target_type', 'applicants')
        ->where('target_id', Auth::user()->id)
        ->get();
}


//check notif if present in the adminNotification
function get_notif_position($job_re, $panel_id)
{
    $get_position = doc_notification::has('get_Panels')->where('subject_id', $job_re)->where('target_id', $panel_id)
        ->where('active', true)->where('seen', '0')->orWhere('seen', '1')->get();

    foreach ($get_position as $position) {
        $get_pos_des = tbljob_info::where('jobref_no', $position->subject_id)
            ->where('active', true)->get();

        foreach ($get_pos_des as $desc) {
            $get_desc_pos = tbl_position::where('id', $desc->pos_title)->get();

            foreach ($get_desc_pos as $position_title) {
                return $position_title->emp_position . '.';
            }
        }
    }
}


//display the image of the user
//display the image of the user
function get_profile_image($id)
{
    $img = '';
    if ($id) {
        $get_image = employee::where('agencyid', $id)->orWhere('user_id', $id)->where('active', true)->first();
        $img = '';

        if ($get_image) {
            if ($get_image->image) {
                $get_image = $get_image->image;
                $profile = url('') . "/uploads/profiles/" . $get_image;
                $img = $profile;
            } else {
                $query = default_setting::where('key', 'agency_logo')->where('active', true)->first();
                $get_image = $query->image;
                $profile_pic = url('') . "/uploads/settings/" . $get_image;
                $img = $profile_pic;
            }
        } else {
            $query = default_setting::where('key', 'agency_logo')->where('active', true)->first();
            $get_image = $query->image;
            $profile_pic = url('') . "/uploads/settings/" . $get_image;
            $img = $profile_pic;
        }
    } else {
        $query = default_setting::where('key', 'agency_logo')->where('active', true)->first();
        $get_image = $query->image;
        $profile_pic = url('') . "/uploads/settings/" . $get_image;
        $img = $profile_pic;
    }

    return $img;
}

//automatically load the profile pic in the adminNotification
// function load_profile_notif($id)
// {
//     if($id)
//     {
//         $get_image = employee::where('user_id',$id)->where('active',true)->first();
//         $img = '';
//         $profile = '';
//         if($get_image)
//         {
//             $get_image =$get_image->image;
//             $profile = url('') . "/uploads/profiles/" . $get_image;
//             $img = '<img alt="" class="rounded-full" src="'.$profile.'">';
//         }else
//         {
//             $query = default_setting::where('key', 'agency_logo')->where('active', true)->first();
//             $get_image= $query->image;
//             $profile_pic = url('') . "/uploads/settings/" . $get_image;
//             $img = '<img alt="" class="rounded-full" src="'.$profile.'">';
//         }

//         return $img;
//     }
// }


function chekNotif()
{
    return admin_notification::where('active', 1)
        ->where('seen', 0)
        // ->where('target_id',Auth::user()->id)
        ->where('target_id', Auth::user()->employee)
        ->get();
}

function getAssignmets()
{

    $getAssignmet  = user_rc_group::with('getOffice', 'getGroup')->where('active', 1)->where('user_id', Auth::user()->employee)->get();
    return  $getAssignmet;
}

function getAssignmetsHrdetails()
{

    $getAssignmethr  = agency_employees::with('getPosition', 'getDesig')->where('active', 1)->where('agency_id', Auth::user()->employee)->get();
    return  $getAssignmethr;
}




// function encryptIt( $q ) {
//     $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
//     $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
//     return( $qEncoded );
// }

// function decryptIt( $q ) {
//     $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
//     $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
//     return( $qDecoded );
// }

function getLoggedStudent_Name()
{

    $full_name = '';

    $check_account = student::where('studid', Auth::user()->studid)->first();

    // Convert the FIRSTNAME binary data to a readable string
    $hexString_firstname = bin2hex($check_account->studfirstname);
    $binaryData_firstname = hex2bin($hexString_firstname);
    $readableString_firstname = utf8_encode($binaryData_firstname);


    // Convert the LASTNAME binary data to a readable string
    $hexString_lastname = bin2hex($check_account->studlastname);
    $binaryData_lastname = hex2bin($hexString_lastname);
    $readableString_lastname = utf8_encode($binaryData_lastname);

    $full_name = $readableString_firstname . ' ' . $readableString_lastname;

//    $auth_identifier = session('auth_identifier');
//
//    if($auth_identifier === 'STUDENTS')
//
//    {
//
//
//    }else if($auth_identifier === 'ENROLLEES')
//    {
//        $check_account = pre_enrollees::where('pre_enrollee_id', Auth::guard('enrollees_guard')->user()->pre_enrollee_id)->first();
//        $full_name = $check_account->firstname . ' ' . $check_account->lastname;
//    }else
//    {
//        $full_name = 'No Data';
//    }


    return ($full_name);
}

function convertPGAdminName($id)
{

    $check_account = student::where('studid', $id)->first();

    // Convert the FIRSTNAME binary data to a readable string
    $hexString_fullname = bin2hex($check_account->studfullname);
    $binaryData_fullname = hex2bin($hexString_fullname);
    $readableString_fullname = utf8_encode($binaryData_fullname);


    $full_name = $readableString_fullname;

    return ($full_name);
}


function getLoggedStudent_ID()
{
    return student::where('studid', Auth::user()->studid)->first();
}


function GLOBAL_PostGressSQL_HEX_CONVERTER($data)
{
    if ($data != '') {

        $hexString      = bin2hex(trim($data));
        $binaryData     = hex2bin($hexString);

        return utf8_encode($binaryData);
    }
}


function getLoggedUserPosition()
{

    $data = '';
    $userInfo = agency_employees::with(['get_position', 'get_designation'])
        ->where('agency_id', Auth::user()->employee)
        ->where('active', 1)
        ->first();

    if ($userInfo) {
        if ($userInfo->get_position) {
            $data = $userInfo->get_position->emp_position;
        } else if ($userInfo->get_designation) {
            $data = $userInfo->get_designation->userauthority;
        }
    } else {
        $data = 'No Data';
    }

    return ($data);
}



function load_notes()
{
    return doc_notes::where('active', 1)->where('dismiss', 1)->get();
}


function Admin_Load_Clearance_Important_notes()
{
    return clearance_notes::where('active', 1)
        ->where('dismiss', 1)
        ->get();
}

function Load_My_Clearance_Notes()
{

    return clearance_notes::where('active', 1)
        ->where('dismiss', 1)
        ->where('employee_id', Auth::user()->employee)
        ->orWhere('created_by', Auth::user()->employee)
        ->get();
}

function format_date_time($code, $date_time)
{
    $format = '';

    if ($code == 0) {
        $format = $date_time->timezone('Asia/Manila')->toDayDateTimeString();
    } elseif ($code == 1) {
        $format = $date_time->timezone('Asia/Manila')->toFormattedDateString();
    } elseif ($code == 2) {
        $format = $date_time->timezone('Asia/Manila')->toDateTimeString();
    }

    return $format;
}

function GLOBAL_DATE_TIME_GENERATOR()
{
    $tz_object = new DateTimeZone('Asia/Manila');
    $datetime = new DateTime();

    return $datetime->setTimezone($tz_object);;
}

function get_gender()
{
    $genders = '';

    $genders = gender::where('active', 1)->get();
    return $genders;
}

//Montz ni diri
function get_available_positions()
{

    $get_available_pos = tbl_hiringavailable::with(['get_available_Position', 'get_h_list', 'get_sg'])
        ->where('active', true)
        ->get();

    return $get_available_pos;
}

function get_position_type()
{
    $position_type = '';

    $position_type = tbl_positionType::where('active', '1')->get();

    return $position_type;
}


function get_agency_head()
{
    return agency_employees::with('get_user_profile')->where('designation_id', 1)->where('position_id', 4)->where('active', 1)->get();
}


//get the position
function get_position()
{
    $position = tbl_position::get()->where('active', 1);
    return  $position;
}

function get_salary_grade()
{
    $salarygrade = tbl_salarygrade::get();
    return $salarygrade;
}

function get_sg_step()
{
    return tblstep::get();
}

function get_employee()
{
    $employee = '';
    // $employee = employee::has('get_employee_profile_pos')->where('active',true)->get();
    $employee = employee::whereHas('get_employee_profile_pos', function ($query) {
        $query->whereNotNull(['agency_id', 'position_id'])->where('status', '!=', 0);
    })->where('active', true)->get();

    return $employee;
}
//return the Designsation
function get_designation()
{
    $designation = '';

    $designation = tbluserassignment::where('active', true)->get();
    return $designation;
}


//=============================================

function get_province()
{
    return ref_province::get();
}

function get_Clearance_Type()
{
    $get_clearance =  clearance_type::where('active', 1)->get();

    if ($get_clearance) {
        return clearance_type::where('active', 1)->get();
    } else {
        return '';
    }
}


function get_Clearance_Name()
{
    $get_clearance =  clearance::where('active', 1)->get();

    if ($get_clearance) {
        return clearance::where('active', 1)->get();
    } else {
        return '';
    }
}

function get_employee_position()
{
    return  tbl_position::where('active', 1)->get();
}


function get_mun()
{
    return ref_citymun::get();
}

function get_region()
{
    return ref_region::get();
}

function get_country()
{
    return ref_country::get();
}

function get_civil_status()
{
    return applicants_civil_status::where('active', true)->get();
}

function get_Eligibility_type()
{
    return ref_eligibility::where('active', 1)->get();
}

function
account_id_generator()
{

    $last_id = '';
    $new_id = '';
    $last_enrollee_id = '';

    $year = \date('Y');
    $get_pre_enrollees = pre_enrollees::get();

    if ($get_pre_enrollees) {
        foreach ($get_pre_enrollees as $enrollee) {
            $last_id = $enrollee->id;
            $last_enrollee_id = $enrollee->enrollee_id;
        }

        if($last_enrollee_id !== '' )
        {
            $enrollee_id_exist = pre_enrollees::whereNotNull('pre_enrollee_id')->where('pre_enrollee_id', $last_enrollee_id)->first();

            if ($enrollee_id_exist) {
                $latest_enrollee_id = $enrollee_id_exist->enrollee_id;

                if ($latest_enrollee_id) {
                    $exploded_id = explode('-', $latest_enrollee_id);
                    $parse_id = $exploded_id[1];

                    $to_int = (int)$parse_id;

                    $generated_id = sprintf('%05u', $to_int + 1);
                    $new_id = $year . '-' . $generated_id;
                }
            } else {
                $generated_id = sprintf('%05u', $last_id + 1);
                $new_id = $year . '-' . $generated_id;
            }
        }
        else {
            $generated_id = sprintf('%05u', 1);
            $new_id = $year . '-' . $generated_id;
        }

    }
    else {
        $generated_id = sprintf('%05u', 1);
        $new_id = $year . '-' . $generated_id;
    }
    return $new_id;
}

function SQL_VALUE_CHECK($sql, $empty = 1)
{
    $result = $sql;
    /**/
    if (strpos(strtolower($result), strtolower("select")) !== false && strpos(strtolower($result), strtolower("from")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    if (strpos(strtolower($result), strtolower("create")) !== false && strpos(strtolower($result), strtolower("database")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    if (strpos(strtolower($result), strtolower("drop")) !== false && strpos(strtolower($result), strtolower("database")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    if (strpos(strtolower($result), strtolower("create")) !== false && strpos(strtolower($result), strtolower("table")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    if (strpos(strtolower($result), strtolower("drop")) !== false && strpos(strtolower($result), strtolower("table")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    if (strpos(strtolower($result), strtolower("alter")) !== false && strpos(strtolower($result), strtolower("table")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    if (strpos(strtolower($result), strtolower("insert")) !== false && strpos(strtolower($result), strtolower("into")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    if (strpos(strtolower($result), strtolower("delete")) !== false && strpos(strtolower($result), strtolower("from")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    if (strpos(strtolower($result), strtolower("update")) !== false && strpos(strtolower($result), strtolower("set")) !== false) {
        if ($empty > 0) {
            $result = "";
        }
    }
    /**/
    if (
        (strpos(strtolower($result), strtolower("or")) !== false || strpos(strtolower($result), strtolower("and")) !== false) &&
        (strpos(strtolower($result), strtolower("=")) !== false || strpos(strtolower($result), strtolower("!=")) !== false ||
            strpos(strtolower($result), strtolower("<>")) !== false || strpos(strtolower($result), strtolower(">")) !== false ||
            strpos(strtolower($result), strtolower(">=")) !== false || strpos(strtolower($result), strtolower("<")) !== false ||
            strpos(strtolower($result), strtolower("<=")) !== false)
    ) {
        if ($empty > 0) {
            $result = "";
        }
    }
    /**/
    return $result;
}



function check_privileges()
{
    if (Auth::check()) {
        $link = request()->path();
        $getModules = system_modules::where('link', 'like', '%' . $link . '%')->where('active', 1)->first();
        $getUser = User::where('employee', Auth::user()->employee)->first();
        if ($getModules) {

            $get_user_priv = user_privilege::where('module_id', $getModules->id)->where('user_id', Auth::user()->employee)->first();
            if ($get_user_priv) {

                return $get_user_priv;
            }
        }
    }
}

function getDocumentType()
{
    return doc_type_submitted::where('active', 1)->get();
}

function getDocumentLevel()
{
    return doc_level::where('active', 1)->get();
}

function getTypeOfSubmittedDocs()
{
    return doc_type_submitted::where('active', 1)->get();
}


function get_option_for_release()
{

    $option_1 = '';
    $userID = Auth::user()->employee;
    $userFullName = loaduser(Auth::user()->employee)->getUserinfo->firstname . " " . loaduser(Auth::user()->employee)->getUserinfo->lastname;

    $option_1 .= '<option data-ass-type="user" value="' . $userID . '">' . $userFullName . '</option>';

    $getAssignmentHR  = agency_employees::with('getPosition', 'getDesig')->where('active', 1)->where('agency_id', Auth::user()->employee)->get();

    foreach ($getAssignmentHR as $hr)
        if ($hr->getDesig) {
            $option_1 .= '<option data-ass-type="desig" value="' . $hr->getDesig->id . '">' . $hr->getDesig->userauthority . '</option>';
        }

    foreach (getAssignmets()->where('type', 'rc')->groupBy('type_id') as $id => $rc) {
        foreach ($rc as $rcdet) {
            if ($rcdet->getOffice) {
                $option_1 .= '<option data-ass-type="rc" value="' . $rcdet->getOffice->responid . '">' . $rcdet->getOffice->centername . '</option>';
            }
        }
    }

    foreach (getAssignmets()->where('type', 'group')->groupBy('type_id') as $id => $group) {
        foreach ($group as $groupdet) {
            if ($groupdet->getGroup) {
                $option_1 .= '<option data-ass-type="group" value="' . $groupdet->getGroup->id . '">' . $groupdet->getGroup->name . '</option>';
            }
        }
    }
    return $option_1;
}

function get_option_for_release_users()
{

    $option_2 = '';

    foreach (loaduser('') as  $user) {


        if ($user->getUserinfo()->exists()) {
            $option_2 .= '<option value="' . $user->employee . '">' . $user->getUserinfo->firstname . ' ' . $user->getUserinfo->lastname . '</option>';
        }
    }

    return $option_2;
}



function sub_trail($get_trails, $track_number)
{
    $release_to = '';


    foreach ($get_trails as $trail) {
        $trail->sub_trail = doc_trail::where('trail_id', $trail->id)->get();



        if (!$trail->receive_date == null && !$trail->release_date == null) {
            $image_status = '<img alt="done" src="../dist/images/QuaintLikelyFlyingfish-max-1mb.gif">';
        } else if (!$trail->receive_date == null && $trail->release_date == null) {
            $image_status = '<img alt="file holder" src="../dist/images/sun-energy.gif">';
        } else {
            $image_status = '<img alt="to load" src="../dist/images/80ZN.gif">';
        }

        $release_to .= '<div class="intro-x relative flex items-center mb-3">
                <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                        ' . $image_status . '
                    </div>
                </div>
                <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                    <div class="flex items-center">
                        <div class="font-medium">' . $trail->get_user->firstname . ' ' . $trail->get_user->lastname . '</div>
                        <div class="text-xs text-slate-500 ml-auto">' . $trail->created_at . '</div>
                    </div>
                    <div class="text-slate-500 mt-1">Received: ' . $trail->receive_date . '</div>
                    <div class="text-slate-500 mt-1">Released: ' . $trail->release_date . '</div>
                </div>
            </div>
            ';


        if ($trail->sub_trail->isNotEmpty()) {
            $release_to .= sub_trail($trail->sub_trail, $track_number);
        }
    }
    //dd($get_trails );
    return $release_to;
}

function release_to($get_trails, $track_number)
{
    $release_to = '';

    foreach ($get_trails as $trail) {
        $trail->sub_trail = doc_trail::where('trail_id', $trail->id)->get();

        if ($trail->receive_date == null && $trail->release_date == null) {

            $release_to .=  '<option value="' . $trail->target_user_id . '">' . $trail->get_user->firstname . ' ' . $trail->get_user->lastname . '</option>';
        }


        if ($trail->sub_trail->isNotEmpty()) {
            $release_to .= release_to($trail->sub_trail, $track_number);
        }
    }
    //dd($get_trails );
    return $release_to;
}


function system_settings()
{
    return default_setting::where('active', 1)->get();
}

function update_profile_id()
{
    //        $get_user_id = User::get();
    //
    //        if($get_user_id)
    //        {
    //            foreach ($get_user_id as $index => $user)
    //            {
    //                $user_id = $user->id;
    //                $employee = $user->employee;
    //
    //                employee::where('agencyid', $employee)->update([
    //                    'user_id' => $user_id,
    //                ]);
    //
    //            }
    //        }
}


//====================================================================== for the position hiring and shortlisted
function get_position_title($id)
{
    $get_position_title = '';

    $get_position_title = tbl_position::where('id', $id)->first();
    return $get_position_title;
}

function get_SG($id)
{
    $get_sg = '';

    $get_sg = tbl_salarygrade::where('id', $id)->where('active', 1)->first();
    return $get_sg;
}

function get_HRMO($id)
{
    $get_hrmo = '';

    $get_hrmo = employee::where('agencyid', $id)->where('active', 1)->first();
    return $get_hrmo;
}

//====================================================================== convert the date into a specific date
function convert_date($date)
{
    $date =  Carbon::createFromFormat('j M, Y', $date)->format('M j, Y');
    return $date;
}
//change the date format
function convert_date_to_month($date)
{
    $date =  Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('M j, Y');
    return $date;
}

//get position in the printing
function get_HRMO_Position($id)
{
    if ($id) {
        $get_position_title = '';
        $get_position = '';
        $get_position_title = employee::has('get_employee_profile_pos')->where('agencyid', $id)->where('active', true)->first();
        if ($get_position_title) {
            $get_position = tbl_position::where('id', $get_position_title->get_employee_profile_pos->position_id)->first();
            if ($get_position) {
                return $get_position->emp_position;
            }
        } else {
            return $get_position = "no data";
        }
    }
}


function get_Documents_requirements($id)
{
    $get_docs = '';

    $get_docs = tbl_job_doc_requirements::where('job_info_no', $id)->where('active', 1)->get();
    return $get_docs;
}

//get the competency
function get_competency($id)
{
    $get_competency = '';
    if ($id == '') {
        $get_competency = tbl_competency_skills::where('active', true)->get();
    } else if ($id != '') {
        $get_competency = tbl_competencies_list::where('job_ref', $id)->where('active', true)->get();
    }


    return $get_competency;
}


//get the step of the salary
function get_step_salary()
{
    $step = '';

    $step = tbl_step::get()->unique('stepname');

    return $step;
}

function get_status_codes()
{
    $status_codes = '';

    $status_codes = status_codes::where('id', '10')->orWhere('id', '4')->where('active', true)->get();

    return $status_codes;
}

function get_pass_or_failed()
{
    $status_code = '';

    $status_code = status_codes::where('id', '16')->orWhere('id', '17')->where('active', true)->get();

    return $status_code;
}

//get all the data in the tbl_educ_req
function get_all_get_educ_rec($id)
{
    $get_educ_info = '';

    if ($id) {
        $get_educ_info = tbleduc_req::where('job_info_no', $id)->get();

        return $get_educ_info;
    }
}
//=============================================================================
function get_lenght_of_characters($limit, $val)
{
    $name = '';

    if (strlen($val) > $limit) {
        $name = Str::substr($val, 0, $limit);
    } else {
        $name = $val;
    }

    return $name;
}

//=============================================================================

function get_employee_idp()
{
    $emp_name = '';

    $emp_name = employee::whereNotNull('agencyid')->get();

    return $emp_name;
}

//=============================================================================
function GLOBAL_GENERATE_TOPBAR()
{
    $img = '';

    if (Auth::check()) {
        $query = User::where('studid', Auth::user()->studid)->where('active', 1)->first();

        if ($query) {
            if ($query->profile_pic) {
                $profile_pic = url('') . "/uploads/profiles/" . $query->profile_pic;
                $img = '<img alt="" src="' . $profile_pic . '">';

                return $img;
            } else {
                $query = default_setting::where('key', 'agency_logo')->where('active', 1)->first();
                $profile_pic = url('') . "/uploads/settings/" . $query->image;
                $img = '<img alt="" src="' . $profile_pic . '">';

                return $img;
            }
        } else {
            $query = default_setting::where('key', 'agency_logo')->where('active', 1)->first();
            $profile_pic = url('') . "/uploads/settings/" . $query->image;
            $img = '<img alt="" src="' . $profile_pic . '">';

            return $img;
        }
    } else {
        $query = default_setting::where('key', 'agency_logo')->where('active', 1)->first();
        $profile_pic = url('') . "/uploads/settings/" . $query->image;
        $img = '<img alt="" src="' . $profile_pic . '">';

        return $img;
    }
}

function GLOBAL_GENERATE_LOGIN_LOGO()
{
    $logo = '';

    $query_logo = default_setting::where('key', 'agency_logo')->where('active', true)->first();


    if ($query_logo) {
        $get_image = $query_logo->image;
        $profile_pic = url('') . "/uploads/settings/" . $get_image;

        $logo = '<img alt="logo" class="w-10" src="' . $profile_pic . '">';
    }

    return $logo;
}

function GLOBAL_LOGIN_LOGO()
{
    $login_white_logo = '';

    $query_logo = default_setting::where('key', 'login_title')->where('active', true)->first();


    if ($query_logo) {
        $get_image = $query_logo->image;
        $login_white_logo = url('') . "/uploads/settings/" . $get_image;
    }

    return $login_white_logo;
}

function GLOBAL_LOGIN_LOGO_1()
{
    $login_white_logo = '';

    $query_logo = default_setting::where('key', 'login_white_logo')->where('active', true)->first();


    if ($query_logo) {
        $get_image = $query_logo->value;
        $login_white_logo = url('') . "/uploads/settings/" . $get_image;
    }

    return $login_white_logo;
}

function GLOBAL_login_title()
{
    $login_title = '';

    $query_logo = default_setting::where('key', 'login_title')->where('active', true)->first();


    if ($query_logo) {
        $get_image = $query_logo->image;
        $login_title = url('') . "/uploads/settings/" . $get_image;
    }

    return $login_title;
}

function GLOBAL_AGENCY_WEBSITE()
{
    $link = '';

    $query_website = default_setting::where('key', 'agency_website')->where('active', 1)->first();


    if ($query_website) {
        $link = $query_website->value;
    }

    return $link;
}

function GLOBAL_AGENCY_NAME()
{
    $link = '';

    $query_ = default_setting::where('key', 'agency_name')->where('active', 1)->first();


    if ($query_) {
        $title = $query_->value;
    } else {
        $title = 'Not Set';
    }

    return $title;
}


function GLOBAL_register_agency_title()
{
    $query_title = default_setting::where('key', 'agency_name')->where('active', 1)->first();


    if ($query_title) {
        $get_title = $query_title->value;
    } else {
        $get_title = 'Agency Tile Not Set Yet!';
    }

    return $get_title;
}

function GLOBAL_login_white_logo_background()
{
    $login_white_logo_background = '';

    $query_logo = default_setting::where('key', 'login_white_logo_background')->where('active', true)->first();


    if ($query_logo) {
        $get_image = $query_logo->image;
        $login_white_logo_background = url('') . "/uploads/settings/" . $get_image;
    }

    return $login_white_logo_background;
}



function GLOBAL_GENERATE_LOGIN_TITLE()
{
    $title = '';

    $query_title = default_setting::where('key', 'system_title')->where('active', true)->first();

    if ($query_title) {
        $system_title = $query_title->value;
        $title = '<span class="text-white text-lg ml-3">' . $system_title . '</span>';
    }
    return $title;
}

function load_position($position_id)
{

    if ($position_id) {

        return \App\Models\ASIS_Models\HRIS_model\tbl_position::where('id', $position_id)->get();
    } else {
        return \App\Models\ASIS_Models\HRIS_model\tbl_position::get();
    }
}

function load_designation($designation_id)
{

    if ($designation_id) {

        return \App\Models\ASIS_Models\HRIS_model\tbluserassignment::where('id', $designation_id)->get();
    } else {
        return \App\Models\ASIS_Models\HRIS_model\tbluserassignment::get();
    }
}

function load_employment_type($employment_type_id)
{

    if ($employment_type_id) {

        return \App\Models\e_hris_models\employment\employment_type::where('id', $employment_type_id)->get();
    } else {
        return \App\Models\e_hris_models\employment\employment_type::get();
    }
}

function load_supervisor()
{

    return doc_user_rc_g::with('getOffice.rc_head')->where('type', 'rc')->where('user_id', Auth::user()->employee)->get();
}

function load_employees()
{

    //        return employee::has('get_employee_profile_pos')->where('active', 1)->get();
    return employee::where('active', 1)->get();
}


function load_responsibility_center($rc_id)
{

    if ($rc_id) {

        return \App\Models\ASIS_Models\HRIS_model\tbl_responsibilitycenter::where('id', $rc_id)->where('active', 1)->get();
    } else {
        return \App\Models\ASIS_Models\HRIS_model\tbl_responsibilitycenter::where('active', 1)->get();
    }
}



function load_status_codes($status_id)
{

    if ($status_id) {

        return \App\Models\ASIS_Models\system\status_codes::where('id', $status_id)->where('active', 1)->get();
    } else {
        return \App\Models\ASIS_Models\system\status_codes::where('active', 1)->get();
    }
}

function rate_status()
{
    return \App\Models\ASIS_Models\system\status_codes::whereHas('get_rate_status')->where('active', 1)->get();
}


/*       Payroll Select2         */
function payroll_Position()
{
    return tbl_position::get();
}

function payroll_Responsibility_Center()
{
    return tbl_responsibilitycenter::get();
}

function payroll_Salary_Grade()
{
    return tbl_step::with('get_salary_grade')->get();
}


function payroll_Employee()
{
    return agency_employees::with('get_user_profile')->where('active', 1)->get();
}

function payroll_Agency()
{
    return default_setting::where('key', 'agency_location')->get();
}
/*       Payroll Select2         */



function export_travel_order()
{

    $items = array();
    $count = 0;
    $get_to = to_travel_orders::with(
        'get_signatories.getUserinfo.getHRdetails.getPosition',
        'get_signatories.getUserinfo.getHRdetails.getDesig',
        'get_desig',
        'get_position'
    )
        ->where('name_id', Auth::user()->employee)
        ->where('active', '1')
        ->get();

    foreach ($get_to as $to) {

        $my_des_pos = 'N/A';
        if ($to->pos_des_type == 'position') {
            $pos = tblposition::where('id', $to->pos_des_id)->first();
            $my_des_pos = $pos->emp_position;
        } elseif ($to->pos_des_type == 'desig') {
            $des = tbluserassignment::where('id', $to->pos_des_id)->first();
            $my_des_pos = $des->userauthority;
        }

        $collection[$count++] =  [
            "id" => $to->id,
            "name_id" => $to->name_id,
            "name" => $to->name,
            "date" => Carbon::parse($to->date)->format('d-m-Y'),
            "departure_date" =>  Carbon::parse($to->departure_date)->format('d-m-Y'),
            "return_date" =>  Carbon::parse($to->return_date)->format('d-m-Y'),
            "pos_des" => $my_des_pos,
            "station" => $to->station,
            "destination" => $to->destination,
            "purpose" => $to->purpose,
        ];

        $items = collect([
            $collection
        ]);
    }

    return $items;
}

function export_profile()
{

    $items = array();
    $count = 0;
    $get_profiles = employee::whereNotNull('agencyid')->where('active', 1)->get();

    foreach ($get_profiles as $prof) {



        $collection[$count++] =  [
            "agencyid" => $prof->agencyid,
            "lastname" => $prof->lastname,
            "firstname" => $prof->firstname,
            "mi" => $prof->mi,
            "extension" =>  $prof->extension,
            "dateofbirth" =>  $prof->dateofbirth,
            "placeofbirth" => $prof->placeofbirth,
            "sex" => $prof->sex,
            "citizenship" => $prof->citizenship,
            "email" => $prof->email,

        ];

        $items = collect([
            $collection
        ]);
    }

    return $items;
}


//=============================================================================
function isUserAdmin($user)
{
    $result = 0;
    /***/
    $result = user_roles::isUserAdmin($user);
    /***/
    return $result;
}
function isCurrentUserAdmin()
{
    $result = 0;
    /***/
    $result = user_roles::isCurrentUserAdmin();
    /***/
    return $result;
}

//=============================================================================
function GetClassByCurrentPageRequest($pages, $returnValue = '')
{
    $result = '';
    /***/
    $tn = 0;
    /***/
    foreach ($pages as $cd) {
        if (trim($cd) != "") {
            if (request()->is($cd)) {
                $tn++;
                break;
            }
        }
    }
    /***/
    if ($tn > 0) {
        $result = $returnValue;
    }
    /***/
    return $result;
}
//=============================================================================
//=============================================================================
// SETTING

/*

    */

function SETTING_AGENCY_LOGO()
{
    $login_white_logo = '';

    $query_logo = default_setting::where('key', 'agency_logo')->where('active', true)->first();


    if ($query_logo) {
        $get_image = $query_logo->value;
        $login_white_logo = url('') . "/uploads/settings/" . $get_image;
    }

    return $login_white_logo;
}

function SETTING_ICTC_LOGO()
{
    $login_white_logo = '';

    $query_logo = default_setting::where('key', 'ictc_logo')->where('active', true)->first();


    if ($query_logo) {
        $get_image = $query_logo->value;
        $login_white_logo = url('') . "/uploads/settings/" . $get_image;
    }

    return $login_white_logo;
}

//=============================================================================

//loop if exist
function loop_add_value_if_exist($value)
{

    return $value++;
}



function generate_employee_id($count_emp_year, $result = null)
{
    if ($result === null) {
        $result = $count_emp_year + 1;
    }

    $date_year = Carbon::now()->format('Y');
    $employee_id = sprintf($date_year . '-%05d', $result);

    $check_if_employee = employee::where('agencyid', $employee_id)->get();

    if ($check_if_employee->isNotEmpty()) {
        return generate_employee_id($count_emp_year, $result + 1);
    }

    return $employee_id;
}

function user_status($user_id)
{
    $user_status = '';

    if (Cache::has('is_online-' . $user_id)) {

        $user_status = '<div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600"></div>';
    } else {

        $user_status = '<div class="w-3 h-3 bg-secondary absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600"></div>';
    }
    return $user_status;
}

function fullname($agency_id)
{

    $profile = employee::where('agencyid', $agency_id)->where('active', 1)->first();
    $user_information_name = 'N/A';
    if ($profile) {
        $user_information_name = $profile->firstname . ' ' . $profile->lastname;
    }
    return $user_information_name;
}

function profile_details($id)
{
    $profile = employee::where('agencyid', $id)->where('active', 1)->first();

    return $profile;
}

function current_user_id()
{

    return Auth::user()->employee;
}

function load_status_document()
{

    return doc_status::where('tag_for', 'document')->get();
}




function get_User_Privilege()
{

    if (Session::has('get_user_priv')) {
        $get_user_priv = Session::get('get_user_priv')[0];

        if ($get_user_priv->write == 1) {
            $can_write = true;
        } else {
            $can_write = false;
        }

        if ($get_user_priv->create == 1) {
            $can_create = true;
        } else {
            $can_create = false;
        }

        if ($get_user_priv->delete == 1) {
            $can_delete = true;
        } else {
            $can_delete = false;
        }

        if ($get_user_priv->print == 1) {
            $can_print = true;
        } else {
            $can_print = false;
        }
    } else {
        $can_write  = false;
        $can_create = false;
        $can_delete = false;
        $can_print  = false;
    }

    return array([
        'can_write'     => $can_write,
        'can_create'    => $can_create,
        'can_delete'    => $can_delete,
        'can_print'     => $can_print,
    ]);
}

function get_term_condition()
{

    $load_content = admin_term_condition::where('active', 1)->first();

    return $load_content;
}


function GLOBAL_PROFILE_GENERATOR()
{

    $query = default_setting::where('key', 'agency_logo')->where('active', 1)->first();
    $get_default = $query->image;
    $profile_picture = url('') . "/uploads/settings/" . $get_default;

    return $profile_picture;
}

function load_esms_profiles($id)
{

    if ($id) {
        $school_faculty_id_name = pis_employee::where('empid', $id)->whereNotNull('fullname')->groupBy('empid')->first();
    } else {
        $school_faculty_id_name = pis_employee::whereNotNull('fullname')->groupBy('empid')->get();
    }

    return $school_faculty_id_name;
}

function load_esms_year($id)
{
    if ($id) {
        $school_year = registration::where('studid', $id)->groupBy('sy')->orderBy('sy', 'desc')->pluck('sy');
    } else {
        $school_year = registration::groupBy('sy')->orderBy('sy', 'desc')->pluck('sy');
    }

    return $school_year;
}

function load_esms_sem($id)
{
    if ($id) {
        $school_sem = registration::where('studid', $id)->groupBy('sem')->pluck('sem');
    } else {
        $school_sem = registration::groupBy('sem')->pluck('sem');
    }

    return $school_sem;
}

function load_enroll_list_school_sem()
{
    $school_sem = '';
    $school_sem = enrollment_list::groupBy('sem')->orderBy('sem', 'desc')->pluck('sem');

    return $school_sem;
}

function load_enroll_list_school_year()
{
    $school_year = '';
    $school_year = enrollment_list::groupBy('year')->orderBy('year', 'desc')->pluck('year');

    return $school_year;
}

function load_enroll_list_year_level()
{
    $year_level = '';
    $year_level = enrollment_list::groupBy('year_level')->orderBy('year_level', 'desc')->pluck('year_level');

    return $year_level;
}

function load_enroll_list_program()
{
    $program = '';
    $program = enrollment_list::groupBy('studmajor')->orderBy('studmajor', 'desc')->whereNotNull('studmajor')->pluck('studmajor');

    return $program;
}


function LOGGED_USER_INFO()
{

    $get_info = tblemployee::where('agencyid', Auth::user()->employee)->first();
    //        $get_info = 'Tae';

    return $get_info;
}

function GLOBAL_PROFILE_PICTURE_GENERATOR()
{
    $query = default_setting::where('key', 'agency_logo')->where('active', 1)->first();
    $profile_pic = url('') . "/uploads/settings/" . $query->image;

    return $profile_pic;
}

//get studentname info
function getUserLogin()
{
    $fullname = '';
    if (Auth::check())
    {
        $getUserlogin = User::Where('studid',Auth::user()->studid)
            ->Where('active',1)
            ->first();
        if($getUserlogin)
        {
            $fullname = Str::title($getUserlogin->fullname);
        }
    }else if(auth()->guard('enrollees_guard')->check())
    {
        $enrollees_id = auth()->guard('enrollees_guard')->user()->pre_enrollee_id;

        $getUserlogin = pre_enrollees::Where('pre_enrollee_id', $enrollees_id)
            ->Where('active',1)
            ->first();
        if($getUserlogin)
        {
            $fullname = Str::title($getUserlogin->firstname.' '.$getUserlogin->midname.' '.$getUserlogin->lastname);
        }
    }else if(auth()->guard('employee_guard')->check())
    {
        $employee_id = auth()->guard('employee_guard')->user()->employee;

        $getUserlogin = \App\Models\Admin::Where('employee', $employee_id)
            ->Where('active',1)
            ->first();
        if($getUserlogin)
        {
            $fullname = Str::title($getUserlogin->firstname.' '.$getUserlogin->middlename.' '.$getUserlogin->lastname);
        }
    }

    return $fullname;
}

//get the role
function getRole()
{

    $role = '';

    $auth_identifier = session('auth_identifier');

    $getUserlogin = User::Where('studid',Auth::user()->studid)
        ->Where('active',1)
        ->first();
    if($getUserlogin)
    {
        $fullname = Str::title($getUserlogin->fullname);
    }

    $getUserRole = User::Where('studid',Auth::user()->studid)
                    ->Where('active',true)
                    ->first();

    if($getUserRole->role==='' || $getUserRole->role===null )
    {
        $role = "(Student)";
    } else
    {
        $role = '('.$getUserRole->role.')';
    }

    return $role;
}

//get the year level and department
function getYearlevel()
{
    $val = '';
    $year_level = semstudent::Where('studid',Auth::user()->studid)
                  ->chunk(100, function($query) use (&$val){
                        foreach ($query as $info)
                        {
                            $val = $info->studmajor.' '.$info->studlevel;
                        }
                  });

    if($val==='' || $val===null)
    {
        $val = '';
    }

    return $val;
}



function getLoggedEnrollees()
{

    $full_name = '';

    $auth_identifier = session('auth_identifier');

    if(auth()->guard('enrollees_guard')->check())
    {
        $check_account = pre_enrollees::where('pre_enrollee_id', Auth::guard('enrollees_guard')->user()->pre_enrollee_id)->first();
        $full_name = $check_account->firstname . ' ' . $check_account->lastname;
    }
    else
    {
        $full_name = 'No Data';
    }

    return ($full_name);
}

function getLoggedEnrollees_ID()
{
    return pre_enrollees::where('pre_enrollee_id', Auth::guard('enrollees_guard')->user()->pre_enrollee_id)->first();
}

function getLoggedEmployees()
{

    $full_name = '';

    if(auth()->guard('employee_guard')->check())
    {
        $check_account = \App\Models\Admin::where('employee', Auth::guard('employee_guard')->user()->employee)->first();
        $full_name = $check_account->firstname . ' ' . $check_account->lastname;
    }
    else
    {
        $full_name = 'No Data';
    }

    return ($full_name);
}

function getLoggedEmployees_ID()
{
    return \App\Models\Admin::where('employee', Auth::guard('employee_guard')->user()->employee)->first();
}


function GLOBAL_EMAIL_HEADER(){

    $profile_pic = '';

    $query_logo = default_setting::where('key', 'image_header')->where('active', 1)->first();


    if ($query_logo) {
        $get_image = $query_logo->image;
        $profile_pic = url('') . "/uploads/settings/" . $get_image;

        $header = '<img alt="logo" class="w-10" src="' . $profile_pic . '">';
    }

    return $profile_pic;

}

function GLOBAL_PRE_ENROLLEES_ACCOUNT_VERIFICATION(){

    $pre_enrollees_id = Auth::guard('enrollees_guard')->user()->pre_enrollee_id;
    $data = pre_enrollees::where('pre_enrollee_id', $pre_enrollees_id)->first();

    /** STATUS CODES
     *
     *  7 - Completed
     *
     */

    if($data->account_status === '7')
    {
        return true;
    }else
    {
        return false;
    }
}

function GLOBAL_COPY_DATA_FROM_PGADMIN_TO_MYSQL(){

    $active_year = enrollment_settings::where('description', 'year')->first()->key_value;
    $active_sem = enrollment_settings::where('description', 'sem')->first()->key_value;


    $transactions = program::where('active', true)
        ->with('programDepartment')
        ->orderBy('progdesc', 'asc')
        ->get();

    foreach ($transactions as $data)
    {

        $program_code = $data->progcode;
        $program_desc = $data->progdesc;
        $program_dept = $data->progdept;

        program_mySQL::updateOrCreate(
            [
                'program_code'=> trim($data->progcode),
                'year'  => trim($active_year),
                'sem'  => trim($active_sem),
            ],

            [
                'program_code'  => trim($program_code),
                'program_desc'  => trim($program_desc),
                'program_dept'  => trim($program_dept),
                'year'  => trim($active_year),
                'sem'  => trim($active_sem),
                'active'        => 1,
            ]
        );
    }

}

function GLOBAL_REMARKS_GENERATOR($stanine) {
    $result = [];

    switch ($stanine) {
        case 0:
            $result['remark'] = "Invalid input. Please enter a number between 1 and 5.";
            $result['remark_class'] = 'danger';
            break;
        case 2:
        case 1:
            $result['remark'] = "FAILED";
            $result['remark_class'] = 'danger';
            break;
        case 3:
            $result['remark'] = "PASSED";
            $result['remark_class'] = 'warning';
            break;
        case 4:
            $result['remark'] = "PASSED";
            $result['remark_class'] = 'success';
            break;
        case 5:
            $result['remark'] = "PASSED";
            $result['remark_class'] = 'primary';
            break;
        default:
            if ($stanine > 5) {
                $result['remark'] = "PASSED";
                $result['remark_class'] = 'primary';
            } elseif ($stanine > 4) {
                $result['remark'] = "PASSED";
                $result['remark_class'] = 'success';
            } elseif ($stanine > 3) {
                $result['remark'] = "PASSED";
                $result['remark_class'] = 'warning';
            } elseif ($stanine > 2) {
                $result['remark'] = "FAILED";
                $result['remark_class'] = 'danger';
            } elseif ($stanine > 1) {
                $result['remark'] = "FAILED";
                $result['remark_class'] = 'danger';
            } else {
                $result['remark'] = "Invalid input. Please enter a number between 1 and 5.";
                $result['remark_class'] = 'danger'; // You can set a default class for invalid input
            }
    }

    return $result;
}

function GLOBAL_MIDDLE_NAME_GENERATOR($middleName): string
{

    if($middleName)
    {
        $my_mid_name   = $middleName;
        $my_mid_name_new = substr($my_mid_name, 0, 1);

        $mi = $my_mid_name_new.'.';

    }else
    {
        $mi = '';
    }

    return $mi;
}


function GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER(){

    return enrollment_settings::where('description', 'attempt_verification')->first()->active;

}

function GLOBAL_STUDENTS_ATTEMPT_ACCOUNT(){

    return enrollment_settings::where('description', 'attempt_count')->first()->key_value;

}



function GLOBAL_YEAR_LEVEL_GENERATOR($year) {
    $result = [];

    switch ($year) {

        case 1:

            $result['year'] = "1st";

            break;
        case 2:

            $result['year'] = "2nd";

            break;
        case 3:

            $result['year'] = "3rd";

            break;
        case 4:

            $result['year'] = "4th";

            break;
        case 5:

            $result['year'] = "5th";

            break;
        case 6:

            $result['year'] = "6th";

            break;
        case 7:

            $result['year'] = "7th";

            break;
        case 8:

            $result['year'] = "8th";

            break;
        default:
            $result['remark'] = "Invalid input. Please enter a number between 1 and 5.";
            $result['remark_class'] = 'danger'; // You can set a default class for invalid input
    }

    return $result;
}


function GLOBAL_SEMESTER_GENERATOR($sem) {
    $result = [];

    switch ($sem) {

        case 1:

            $result['sem'] = "1st";

            break;
        case 2:

            $result['sem'] = "2nd";

            break;
        default:
            $result['sem'] = "Summer";
    }

    return $result;
}


function GLOBAL_CLEARANCE_TYPE_GENERATOR($type) {
    $result = [];

    switch ($type) {

        case 'NON_GRADUATING':

            $result['type'] = "Non-Graduating";

            break;
        case 'GRADUATING':

            $result['type'] = "Graduating";

            break;
        default:
            $result['type'] = "Clearance";
    }

    return $result;
}


function adminGetMyCreatedClearanceImportantNotes()
{
    if(auth()->guard('employee_guard')->check())
    {
        $employee_id = auth()->guard('employee_guard')->user()->employee;
    }
    else
    {
        $employee_id = null;
    }


    return \App\Models\ASIS_Models\Clearance\clearance_notes::where('active', 1)
        ->where('created_by', $employee_id)
        ->where('dismiss', 0)
        ->get();
}


function studentsGetCreatedClearanceImportantNotesForMe()
{
    if(auth()->guard('web')->check())
    {
        $student_id = auth()->guard('web')->user()->studid;
        $student_name = auth()->guard('web')->user()->fullname;
        $student_section = enrollment_list::where('studid', $student_id)->first()->section;
        $student_major = enrollment_list::where('studid', $student_id)->first()->studmajor;

    }else
    {
        $student_id = null;
        $student_name = null;
        $student_section = null;
        $student_major = null;
    }

    return \App\Models\ASIS_Models\Clearance\clearance_notes::with(['get_Signatories', 'get_EmployeeSignatoryData'])
        ->where('active', 1)
        ->where('program', $student_major)
        ->where('dismiss', 0)
        ->get();
}
