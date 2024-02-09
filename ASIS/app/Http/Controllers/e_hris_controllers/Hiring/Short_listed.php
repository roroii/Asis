<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\applicant\applicants_list;
use App\Models\Hiring\tbl_position;
use App\Models\Hiring\tbl_shortlisted;
use App\Models\tblemployee;
use App\Models\applicant\applicants_attachments;
use App\Models\applicant\applicants_tempfiles;
use App\Models\MailSettings\email_attachments;
use Illuminate\Http\Request;
use App\Models\system\default_settingNew;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Mail;
use App\Mail\MailNotification;
use App\Mail\NotifyEmail;

class Short_listed extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }
    //
    public function short_listed_index()
    {
        return view('applicant_short_listed.short_listed');
    }


    //retreive the position title
    public function get_applicants_details(Request $request)
    {
        $position =tbl_position::where('id',$request->ref_num)->get(['emp_position']);

        if($position)
        {
            return response()->json([
                'status' => true,
                'message' => $position
            ]);
        } else
        {
            return response()->json([
                'status' => true,
                'message' => 'Unable to find the positon applied'
            ]);
        }
    }

    //retrieve the image
    private  function get_image($id)
    {
        $get_image = tblemployee::where('user_id',$id)->where('active',true)->first();
        $profile = '';

        if($get_image->image)
        {
            $get_image =$get_image->image;
            $profile = url('') . "/uploads/profiles/" . $get_image;
        }
        else
        {
            $get_default = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
            $get_image =  $get_default->image;
            $profile = url('') . "/uploads/settings/" . $get_image;
        }
        return $profile;


    }

    // display the shortlisted applicants
    public function short_listed_applicant(Request $request)
    {
        $status = $request->stat;
        $applicant_info = $this->get_applicant_info($request->stat);
        $full_name = '';
        $table = '<table id="tb_short_listed" class="table table-report my-8">
                        <thead class="">
                        <tr>
                        <th></th>
                         <th class="text-center whitespace-nowrap "><strong>Position</></th>
                         <th class="text-center whitespace-nowrap "><strong>Plantilla</></th>
                         <th class="text-center whitespace-nowrap "><strong>Applicant list</></th>
                         <th class="text-center whitespace-nowrap "><strong>Status</></th>
                     </tr>
                     </thead>
                     <tbody>';

        if($applicant_info)
        {
            if($status == '11' || $status == null)
                {
                    foreach($applicant_info as $info)
                    {
                        // $applicant_profile = $this->get_profile($info,$status);
                        // $applicant_fullname = $applicant_profile->firstname.' '.$applicant_profile->mi.' '.$applicant_profile->lastname;
                        $job = $this->get_job_positions($info,$status);
                        $status_code = $this->status_code($info,$status);
                        // $approved = $this->approved_by($info->approved_by);
                        // $image = $this->get_image($info->applicant_id);
                        $count = $this->count_applicant_approve_list($info->jobref_no,$status);

                            foreach($job as $jobs )
                                {
                                    if($status_code->name == 'Approved')
                                    {
                                        $color = "text-success";
                                    }
                                        $table.= '<tr>
                                            <td><button id="btn_child_applicant_info" class="btn_child_applicant_info" data-jobref="'.$info->jobref_no.'" > <i id="add" class="fa fa-user-plus text-success"></i></button></td>
                                            <td><a href"" class="underline decoration-dotted whitespace-nowrap font-bold">' .$info->get_job_info->getPos_applicants->emp_position. '</a></td>
                                            <td>'.$info->get_job_educ_req->item_no.'</td>
                                            <td class=""><div class="flex  items-center">
                                            <a class="flex justify-center items-center develop-target" href="javascript:;" data-tw-toggle="modal" data-tw-target="#addTarget_modal">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-800 ml-2 text-slate-400 zoom-in tooltip dropdown" title="List of applicant">
                                                    '.$count.'
                                                </div>
                                            </a>
                                        </div></td>
                                            <td class="'.$color.'">'.$status_code->name.'</td>
                                        </tr>';
                                }
                    }
                }
            else if($status == '10')
            {
                foreach($applicant_info as $info)
                {
                    //$applicant_fullname = $info->get_profile_infos->firstname.' '.$info->get_profile_infos->mi.' '.$info->get_profile_infos->lastname;
                     $job = $this->get_job_positions($info,$status);
                     $status_code = $this->status_code($info,$status);
                    // $approved = $this->approved_by($info->approved_by);
                    // $image = $this->get_image($info->applicant_id);
                    $count = $this->count_applicant_approve_list($info->ref_num,$status);

                    foreach($job as $jobs )
                    {
                         if($status_code->name == 'Waiting')
                        {
                            $color = "text-pending";
                        }

                            //         $table .= '<tr>
                            //         <td><button id="btn_child_applicant_info" class="btn_child_applicant_info" > <i class="fa fa-circle-plus text-success"></i> </button></td>
                            //         <td><a href"" class="underline decoration-dotted whitespace-nowrap">#' .$applicant_profile->user_id. '</a></td>
                            //         <td><div class="flex items-center">
                            //                     <div class="w-9 h-9 image-fit zoom-in">
                            //                         <img alt="Midone - HTML Admin Template" class="rounded-lg border-white shadow-md tooltip" data-action="zoom" src="'.$image.'">
                            //                     </div>
                            //                     <div class="ml-4">
                            //                         <label  class="font-medium whitespace-nowrap">' .$applicant_fullname.'</label>
                            //                         <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">'. $applicant_profile->email.'</div>
                            //                     </div>
                            //                     </div></td>
                            //         <td class="'.$color.'">' .$status_code->name. '</td>
                            //         <td class="text-center">
                            //         <div id="shortlisted_drop_down" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                            //         <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                            //         <div class="dropdown-menu w-40 zoom-in tooltip">
                            //             <div class="dropdown-content">
                            //             <button id="' .$info->id. '" type="button" class="w-full dropdown-item btn_details_data" data-applicant_id="' .$info->applicant_id. '" data-name="' .$applicant_fullname. '" data-ref-num="' . $info->ref_num . '" data-job="' .$jobs->pos_title. '" data-agency="' .$jobs->assign_agency. '" data-comments="' .$info->notes. '" data-status="'.$status_code->name.'"
                            //             data-date-approved="'. convert_date_to_month($info->created_at) .'" data-date-applied="'. $info->date_applied .'" data-approved="'. $approved .'" data-image="'.$image.'" data-rate-sched="'.$info->rate_sched.'" data-stat="'.$info->stat.'" data-shortlisted-id="'.$info->id.'" data-exam="'.$info->exam_result.'"> <i class="fa fa-circle-info text-success"></i><span class="ml-2">Details</span></button>
                            //             </div>
                            //         </div>
                            //     </div>
                            //     </td>
                            // </tr>';

                            $table.= '<tr>
                                <td><button id="btn_child_applicant_info" class="btn_child_applicant_info" data-jobref="'.$info->ref_num.'" > <i id="add" class="fa fa-user-plus text-success"></i> <i  id="minus" class="fa fa-user-minus text-danger hidden"></i> </button></td>
                                <td><a href"" class="underline decoration-dotted whitespace-nowrap font-bold">' .$info->get_job_info->getPos_applicants->emp_position. '</a></td>
                                <td>'.$info->get_educ_requirements->item_no.'</td>
                                <td class=""><a class="flex items-center develop-target" href="javascript:;" data-tw-toggle="modal" data-tw-target="#addTarget_modal">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="List of applicant">
                                        '.$count.'
                                    </div>
                                </a></td>
                                <td class="'.$color.'">'.$status_code->name .'</td>
                        </tr>';
                    }

                }
            }

            $table.=  '</tbody></table>';
        }

        echo $table;
    }

    //filter the status based on the request
    private function get_applicant_info($stat)
    {
        if($stat == 10)
        {
            $applicant_info = tbl_shortlisted::with('get_profile_infos','get_job','get_educ_requirements')->where('stat',10)->where('active',true)->latest("created_at")->get()->unique('ref_num');
        }
        else if($stat == 11 || $stat=='')
        {
            $applicant_info = applicants_list::with('get_profile','get_status_code','get_job_educ_req','get_job_info')->where('applicant_status',11)->where('active',true)->latest("created_at")->get()->unique('jobref_no');
        }

        return $applicant_info;
    }

    // count the list of applicant that are approved
    private function count_applicant_approve_list($job_ref,$stat)
    {
        $count_applicant = '';

        if($stat == '11' || $stat == '')
        {
            $count_applicant = applicants_list::where('jobref_no',$job_ref)->whereRaw('applicant_status =11 && active = true')->count();

        }
        else if($stat == '10')
        {
            $count_applicant = tbl_shortlisted::where('ref_num',$job_ref)->whereRaw('stat = 10 && active = true')->count();
        }

        return $count_applicant;
    }

    //get the information regarding regarding on the available status
    private function get_profile($get_profile,$status)
    {
        if($status == '11' || $status == null)
        {
            return $get_profile -> get_profile;
        }
        else if($status == '10')
        {
            return $get_profile -> get_profile_infos;
        }
    }

    private function status_code($get_code,$status)
    {
        if($status == '11' || $status == null)
        {
            return $get_code -> get_status_code;
        }
        else if($status == '10')
        {
            return $get_code -> get_stat;
        }

    }

    private function get_job_positions($get_position,$status)
    {
        if($status == '11' || $status == null)
        {
            return $get_position -> get_job_infos;
        }
        else if($status == '10')
        {
            return $get_position -> get_job;
        }
    }

    private function approved_by($id)
    {
        $approved_by = tblemployee::where('user_id',$id)->orWhere('agencyid',$id)->where('active',true)->get();

        foreach($approved_by as $aprovee)
        {
            return $aprovee->firstname.' '.$aprovee->lastname;
        }
    }

    //*============================================================================================================*//
    private function get_applicant_list($stat,$ref_num)
    {
        if($stat == 10)
        {
            $applicant_info = tbl_shortlisted::with('get_profile_infos','get_job')->where('stat',10)->where('ref_num',$ref_num)->where('active',true)->latest("created_at")->get();
        }
        else if($stat == 11 || $stat == null)
        {
            $applicant_info = applicants_list::with('get_profile','get_status_code','get_job_educ_req','get_job_info')->where('applicant_status',11)->where('jobref_no',$ref_num)->where('active',true)->latest("created_at")->get();

        }

        return $applicant_info;
    }

    //responsible for the showing of child data in the
    public function get_child_details(Request $request)
    {
        $status = $request->stat;
        $applicant_info = $this->get_applicant_list($request->stat,$request->jobref);
        $data = [];
        $td = '';

        if( $status == 11 || $status == '')
        {
            if($applicant_info)
            {
                foreach( $applicant_info as $info)
                {
                    $applicant_profile = $this->get_profile($info,$status);
                    $applicant_fullname = $applicant_profile->firstname.' '.$applicant_profile->mi.' '.$applicant_profile->lastname;
                    $job = $this->get_job_positions($info,$status);
                    $status_code = $this->status_code($info,$status);
                    $approved = $this->approved_by($info->approved_by);
                    $image = $this->get_image($info->applicant_id);

                        if($status_code->name == 'Approved')
                        {
                            $color = "text-success";
                        }

                        foreach($job as $jobs)
                        {
                            $td = [
                                "applicant_id" => $applicant_profile->user_id,
                                "applicant_image" => $image,
                                "applicant_name" => $applicant_fullname,
                                "applicant_email" => $applicant_profile->email,
                                "applicant_status" => $status_code->name,
                                "id" => $info->id,
                                "applicant_list_id" => $info->applicant_id,
                                "ref_num" => $info->jobref_no,
                                "pos_title" => $jobs->pos_title,
                                "agency" => $jobs->assign_agency,
                                "comments" => $info->application_note,
                                "date_approved" => convert_date_to_month($info->approval_date),
                                "date-applied" => convert_date_to_month($info->created_at),
                                "approved" => $approved,
                            ];

                            $data[count($data)] = $td;
                        }
                }

            }

        }

        else if($status == 10)
        {
            if($applicant_info)
            {
                foreach($applicant_info as $info)
                {
                    $applicant_profile = $this->get_profile($info,$status);
                    $applicant_fullname = $applicant_profile->firstname.' '.$applicant_profile->mi.' '.$applicant_profile->lastname;
                    $job = $this->get_job_positions($info,$status);
                    $status_code = $this->status_code($info,$status);
                    $approved = $this->approved_by($info->approved_by);
                    $image = $this->get_image($info->applicant_id);

                    if($status_code->name == 'Waiting')
                    {
                        $color = "text-pending";
                    }

                    foreach($job as $jobs)
                    {
                        $td = [
                            "applicant_id" => $info->applicant_id,
                            "applicant_image" => $image,
                            "applicant_name" => $applicant_fullname,
                            "applicant_email" => $applicant_profile->email,
                            "applicant_status" => $status_code->name,
                            "ref_num" => $info->ref_num,
                            "pos_title" => $jobs->pos_title,
                            "agency" => $jobs->assign_agency,
                            "comments" => $info->notes,
                            "status" => $status_code->name,
                            "date_approved" => convert_date_to_month($info->created_at),
                            "date_applied" =>  $info->date_applied,
                            "approved" => $approved,
                            "image" => $image,
                            "rate-sched" => $info->rate_sched,
                            "stat" => $info->stat,
                            "shortlisted_id" => $info->id,
                            "exam" => $info->exam_result
                        ];

                        $data[count($data)] = $td;
                    }
                }
            }
        }
        echo json_encode($data);
    }

    //*===========================================================================================================*//
    // saved the applicant info
    public function appoint_sched(Request $request)
    {
        try
        {
                $data = '';
                $id = auth()->user()->employee;

                $data = [
                    "ref_num" => $request->ref_num,
                    "exam_result" => $request->exam,
                    "applicant_id" => $request->ids,
                    "notes" => $request->notes,
                    "date_applied" => $request->applied_date,
                    "rate_sched" => $request->date,
                    "approved_by" => $id,
                    "stat" => $request->stat
                ];

                $saved = tbl_shortlisted::create($data);
                createNotification('appoint_sched',$request->ref_num,'user',auth()->user()->employee,$request->ids,'user',$request->notes);

                if($saved)
                {
                    return response()->json([
                        'status' => true,
                        'message' => 'Successfully set a schedule for the applicant rating'
                    ]);
                } else
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Error please try again'
                    ]);
                }
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);

            exit;
        }
    }

    public function appointment_interview(Request $request)
    {
        try
        {
            $data = '';
                $id = auth()->user()->employee;

                $data = [
                    "ref_num" => $request->ref_num,
                    "exam_result" => $request->exam,
                    "applicant_id" => $request->ids,
                    "notes" => $request->notes,
                    "date_applied" => $request->applied_date,
                    "rate_sched" => $request->date,
                    "approved_by" => $id,
                    "stat" => $request->stat
                ];

                $saved = tbl_shortlisted::create($data);

                if($saved)
                {
                    return response()->json([
                        'status' => true,
                        'message' => 'Successfully set a schedule for the applicant rating'
                    ]);
                } else
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Error please try again'
                    ]);
                }

        }catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);

            exit;
        }
    }

    //update the shortlisted applicant
    public function update_shortlisted_applicant(Request $request)
    {
        try
        {
            if($request->isMethod('post'))
            {
                $data = '';
                $data = [
                    "notes" => $request->notes,
                    "rate_sched" => $request->date,
                    "stat" => $request->stat,
                ];

                $update = tbl_shortlisted::where('id',$request->id)->update($data);
                $udated_applicant_status = $this->update_applicant_list($request->ids,$request->stat,$request->ref_num);

                if($update)
                {
                    return response()->json([
                        "status" => true,
                        "message" => "Successfully Updated"
                    ]);
                } else
                {
                    return response()->json([
                        "status" => false,
                        "message" => "Unable to update try again"
                    ]);
                }
            }

        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);
        }
    }

    private function update_applicant_list($id,$status,$ref_num)
    {
        try
        {
            $update_stat = '';
            $data = [
                'applicant_status' => $status];

            $update_stat = applicants_list::where('applicant_id',$id )->where('jobref_no',$ref_num)->update($data);


            return $update_stat;

        }catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);
        }
    }

    //update the status in the applicant list
    public function update_stat(Request $request)
    {
        try
        {
            if($request->isMethod('post'))
            {
                $data = '';
                $update_stat = '';

                 $data = [
                    'applicant_status' => $request->stat
                ];

                $update_stat = applicants_list::where('id',$request->id)->where('applicant_status','11')->update($data);

                if($update_stat)
                {
                    return response()->json([
                        'status' => true,
                    ]);
                }
            }

        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);
        }
    }

    //get the attachment of the applicants
    public function get_attachment(Request $request)
    {
        try{
            $load_data = [];

            if( $request->id !=null && $request->job_ref != null)
            {
                $get_applicant_attachment = applicants_attachments::where('applicant_id',$request->id)->where('jobref_no',$request->job_ref)->chunk(50, function($q)
                use(&$temp_attachment,&$load_data)
                {
                    foreach($q as $data)
                    {
                        $temp_attachment =
                        [
                            'attachment' => Str::limit($data->attachment_name,25,'.....'),
                            'attachment_type' => $data->attachment_type,
                            'id' => Crypt::encryptString($data->id),
                        ];

                        $load_data[count($load_data)] = $temp_attachment;
                    }
                });

                echo json_encode($load_data);
            }

        } catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);
        }
    }


    public function view_applicant_attachment($id)
    {
       try {

            if($id)
            {
                $decrypted = Crypt::decryptString($id);
                $file_name = '';
                $filePath = '';

                $get_view = applicants_attachments::where('id',$decrypted)->chunk(50, function($q)
                use(&$file_name,&$filePath)
                {
                    foreach($q as $data)
                    {
                        $file_name = $data->attachment_name;
                        $filePath = $data->attachment_path;
                    }
                });

                $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                $path_to_file = $storagePath . "public/applicant/attachments/" . $filePath . "/" . $file_name;

                return response()->file($path_to_file);
            }

       } catch (DecryptException $e){
            dd($e);
       }
    }

    public function download_applicant_attachment($id)
    {
        try
        {
            if($id)
            {
                $decrypted = Crypt::decryptString($id);
                $file_name = '';
                $filePath = '';

                $get_view = applicants_attachments::where('id',$decrypted)->chunk(50, function($q)
                use(&$file_name,&$filePath)
                {
                    foreach($q as $data)
                    {
                        $file_name = $data->attachment_name;
                        $filePath = $data->attachment_path;
                    }
                });

                $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                $path_to_file = $storagePath . "public/applicant/attachments/" . $filePath . "/" . $file_name;

                return response()->download($path_to_file,$file_name);
            }
        }catch(DecryptException $e)
        {
            dd($e);
        }
    }

    //**=======================================================================================================================**//
    //Send email adminNotification

    public function send_applicant_email_notif(Request $request)
    {
        try
        {
            $path = system_settings()->where('key','agency_logo')->first();
            $agency_logo = 'uploads/settings/'.$path->image;

            $email_title = $request->email_title;
            $email_to = $request->email_to;
            $message = $request->email_mesages;
            $closing = $request->email_closing_tag;
            $path = $this->get_path($request->email_attachments);

            if( $email_to != '' && $agency_logo != '')
            {
                $subject = $email_title;
                $content = $message;

                Mail::to($email_to)->queue(new NotifyEmail($subject,$content,$closing,$agency_logo,$path));

                return response()->json([
                    'status' => true,
                    'message' => 'The email is sent successfully'
                ]);


            }

        } catch(Exception $er)
        {
            return response()->json(['message' => $er]);
        }
    }

    //get the file attachment
    private function get_path($email_attachments)
    {
        $attachment_path = [];

        if($email_attachments != '')
        {
            foreach($email_attachments as $file_id)
                {
                    $concat_id = explode("<",$file_id);
                    $file_path = $concat_id[0];

                    $attachment = email_attachments::where('folder', $file_path)->get();

                    foreach($attachment as $attachments)
                    {
                        $filePath = $attachments->folder;
                        $file_name = $attachments->filename;

                        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                        $path_to_file = $storagePath . "public/documents/email/" . $filePath . "/" . $file_name;
                        $attachment_path[] = $path_to_file;
                    }
                }

            return $attachment_path;
        } else
        {
                return null;
        }
    }

    //upload the file path in the database
    public function _tmp_file_upload(Request $request)
    {
        foreach ($request->file() as $files) {
            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();

                $get_profile = tblemployee::where('user_id', Auth::user()->id)->first();

                $last_name = $get_profile->lastname;

                $folder = $last_name . '-' . uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder, $fileName);

                applicants_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';

    }

    //delete the temporary files
    public function _tmp_file_delete()
    {
        $get_path = request()->getContent();

        $split_File_Path = explode("<", $get_path);

        $filePath = $split_File_Path[0];

        $tmp_file = applicants_tempfiles::where('folder', $filePath)->first();
        if ($tmp_file) {
            Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            return response('');
        }
    }

    //saved the attachments in the
    public function saved_email_attachments(Request $request)
    {
        try
        {
            $get_file_id = [];
            $get_file_id = $request->email_attachments;

            if($get_file_id)
            {
                foreach($get_file_id as $file_id)
                {
                    $concat_id = explode("<",$file_id);
                    $file_path = $concat_id[0];

                    $attachment = applicants_tempfiles::where('folder', $file_path)->get();

                    foreach($attachment as $attachments)
                    {
                        $data = [
                            'folder' =>  $attachments->folder,
                            'filename' => $attachments->filename,
                            'created_at' => Auth::user()->employee_id,
                        ];

                        $save_data = email_attachments::create($data);

                        Storage::copy('public/tmp/' .$attachments->folder. '/' . $attachments->filename, 'public/documents/email/' . $attachments->folder .'/'. $attachments->filename);
                        Storage::deleteDirectory('public/tmp/' .$attachments->folder);
                        $delete = applicants_tempfiles::where('folder', $file_path)->delete();
                    }
                }
            }

        }catch(Exception $e)
        {
            dd($e);
        }
    }

}


