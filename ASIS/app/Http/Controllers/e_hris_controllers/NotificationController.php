<?php

namespace App\Http\Controllers\e_hris_controllers;

use App\Http\Controllers\Controller;
use App\Models\document\doc_file;
use App\Models\document\doc_level;
use App\Models\document\doc_notification;
use App\Models\document\doc_trail;
use App\Models\Leave\agency_employees;
use App\Models\system\default_settingNew;
use App\Models\tblemployee;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommonController;


use Session;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);

    }

    /*  ============ */

    public function DB_SCHEMA() {
        return "primehrmo.";
    }

    public function DBTBL_NOTIFICATION() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "admin_notification",
        ];
        return $result;
    }

    /*  ============ */
    public function notification_create(Request $request) {

        $username = Auth::user()->id;

        if(trim($username) != ""){


            $res = NOTIFICATION_SET($request->status,$request->title,$request->details,$request->seen,$request->target,$request->targettype,$request->type,$request->typeid,$request->file,$request->islink,$request->link,$request->locallink,$request->locallinktype);

            echo json_encode($res);

        }

    }

    public function notification_load(Request $request) {

        $DBDRIVER = $this->DBTBL_NOTIFICATION()['driver'];
        $DBTBL = $this->DBTBL_NOTIFICATION()['table'];

        $username = Auth::user()->id;

        if(trim($username) != ""){

        	$result = [];

            $qry = " SELECT *,DATE_FORMAT(entrydate,'%h:%i %p') AS edate,DATE_FORMAT(entrydate,'%M %e, %Y  %h:%i %p') AS edate2 FROM " . $DBTBL . " WHERE active='1' AND ( ( TRIM(target_id)='' OR TRIM(target_type)='' ) OR ( TRIM(LOWER(target_type))=TRIM(LOWER('user')) AND TRIM(LOWER(target_id))=TRIM(LOWER('" . $username . "')) ) ) ORDER BY entrydate DESC LIMIT 5 ";
            $res = DB::connection($DBDRIVER)->select($qry);

            for($i=0; $i<count($res); $i++) {
            	$date1 = date("Y-m-d");
            	$date2 = date("Y-m-d",strtotime($res[$i]->entrydate));
            	$usedate2 = 0;
            	if($date2 < $date1) {
            		$usedate2 = 1;
            	}else{
            		$usedate2 = 0;
            	}
                /***/
                $img = "";
                if(trim($res[$i]->target_type) == "" && trim($res[$i]->locallinktype) == "") {
                    $img = url('') . "/img/adminNotification.png";
                }else{
                    if(trim($res[$i]->locallinktype) != "") {
                        if(trim(strtolower($res[$i]->locallinktype)) == trim(strtolower('committee'))) {
                            $img = GLOBAL_GET_COMMITTEE_PHOTO(trim($res[$i]->locallink));
                        }
                        if(trim(strtolower($res[$i]->locallinktype)) == trim(strtolower('agency'))) {
                            $img = GLOBAL_GET_AGENCY_PHOTO(trim($res[$i]->locallink));
                        }
                    }
                }
                if(trim($img) == "") {
                    $img = url('') . "/img/adminNotification.png";
                }
        		/***/
        		$td = [
        			"id" => $res[$i]->id,
        			"target_id" => $res[$i]->target_id,
        			"target_type" => $res[$i]->target_type,
        			"type" => $res[$i]->type,
        			"type_id" => $res[$i]->type_id,
        			"title" => $res[$i]->title,
        			"descriptions" => $res[$i]->descriptions,
        			"file_id" => $res[$i]->file_id,
        			"seen" => $res[$i]->seen,
        			"status" => $res[$i]->status,
        			"active" => $res[$i]->active,
        			"created_at" => $res[$i]->created_at,
        			"updated_at" => $res[$i]->updated_at,
        			"committee_id" => $res[$i]->committee_id,
        			"chat_group_id" => $res[$i]->chat_group_id,
        			"islink" => $res[$i]->islink,
                    "link" => $res[$i]->link,
                    "locallink" => $res[$i]->locallink,
        			"locallinktype" => $res[$i]->locallinktype,
        			"added_by" => $res[$i]->added_by,
        			"entrydate" => $res[$i]->entrydate,
        			"edate" => $res[$i]->edate,
        			"edate2" => $res[$i]->edate2,
                    "usedate2" => $usedate2,
        			"img" => $img,
        		];
        		/***/
        		$result[count($result)] = $td;
            }

            echo json_encode($result);

        }

    }

    public function update_incoming_notif(Request $request)
    {
        doc_notification::where('target_id', Auth::user()->employee)->where('subject', 'document')->where('target_type', 'user')->where('subject_id', $request->subject_id)->update([
            'seen' => 1,
        ]);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function notification_details_load(Request $request)
    {
        doc_notification::where('id', $request->notif_id)->update([
             'seen' => 1,
         ]);

    }

    public function get_notification_details(Request $request)
    {
        $notification_id = Crypt::decrypt($request->notification_id);
        $sender_id       = Crypt::decrypt($request->sender_id);

        $get_notification = doc_notification::with(['getUserDetails', 'get_applicant_list.get_job_info.getPos'])
                                            ->where('id', $notification_id)
                                            ->where('active', 1)
                                            ->first();

        $get_agency_employee = agency_employees::with(['get_user_profile'])
                                                ->where('agency_id', $sender_id)
                                                ->first();

        if($get_notification)
        {
            $notif_content = $get_notification->notif_content;
            $notif_sender = $get_notification->sender_id;
            $date_created = $get_notification->created_at;

            if($get_notification->get_applicant_list)
            {
                if($get_notification->get_applicant_list->get_job_info()->exists())
                {
                    $position = $get_notification->get_applicant_list->get_job_info->get_Position->emp_position;
                }else
                {
                    $position = 'No data!';
                }


            }else
            {
                $position = '';
            }

            doc_notification::where('id', $notification_id)->update([
               "seen" => 1,
            ]);

        }
        else
        {
            $notif_content = '';
            $notif_sender  = '';
            $date_created  = '';
        }

        if($get_agency_employee->get_user_profile)
        {
            $first_name = $get_agency_employee->get_user_profile->firstname;
            $last_name = $get_agency_employee->get_user_profile->lastname;
            $extension = $get_agency_employee->get_user_profile->extension;
            $email = $get_agency_employee->get_user_profile->email;

            if($get_agency_employee->get_user_profile->image)
            {
                $image = $get_agency_employee->get_user_profile->image;
                $profile_pic = url('') . "/uploads/profiles/" . $image;

            }else
            {
                $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
                $get_image = $query->image;

                $profile_pic = url('') . "/uploads/settings/" . $get_image;
            }


        }
        else
        {
            $first_name = '';
            $last_name = '';
            $extension = '';
            $email = '';
            $image = '';

            $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
            $get_image = $query->image;

            $profile_pic = url('') . "/uploads/settings/" . $get_image;

        }

        if($get_agency_employee->get_position)
        {
            $sender_designation_position = $get_agency_employee->get_position->emp_position;

        }elseif ($get_agency_employee->get_designation)
        {
            $sender_designation_position = $get_agency_employee->get_designation->userauthority;
        }else
        {
            $sender_designation_position = '';
        }

       return json_encode(array(

           "notif_content" => $notif_content,
           "notif_sender" => $notif_sender,
           "date_created" => $date_created,

           "first_name" => $first_name,
           "last_name" => $last_name,
           "extension" => $extension,
           "profile_pic" => $profile_pic,
           "email" => $email,

           "position" => $position,
           "sender_designation_position" => $sender_designation_position,

       ));
    }

    //load the adminNotification of the appointed panels
    public function load_hiring_notification_info(Request $request)
    {
        $load_notif_html = '';
        $seen_icon = '';
        $names_full="";

        $get_notif_hiring_info = doc_notification::with(['getDocDetails','getGroupDetails', 'get_Panels'])
                                        ->where('active',1)
                                        ->where('target_type','user')
                                        ->where('target_id',Auth::user()->id)
                                        ->Orwhere('target_id',Auth::user()->employee)
                                        ->get();


        foreach($get_notif_hiring_info as $notif)
        {
            if($notif)
            {
                        if( $notif->subject == 'appoint_sched' || $notif->subject == 'hiring')
                        {
                            $profile_pic = get_profile_image($notif->sender_id);
                            $fullname = $this->get_sender_name($notif);
                            $content = $notif->notif_content;
                            $email = $this->get_email_sender_notif($notif->sender_id);
                            $seen = $notif->seen;
                            $encrypt_id = Crypt::encryptString($notif->id);
                            $encrypt_content = Crypt::encryptString($content);
                            $encrypt_pic = Crypt::encryptString($profile_pic);
                            $encrypt_time = Crypt::encryptString($notif->created_at->diffForHumans());
                            $encrypt_pos = Crypt::encryptString($notif->sender_id);
                            $encrypt_email = Crypt::encryptString($email);
                            $encrypt_seen =  Crypt::encryptString($seen);

                            foreach($fullname as $name)
                            {
                                $names_full =  $name->firstname.' '.$name->lastname;
                            }

                            $encrypt_name = Crypt::encryptString($names_full);

                            if($seen == 0)
                            {
                                $seen_icon .= ' <div class="w-4 h-4 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white"></div> ';
                            }else
                            {
                                $seen_icon .= ' <div class="w-4 h-4 bg-slate-500 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>';
                            }

                            $load_notif_html.='<div style="border-radius: 0.375rem" class="p-2 hover:bg-slate-100">
                                                    <div  id="hiring_notif" class="tooltip cursor-pointer relative flex items-center hiring_notif" data-notif-id="'.$encrypt_id.'" data-notif-content="'.$encrypt_content.'" data-notif-name="'.$encrypt_name.'"
                                                    data-notif-pic="'.$encrypt_pic.'" data-notif-time = "'.$encrypt_time.'" data-target-id="'.$encrypt_pos.'" data-email="'.$encrypt_email.'" data-seen="'.$encrypt_seen.'">
                                                    <div class="w-12 h-12 flex-none image-fit mr-1">
                                                        <img alt="Profile Picture" class="rounded-full" src='.$profile_pic.'>
                                                        '.$seen_icon.'
                                                    </div>
                                                    <div class="ml-2 overflow-hidden">
                                                        <div class="font-medium truncate mr-5"></div>
                                                        <div class="flex items-center">
                                                            <a id="group_id" href="javascript:;" class="font-medium truncate mr-5">'.$names_full.'</a>
                                                            <div class="text-xs text-slate-400 ml-auto whitespace-nowrap" >'.$notif->created_at->diffForHumans().'</div>
                                                        </div>
                                                        <div class="w-full truncate text-slate-500 mt-0.5">'.$content.'</div>
                                                </div>
                                                </div>
                                            </div>';
                        }

            }
            else
            {
                 $load_notif_html.='<div class="w-full truncate text-slate-500 mt-0.5">No adminNotification yet</div>';
            }

        }
        $encode_data = json_encode($load_notif_html);
        echo $encode_data;
    }

    public function display_notif_content(Request $request)
    {
         try {
            $decrypted_id = Crypt::decryptString($request->id);
            $decrypted_name = Crypt::decryptString($request->name);
            $decrypted_content = Crypt::decryptString($request->content);
            $decrypted_pic = Crypt::decryptString($request->pic);
            $decrypted_time = Crypt::decryptString($request->time);
            $decrypted_pos = Crypt::decryptString($request->pos);
            $decrypted_email = Crypt::decryptString($request->email);
            $position = get_HRMO_Position($decrypted_pos);

            if(!$position)
            {
                $position = 'No data';
            }


            return response()->json([
                'status' => true,
                'name' => $decrypted_name,
                'content' =>  $decrypted_content,
                'pic' => $decrypted_pic,
                'time' => $decrypted_time,
                'position' => $position,
                'email' => $decrypted_email
            ]);

        } catch (DecryptException $e)
        {
            dd($e);
        }
    }

    public function update_hiring_notif_status(Request $request)
    {
        try {
            $id = $request->id;
            $decrypted_seen = Crypt::decryptString($request->seen);

        if($id)
        {
            if($decrypted_seen == 0)
            {
                $decrypted_id = Crypt::decryptString($id);
                $update_seen = doc_notification::where('id',$decrypted_id)->where('seen',false)->
                where('active',true)->update(['seen' => '1']);
            }
        }

        } catch (DecryptException $e) {

        }
    }

    private function get_email_sender_notif($id)
    {
        $get_email = tblemployee::has('get_employee_profile_pos')->where('agencyid',$id)->where('active',true)->get();

        foreach($get_email as $emails)
        {
            return $emails->email;
        }

    }

    private function get_sender_name($notif)
    {
        return $notif->getUser_Details;
    }


    //Added by MONTZ-tzy
    public function load_applicants_notifications(Request $request)
    {
        $applicants_notification_html = '';
        $seen_icon = '';
        $sender_info = '';
        $profile_pic = '';

        $load_applicants_notif = doc_notification::with(['get_applicant_list', 'get_sender_details'])
            //                              ->where('seen', 0)
            ->where('active',1)
            ->where('target_type','applicants')
            ->where('target_id',Auth::user()->id)
            ->orderBy('seen', 'ASC')
            ->get();


        if($load_applicants_notif)
        {
            foreach($load_applicants_notif as $applicants_notif)
            {

                if($applicants_notif->get_sender_details)
                {
                    if($applicants_notif->get_sender_details->image)
                    {
                        $get_image = $applicants_notif->get_sender_details->image;
                        $profile_pic = url('') . "/uploads/profiles/" . $get_image;
                    }else
                    {
                        $profile_pic = GLOBAL_PROFILE_GENERATOR();
                    }
                    $sender_info = '<a href="javascript:;" class="font-medium truncate mr-5">'.$applicants_notif->get_sender_details->firstname.' '.$applicants_notif->get_sender_details->lastname.'</a>';
                }else
                {
                    $sender_info = '<a href="javascript:;" class="font-medium truncate mr-5">No Data</a>';
                }

                if($applicants_notif)
                {
                    $notification_id = Crypt::encrypt($applicants_notif->id);
                    $sender_id = Crypt::encrypt($applicants_notif->sender_id);
                    $target_type = $applicants_notif->target_type;

                    if($applicants_notif->seen == 0)
                    {
                        $seen_icon .= '<div class="w-4 h-4 bg-danger absolute right-0 bottom-0 rounded-full border-2 border-white"></div>';
                    }else
                    {
                        $seen_icon .= ' <div class="w-4 h-4 bg-dark absolute right-0 bottom-0 rounded-full border-2 border-white"></div>';
                    }

                    $applicants_notification_html .=
                        '<div id="try_div" style="border-radius: 0.375rem" class="p-2 hover:bg-slate-100">
                        <div class="cursor-pointer relative flex items-center btn_notif_show_details" data-notif-type="'.$target_type.'" data-adminNotification-id="'.$notification_id.'" data-sender-id="'.$sender_id.'">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Profile Picture" class="rounded-full" src="'.$profile_pic.'">
                                    '.$seen_icon.'
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    '.$sender_info.'
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">'.$applicants_notif->created_at->diffForHumans().'</div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">'.$applicants_notif->notif_content.'</div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }

        return json_encode(array(
            'applicants_notification' => $applicants_notification_html,
        ));
    }

    public function load_employee_documents(Request $request)
    {
        $emp_doc_notification_html = '';
        $seen_icon = '';

        $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
        $get_image = $query->image;
        $default_pic = url('') . "/uploads/settings/" . $get_image;

        $load_employees_documents = doc_notification::with(['get_sender_details'])
                                                    ->where('active',1)
                                                    ->where('subject','!=','hiring')
                                                    ->where('target_type','user')
                                                    ->where('target_id',Auth::user()->employee)
                                                    ->orderBy('seen', 'ASC')
                                                    ->get();

        if($load_employees_documents)
        {
            foreach ($load_employees_documents as $doc_notif)
            {
                if($doc_notif->get_sender_details)
                {
                    $get_image = $doc_notif->get_sender_details->image;

                    if($doc_notif->get_sender_details->image)
                    {
                        $profile_pic = url('') . "/uploads/profiles/" . $get_image;

                    }else
                    {
                        $profile_pic = $default_pic;
                    }

                    $sender_info = '<a href="javascript:;" class="font-medium truncate mr-5">'.$doc_notif->get_sender_details->firstname.' '.$doc_notif->get_sender_details->lastname.'</a>';

                }else
                {
                    $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
                    $get_image = $query->image;
                    $profile_pic = url('') . "/uploads/settings/" . $get_image;
                    $sender_info = '<a href="javascript:;" class="font-medium truncate mr-5">No Data</a>';
                }

                if($doc_notif)
                {
                    $notification_id = Crypt::encrypt($doc_notif->id);
                    $sender_id = Crypt::encrypt($doc_notif->sender_id);
                    $target_type = $doc_notif->target_type;

                    if($doc_notif->seen == 0)
                    {
                        $seen_icon .= '<div class="w-4 h-4 bg-danger absolute right-0 bottom-0 rounded-full border-2 border-white"></div>';
                    }else
                    {
                        $seen_icon .= ' <div class="w-4 h-4 bg-dark absolute right-0 bottom-0 rounded-full border-2 border-white"></div>';
                    }

                    $emp_doc_notification_html .=
                        '<div id="try_div" style="border-radius: 0.375rem" class="p-2 hover:bg-slate-100">
                        <div class="cursor-pointer relative flex items-center btn_notif_show_details" data-notif-type="'.$target_type.'" data-adminNotification-id="'.$notification_id.'" data-sender-id="'.$sender_id.'">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Profile Picture" class="rounded-full" src="'.$profile_pic.'">
                                    '.$seen_icon.'
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    '.$sender_info.'
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">'.$doc_notif->created_at->diffForHumans().'</div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">'.$doc_notif->notif_content.'</div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }
        return json_encode(array(
            'emp_doc_notification_html' => $emp_doc_notification_html,
        ));
    }

    // Rooiskie ni dri
    public function  _notif_applicant(){
        $notif = '';

        $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
        $get_image = $query->image;
        $default_pic = url('') . "/uploads/settings/" . $get_image;

        $get_hired_notifs = doc_notification::
        with(['get_sender_details','get_agency.getPosition'])
        ->where('active',1)
        ->where('subject', 'hire')
        ->where('target_type','user')
        ->where('target_id',Auth::user()->id)
        ->get();



            foreach ($get_hired_notifs as $get_hired_notif) {



                if($get_hired_notif){
                    $notif_content = $get_hired_notif->notif_content;
                    $notification_id = $get_hired_notif->id;
                    $sender_id = $get_hired_notif->sender_id;
                    $target_type = $get_hired_notif->target_type;

                    if($get_hired_notif->seen == 0){
                        $seen_classs = 'bg-success';
                    }else{
                        $seen_classs = 'bg-slate-500';
                    }
                        $profile_pic = '';
                        $profile_name = '';
                        $profile_email = '';
                    if($get_hired_notif->get_sender_details){
                        // dd($get_hired_notif->get_sender_details);
                        $get_imags = $get_hired_notif->get_sender_details->image;
                        $profile_name = $get_hired_notif->get_sender_details->firstname.' '.$get_hired_notif->get_sender_details->lastname;
                        $profile_email = $get_hired_notif->get_sender_details->email;
                        $profile_pic = url('') . "/uploads/profiles/" . $get_imags;
                    }else{
                        $profile_pic =  $default_pic;
                    }

                    $sender_position = '';
                    if($get_hired_notif->get_agency){
                        $agency = $get_hired_notif->get_agency;
                        if($agency->getPosition){
                            // dd($agency->getPosition);
                            $sender_position = $agency->getPosition->emp_position;
                        }
                    }

                    $notif .= '<div style="border-radius: 0.375rem" class="p-2 hover:bg-slate-100">
                        <div class="cursor-pointer relative flex items-center view_hired_notif"
                                data-profile-name="'.$profile_name.'"
                                data-prof-pic="'.$profile_pic.'"
                                data-notif-content="'.$notif_content.'"
                                data-adminNotification-id="'.$notification_id.'"
                                data-sender-position = "'.$sender_position.'"
                                data-sender-id="'.$sender_id.'"
                                data-sender-email="'.$profile_email.'"
                                data-time-sent="'.$get_hired_notif->created_at->diffForHumans().'">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Profile Picture" class="rounded-full" src="'.$profile_pic.'">
                                <div class="w-4 h-4 '.$seen_classs.' absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                <a href="javascript:;" class="font-medium truncate mr-5">'.$profile_name.'</a>
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">'.$get_hired_notif->created_at->diffForHumans().'</div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">'.$get_hired_notif->notif_content.'</div>
                            </div>
                        </div>
                    </div>';
                }

            }
            echo $notif;


    }

    public function _notif_hiredUpdate($notif_id){
        doc_notification::where('id', $notif_id)->update(['seen' => 1 ]);

        return response()->json(['status' => 'success']);
    }

    public function  _notif_selected_applicant(){
            $notif = '';

            $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
            $get_image = $query->image;
            $default_pic = url('') . "/uploads/settings/" . $get_image;

            $get_hired_notifs = doc_notification::with(['get_sender_details','get_agency.getPosition'])
            ->where('active',1)
            ->where('subject', 'i_schedule')
            ->where('target_type','user')
            ->where('target_id',Auth::user()->id)
            ->get();



                foreach ($get_hired_notifs as $get_hired_notif) {



                    if($get_hired_notif){
                        $notif_content = $get_hired_notif->notif_content;
                        $notification_id = $get_hired_notif->id;
                        $sender_id = $get_hired_notif->sender_id;
                        $target_type = $get_hired_notif->target_type;

                        if($get_hired_notif->seen == 0){
                            $seen_classs = 'bg-success';
                        }else{
                            $seen_classs = 'bg-slate-500';
                        }
                            $profile_pic = '';
                            $profile_name = '';
                            $profile_email = '';
                        if($get_hired_notif->get_sender_details){
                            // dd($get_hired_notif->get_sender_details);
                            $get_imags = $get_hired_notif->get_sender_details->image;
                            $profile_name = $get_hired_notif->get_sender_details->firstname.' '.$get_hired_notif->get_sender_details->lastname;
                            $profile_email = $get_hired_notif->get_sender_details->email;
                            $profile_pic = url('') . "/uploads/profiles/" . $get_imags;
                        }else{
                            $profile_pic =  $default_pic;
                        }

                        $sender_position = '';
                        if($get_hired_notif->get_agency){
                            $agency = $get_hired_notif->get_agency;
                            if($agency->getPosition){
                                // dd($agency->getPosition);
                                $sender_position = $agency->getPosition->emp_position;
                            }
                        }

                        $notif .= '<div style="border-radius: 0.375rem" class="p-2 hover:bg-slate-100">
                            <div class="cursor-pointer relative flex items-center view_hired_notif"
                                    data-profile-name="'.$profile_name.'"
                                    data-prof-pic="'.$profile_pic.'"
                                    data-notif-content="'.$notif_content.'"
                                    data-adminNotification-id="'.$notification_id.'"
                                    data-sender-position = "'.$sender_position.'"
                                    data-sender-id="'.$sender_id.'"
                                    data-sender-email="'.$profile_email.'"
                                    data-time-sent="'.$get_hired_notif->created_at->diffForHumans().'">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Profile Picture" class="rounded-full" src="'.$profile_pic.'">
                                    <div class="w-4 h-4 '.$seen_classs.' absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                    <a href="javascript:;" class="font-medium truncate mr-5">'.$profile_name.'</a>
                                        <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">'.$get_hired_notif->created_at->diffForHumans().'</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">'.$get_hired_notif->notif_content.'</div>
                                </div>
                            </div>
                        </div>';
                    }

                }
                // dd($notif);
                echo $notif;


    }
// end of rooiskie
}

