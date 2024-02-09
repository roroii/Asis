<?php

namespace App\Http\Controllers\ApplicationController;

use App\Http\Controllers\Controller;
use App\Models\applicant\applicants;
use App\Models\applicant\applicants_academic_bg;
use App\Models\applicant\applicants_address;
use App\Models\applicant\applicants_attachments;
use App\Models\applicant\applicants_list;
use App\Models\applicant\applicants_tempfiles;
use App\Models\document\doc_file_attachment;
use App\Models\document\doc_notification;
use App\Models\document\doc_tempfiles;
use App\Models\Hiring\tbl_hiringavailable;
use App\Models\Hiring\tbl_hiringlist;
use App\Models\Hiring\tbl_job_doc_requirements;
use App\Models\Hiring\tbljob_doc_rec;
use App\Models\Hiring\tbljob_info;
use App\Models\ref_brgy;
use App\Models\ref_citymun;
use App\Models\ref_province;
use App\Models\ref_region;
use App\Models\system\default_settingNew;
use App\Models\tblemployee;
use App\Models\TemporaryFile;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Session;


class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function application()
    {
        return view('application.application');
    }

    public function applicant_list()
    {
        return view('application.applicant_list');
    }

    public function load_applicants()
    {
        $tres = [];
        $profile_pic = '';
        $application_count = '';

        $applicants = applicants_list::with(['get_profile', 'get_job_info', 'get_status'])
//                    ->where('active', 1)
            ->where('applicant_status', 1)
            ->orWhere('applicant_status', 4)
            ->orWhere('applicant_status', 12)
            ->get()
            ->unique('applicant_id');

        if ($applicants) {
            foreach ($applicants as $dt) {
                $applicant_id = $dt->applicant_id;
                $profile = $dt->get_profile;
                $date_applied = $dt->created_at;
                $job_ref_no = $dt->jobref_no;

                if ($profile) {
                    $lastname = $profile->lastname;
                    $firstname = $profile->firstname;
                    $mi = $profile->mi;
                    $extension = $profile->extension;
                    $mobile_number = $profile->mobile_number;

                    if($profile->email)
                    {
                        $email = $profile->email;
                    }else
                    {
                        $email = 'N/A';
                    }

                    if ($profile->image == null) {
                        $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
                        $get_image = $query->image;

                        $profile_pic = url('') . "/uploads/settings/" . $get_image;

                    } else {
                        $profile_pic = url('') . "/uploads/profiles/" . $profile->image;
                    }
                } else {
                    $lastname = "N/A";
                    $firstname = "N/A";
                    $mi = "N/A";
                    $extension = "N/A";
                    $mobile_number = "N/A";
                    $email = "N/A";
                }

                $position = "N/A";
//                dd($dt->get_job_info);

                if ($dt->get_job_info) {
                    if ($dt->get_job_info->get_Position) {
                        $job = $dt->get_job_info->get_Position;

                        $position = $job->emp_position;

                    }
                }


                if ($dt->get_status->name) {
                    $hiring_status = $dt->get_status->name;
                    $hiring_status_class = $dt->get_status->class;
                } else {
                    $hiring_status = "N/A";
                    $hiring_status_class = "secondary";
                }

                $td = [

//                    "application_count" => $application_count,
                    "job_ref_no" => $job_ref_no,
                    "applicant_id" => $applicant_id,
                    "profile_pic" => $profile_pic,
                    "lastname" => $lastname,
                    "firstname" => $firstname,
                    "mi" => $mi,
                    "extension" => $extension,
                    "mobile_number" => $mobile_number,
                    "email" => $email,

                    "position" => $position,
                    "hiring_status" => $hiring_status,
                    "hiring_status_class" => $hiring_status_class,
                    "date_applied" => $date_applied,

                ];

                $tres[count($tres)] = $td;
            }
        }
        echo json_encode($tres);
    }

    public function get_applicant_profile(Request $request)
    {
        $applied_for = '';
        $attachments_list = '';

        $profile = applicants_list::with('get_job_info', 'get_attachments', 'get_status')
            ->where('applicant_id', $request->applicant_id)
            ->where('applicant_status', '!=', 11)
            ->get();

        if ($profile) {
            foreach ($profile as $dt) {
                if ($dt->get_job_info) {
                    $job = $dt->get_job_info->get_Position;

                    $position = $job->emp_position;
                    $position_ref_num = $dt->get_job_info->jobref_no;

                    $status_name = $dt->get_status->name;
                    $status_class = $dt->get_status->class;


                    $applied_for .=
                        "<tr>
                            <td>
                                <a href='javascript:;void(0)' class='flex underline decoration-dotted items-center mt-4' data-applicant-id=" . $request->applicant_id . " data-pos-ref=" . $position_ref_num . "> <i class='fa-solid fa-circle-dot w-2 h-2 mr-2'></i>$position </a>
                            </td>
                            <td>
                                <div class='flex justify-center items-center whitespace-nowrap text-" . $status_class . "'><div class='w-2 h-2 bg-" . $status_class . " rounded-full mr-3'></div>$status_name</div>
                            </td>
                            <td>
                                <div class='flex justify-center items-center'>
                                    <a href='javascript:;' data-applicant-id=" . $request->applicant_id . " data-pos-ref=" . $position_ref_num . " data-pos-title=" . $position . " class='btn btn-outline-secondary btn_applied_position text-center mr-2'><i  class='w-4 h-4 text-secondary fa-solid fa-file'></i></a>
                                </div>
                            </td>
                        </tr>";
                }
            }
        }

        return json_encode(array(

            "applied_for" => $applied_for,

        ));
    }

    public function get_job_attachments(Request $request)
    {
        $attachments_list = '';
        $download_all_btn = '';
        $_path = '';

        $attachments = applicants_attachments::where('applicant_id', $request->applicant_id)->where('jobref_no', $request->position_ref_num)->get();

        if ($attachments) {
            foreach ($attachments as $dt) {

                $attachment_id = $dt->id;
                $attachment_path = Crypt::encrypt($dt->attachment_path);
                $attachment_name = $dt->attachment_name;

                $_path .= $attachment_path . ",";
                $attachments_list .=
                    "<tr>
                        <td>
                            <input type='text' style='display: none' name='td_attachment_path[]' value=" . $attachment_path . ">
                            <a href='javascript:;void(0)' class='flex underline decoration-dotted items-center mt-4' data-path=" . $attachment_path . " data-pos-id=" . $attachment_id . "> <i class='fa-solid fa-circle-dot w-2 h-2 mr-2'></i>$attachment_name </a>
                        </td>
                        <td>
                            <div class='flex justify-center items-center'>
                                <a href='/application/view/attachments/" . $attachment_path . "' target='_blank' class='btn btn-outline-secondary download_attachments text-center mr-2'><i  class='w-4 h-4 text-success fa-solid fa-eye'></i></a>
                                <a href='/application/download/attachments/" . $attachment_path . "' target='_blank' data-path=" . $attachment_path . " class='btn btn-outline-secondary download_attachments text-center'><i  class='w-4 h-4 text-secondary fa-solid fa-download'></i></a>
                            </div>
                        </td>
                    </tr>";

                $download_all_btn = '<a href="/application/download/all/attachments/' . $_path . '" target="_blank" data-path=".$attachment_path." id="btn_download_all" type="button" class="btn btn-outline-secondary"> Download All </a>';

            }
        }

        return json_encode(array(

            "attachments_list" => $attachments_list,
            "download_all_btn" => $download_all_btn,

        ));
    }

    public function get_application_data(Request $request)
    {
        $attachments_list = '';
        $position_option = '';
        $applied_for = '';
        $_path = '';

        $attachments = applicants_attachments::with('get_job_info.get_Position')->where('jobref_no', $request->position_ref_num)->where('applicant_id', $request->applicant_id)->get();

        $positions = applicants_list::with('get_job_info.get_Position', 'get_attachments', 'get_status')
            ->where('applicant_id', $request->applicant_id)
            ->where('applicant_status', '!=', 11)
            ->where('active', 1)
            ->get();

        if ($positions) {
            foreach ($positions as $post) {
                if ($post->get_job_info) {
                    $pos = $post->get_job_info->get_Position;

                    $job_ref_no = $post->jobref_no;
                    $applicant_id = $post->applicant_id;
                    $position = $pos->emp_position;

                    $status_name = $post->get_status->name;
                    $status_class = $post->get_status->class;

                    $position_option .= "<option data-applicant-id=" . $request->applicant_id . " value=" . $job_ref_no . ">$position</option>";

                    $applied_for .=
                        "<tr>
                                <td>
                                    <a href='javascript:;' class='flex underline decoration-dotted items-center mt-2 btn_applied_position' data-applicant-id=" . $applicant_id . " data-pos-ref=" . $job_ref_no . " data-position=" . $position . "> <i class='fa-solid fa-circle-dot w-2 h-2 mr-2'></i>$position </a>
                                </td>
                                <td>
                                    <div class='flex justify-center items-center whitespace-nowrap text-" . $status_class . "'><div class='w-2 h-2 bg-" . $status_class . " rounded-full mr-3'></div>$status_name</div>
                                </td>
                                <td>
                                    <div class='flex justify-center items-center'>

                                        <a href='javascript:;' data-applicant-id=" . $applicant_id . " data-pos-ref=" . $job_ref_no . " data-pos-title=" . $position . " class='btn btn-outline-secondary btn_view_attach_file text-center mr-2 tooltip' title='Attached Files'><i  class='w-4 h-4 text-secondary fa-solid fa-file'></i></a>

                                        <div id='application_approve_dd' class='btn btn-outline-secondary flex items-center justify-center border dark:border-darkmode-400 text-slate-400 zoom-in tooltip dropdown' title='More Action'>
                                            <a class='flex justify-center items-center' href='javascript:;' aria-expanded='false' data-tw-toggle='dropdown'> <i class='w-4 h-4 fa fa-ellipsis-h items-center text-center text-success'></i> </a>
                                            <div class='dropdown-menu w-40'>
                                                <div class='dropdown-content'>
                                                    <a href='javascript:;' data-status=" . $status_name . " data-applicant-id=" . $applicant_id . " data-pos-ref=" . $job_ref_no . " data-pos-title=" . $position . " data-action-type='approve' class='dropdown-item btn_approve tooltip' title='Approve Application'> <i class='fa-solid fa-thumbs-up w-4 h-4 mr-2 text-success'></i>Approve</a>
                                                    <a href='javascript:;' data-applicant-id=" . $applicant_id . " data-pos-ref=" . $job_ref_no . " data-pos-title=" . $position . " data-action-type='disapprove' class='dropdown-item btn_disapprove tooltip' title='Disapprove Application'> <i class='fa-solid fa-thumbs-down w-4 h-4 mr-2 text-danger'></i>Disapprove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                }
            }
        }

        return json_encode(array(

            "attachments_list" => $attachments_list,
            "applied_for" => $applied_for,

        ));
    }

    public function view_attachments($path)
    {
        $file_path = Crypt::decrypt($path);

        $get_attachments = applicants_attachments::where('attachment_path', $file_path)->get();

        foreach ($get_attachments as $data) {
            $fileName = $data->attachment_name;
        }

        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $pathToFile = $storagePath . "public/applicant/attachments/" . $file_path . "/" . $fileName;

        return response()->file($pathToFile);
    }

    public function download_attachments($path)
    {
        $file_path = Crypt::decrypt($path);

        $get_attachments = applicants_attachments::where('attachment_path', $file_path)->get();

        foreach ($get_attachments as $data) {
            $fileName = $data->attachment_name;
        }

        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $pathToFile = $storagePath . "public/applicant/attachments/" . $file_path . "/" . $fileName;

        return response()->download($pathToFile, $fileName);
    }

    public function approve_application(Request $request)
    {
        $date_today = GLOBAL_DATE_TIME_GENERATOR();

        if ($request->applicant_id) {
            if ($request->action_type == "approve") {
                applicants_list::where('applicant_id', $request->applicant_id)->where('jobref_no', $request->job_ref_no)->update([
                    'applicant_status' => 11,
                    'application_note' => $request->application_note,
                    'approval_date' => $date_today,
                    'approved_by' => Auth::user()->employee,
                ]);

                $get_list_id = applicants_list::where('applicant_id', $request->applicant_id)->where('jobref_no', $request->job_ref_no)->first();

                $subject = 'application_approved';
                $subject_id = $get_list_id->id;
                $sender_type = 'user';
                $sender_id = Auth::user()->employee;
                $target_id = $request->applicant_id;
                $target_type = 'applicants';
                $notif_content = $request->application_note;
                $purpose = 'inform';

                createNotification($subject, $subject_id, $sender_type, $sender_id, $target_id, $target_type, $notif_content);

                return response()->json([
                    'status' => 200,
                    'applicant_id' => $request->applicant_id,
                    'job_ref_no' => $request->job_ref_no,
                    'message' => 'Application has been approved',
                ]);
            }
        }
    }

    public function disapprove_application(Request $request)
    {
        $date_today = GLOBAL_DATE_TIME_GENERATOR();

        if ($request->action_type == "disapprove") {
            $applicant_list_id = applicants_list::where('applicant_id', $request->applicant_id)->where('jobref_no', $request->job_ref_no)->update([
                'applicant_status' => 12,
                'application_note' => $request->application_note,
                'approval_date' => $date_today,
                'approved_by' => Auth::user()->employee,
            ]);

            $get_list_id = applicants_list::where('applicant_id', $request->applicant_id)->where('jobref_no', $request->job_ref_no)->first();

            $subject = 'application_disapproved';
            $subject_id = $get_list_id->id;
            $sender_type = 'user';
            $sender_id = Auth::user()->employee;
            $target_id = $request->applicant_id;
            $target_type = 'applicants';
            $notif_content = $request->application_note;
            $purpose = 'inform';

            createNotification($subject, $subject_id, $sender_type, $sender_id, $target_id, $target_type, $notif_content, $purpose);

            return response()->json([
                'status' => 200,
                'applicant_id' => $request->applicant_id,
                'job_ref_no' => $request->job_ref_no,
                'message' => 'Application has been disapproved',
            ]);
        }
    }


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

    public function get_available_positions(Request $request)
    {
        $tres = [];

        $get_job_info = tbljob_info::with(['get_profile', 'get_hr_profile', 'get_remarks', 'get_job_doc_requirements', 'get_educ_requirements', 'get_SG', 'get_Position', 'get_position_type', 'get_agency_employees'])
            ->where('active', true)
            ->Where('status', 14)
            ->orWhere('status', 13)
            ->latest('id')
            ->get();


        foreach ($get_job_info as $index => $pos) {

            $assign_agency = 'N/A';
            $salary = 'N/A';
            $email_through = 'N/A';
            $extension = 'N/A';
            $email = 'N/A';
            $count_doc_required = '';
            $btn_html = '';

            $job_index = $index;
            $position_ref = $pos->jobref_no;
            $email_address = $pos->email_add;
            $address = $pos->address;

            if ($pos->assign_agency) {
                $assign_agency = $pos->assign_agency;
            } else {
                $position_ref = 'N/A';
            }

            if ($pos->assign_agency) {
                $salary = $pos->salary;
            } else {
                $salary = 'N/A';
            }

            if ($pos->get_hr_profile) {
                $lastname = $pos->get_hr_profile->lastname;
                $firstname = $pos->get_hr_profile->firstname;
                $mi = $pos->get_hr_profile->mi;
                $extension = $pos->get_hr_profile->extension;

                $email_through = $firstname . " " . $mi . " " . $lastname;
                $email = $pos->get_hr_profile->email;
//                $email_through = $pos->get_profile->email_through;

            }else if($pos->get_profile)
            {
                $lastname = $pos->get_profile->lastname;
                $firstname = $pos->get_profile->firstname;
                $mi = $pos->get_profile->mi;
                $extension = $pos->get_profile->extension;
                $email_through = $firstname . " " . $mi . " " . $lastname;
                $email = $pos->get_profile->email;

            } else {

                $lastname = '';
                $firstname = '';
                $mi = '';
                $extension = '';

                $email_through = '';
                $email = '';

            }

//            dd($pos->get_agency_employees->get_position);
            if ($pos->get_agency_employees)
            {
                if ($pos->get_agency_employees->get_designation)
                {
                    $hr_position = $pos->get_agency_employees->get_designation->userauthority;
                }
                else
                {
                    if($pos->get_agency_employees->get_position)
                    {
                        $hr_position = $pos->get_agency_employees->get_position->emp_position;
                    }else
                    {
                        $hr_position = 'No position yet!';
                    }

                }
            } else
            {
                $hr_position = 'No Data';
            }

            $post_date = $pos->post_date;
            $close_date = $pos->close_date;

            $status = $pos->status;

            if ($status == "14") {
                $btn_html = '<button id="btn_closed_pos" data-tw-toggle="modal" data-tw-target="#position_info" class="btn fle btn-danger-soft w-32 mr-4 mb-2"> <i class="w-4 h-4 mr-2 fa-solid fa-stop"></i> Closed </button>';

            } else if ($status == "13") {

                $btn_html = '<button id="btn_apply_job_position" class="btn fle btn-primary w-32 mr-4 mb-2"> <i class="w-4 h-4 mr-2 fa-solid fa-paper-plane"></i> Apply </button>';

            } else if ($status == "1") {

                $btn_html = '<button class="btn fle btn-disabled w-32 mr-4 mb-2"> <i class="w-4 h-4 mr-2 fa-solid fa-pause"></i> Soon to Open </button>';

            }

            $pos_title = 'N/A';
            $pos_type = 'N/A';
            $sg = 'N/A';
            $remarks = 'N/A';
            $doc_req = '';

            $item_no = 'N/A';
            $eligibility = 'N/A';
            $educ = 'N/A';
            $work_ex = 'N/A';
            $competency = 'N/A';
            $training = 'N/A';

            if ($pos->get_Position) {
                $pos_title = $pos->get_Position->emp_position;
            }

            if ($pos->get_position_type) {
                $pos_type = $pos->get_position_type->positiontype;
            }

            if ($pos->get_SG) {
                $sg = $pos->get_SG->id;
                $sg_name = $pos->get_SG->salarygrade;
            }

            if ($pos->get_remarks) {
                $remarks = $pos->get_remarks->remarks;
            }

            if ($pos->get_job_doc_requirements) {
                foreach ($pos->get_job_doc_requirements as $index => $req) {
                    $count = $index + 1;
                    $doc_req .= '<div class="m-l-5 text-slate-600 dark:text-slate-500 leading-relaxed">' . $count . '.<span class="ml-1">' . $req->doc_requirements . '</span></div>';
                    $count_doc_required = $req->count();

                }
            }

            if ($pos->get_educ_requirements) {
                $item_no = $pos->get_educ_requirements->item_no;
                $eligibility = $pos->get_educ_requirements->eligibility;
                $educ = $pos->get_educ_requirements->educ;
                $work_ex = $pos->get_educ_requirements->work_ex;

                if($pos->get_educ_requirements->get_competency)
                {
                    $competency = $pos->get_educ_requirements->get_competency->skill;
                }else
                {
                    $competency = 'No Data';
                }

                $training = $pos->get_educ_requirements->training;

            }else
            {
                $item_no        = '';
                $eligibility    = '';
                $educ           = '';
                $work_ex        = '';
                $competency     = '';
                $training       = '';
            }

            $td = [

                "index" => $job_index,
                "position_ref_num" => $position_ref,
                "assign_agency" => $assign_agency,
                "pos_title" => $pos_title,
                "salary" => $salary,
                "post_date" => $post_date,
                "close_date" => $close_date,
                "status" => $status,
                "pos_type" => $pos_type,
                "sg" => $sg,
                "remarks" => $remarks,
                "doc_req" => $doc_req,
                "item_no" => $item_no,
                "eligibility" => $eligibility,
                "educ" => $educ,
                "work_ex" => $work_ex,
                "competency" => $competency,
                "training" => $training,

//                "full_name" => $full_name,
                "extension" => $extension,
                "email" => $email,
                "email_through" => $email_through,
                "hr_position" => $hr_position,

                "count_doc_required" => $count_doc_required,
                "btn_html" => $btn_html,
                "email_address" => $email_address,
                "address" => $address,

            ];

            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }

    public function apply_job(Request $request)
    {

        $tres = [];
        $reference_number = $request->reference_number;
        $applicant_id = '';
        $document_type = '';

        $check_applicant_list = applicants_list::
        where('applicant_id', Auth::user()->id)
            ->where('jobref_no', $reference_number)
            ->where('active', true)
            ->first();

        $get_doc_requirements = tbl_job_doc_requirements::where('job_info_no', $reference_number)->get();

        if ($get_doc_requirements) {
            foreach ($get_doc_requirements as $requirements) {

                $document_type = $requirements->id;
                $type_name = $requirements->doc_type;

                $td = [
                    "document_type" => $document_type,
                    "pond_name" => $type_name,
                ];

                $tres[count($tres)] = $td;
            }
            if (!$document_type) {
                return response()->json([
                    'status' => "NO_ATTACHMENT",
                    'message' => "No Document Requirements Found!",
                ]);
            }
        }

        if (!$check_applicant_list) {
            return response()->json([
                'status' => 200,
                'doc_type' => $tres,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "You have applied to this position!",
            ]);
        }

    }

    public function submit_application(Request $request)
    {

        $job_ref_number = $request->input('position_ref_number');
        $attachment_type = $request->input('attachment_type');
        $attachment_id = $request->input('attachment_id');
        $applicant_id = Auth::user()->id;

        foreach ($attachment_id as $index => $id) {
            $folder_name = $request->input($id);

            foreach ($folder_name as $getPath) {

                $splitDocFilePath = explode("<", $getPath);

                $filePath = $splitDocFilePath[0];

                $getFolder = applicants_tempfiles::where('folder', $filePath)->first();

                $insert_tor_attachment = [
                    'applicant_id' => $applicant_id,
                    'jobref_no' => $job_ref_number,
                    'attachment_type' => $attachment_type[$index],
                    'attachment_path' => $getFolder->folder,
                    'attachment_name' => $getFolder->filename,
                    'active' => true,
                ];
                applicants_attachments::create($insert_tor_attachment);

                Storage::copy('public/tmp/' . $getFolder->folder . '/' . $getFolder->filename, 'public/applicant/attachments/' . $getFolder->folder . '/' . $getFolder->filename);

                Storage::deleteDirectory('public/tmp/' . $getFolder->folder);

                applicants_tempfiles::where('folder', $getFolder->folder)->delete();
            }
        }

        $apply = [
            'jobref_no' => $request->position_ref_number,
            'applicant_id' => $applicant_id,
            'applicant_status' => 1,
            'active' => true,
        ];
        applicants_list::create($apply);

        return response()->json([
            'status' => 200,
        ]);
    }




    public function _tmp_Upload_pds(Request $request)
    {
        if ($request->hasFile('personal_data_sheet')) {
            foreach ($request->file('personal_data_sheet') as $file) {
                $fileName = $file->getClientOriginalName();

                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder, $fileName);

                applicants_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }

    public function _tmp_Upload_prs(Request $request)
    {
        if ($request->hasFile('prs')) {
            foreach ($request->file('prs') as $file) {
                $fileName = $file->getClientOriginalName();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder, $fileName);

                applicants_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }

    public function _tmp_Upload_cs(Request $request)
    {
        if ($request->hasFile('cs')) {
            foreach ($request->file('cs') as $file) {
                $fileName = $file->getClientOriginalName();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder, $fileName);

                applicants_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }

    public function _tmp_Upload_tor(Request $request)
    {
        if ($request->hasFile('tor')) {
            foreach ($request->file('tor') as $file) {
                $fileName = $file->getClientOriginalName();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder, $fileName);

                applicants_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }

    public function _tmp_Delete_applicant_files()
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

    public function _tmp_Delete()
    {
        $get_doc_path = request()->getContent();

        $splitDocFilePath = explode("<", $get_doc_path);

        $filePath = $splitDocFilePath[0];

        $tmp_file = applicants_tempfiles::where('folder', $filePath)->first();
        if ($tmp_file) {
            //Remove picture from public/uploads
            $fp = public_path("uploads/profiles") . "\\" . $tmp_file->filename;
            if (file_exists($fp)) {
                unlink($fp);
            }

            Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            return response('');
        }
    }

    public function _tmp_diploma_Upload(Request $request)
    {
        if ($request->hasFile('diploma')) {

            foreach ($request->file('diploma') as $file) {
                $fileName = $file->getClientOriginalName();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder, $fileName);

                applicants_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }

    public function _tmp_certificate_Upload(Request $request)
    {
        if ($request->hasFile('certificates')) {

            foreach ($request->file('certificates') as $file) {
                $fileName = $file->getClientOriginalName();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder, $fileName);

                applicants_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }

    public function _tmp_profile_pic_Upload(Request $request)
    {
        if ($request->hasFile('profile_pic')) {

            foreach ($request->file('profile_pic') as $file) {

                $get_file_type = $file->getClientMimeType();
                $explode_file_type = explode("/", $get_file_type);
                $file_type = $explode_file_type[1];

//                $fileName = $file->getClientOriginalName();
                $fileName = date("YmdHis") . '.' . $file_type;
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder, $fileName);

                //Upload applicants avatar to public folder
//                $destinationPath = 'uploads/profiles/'.$folder;
                $destinationPath = 'uploads/profiles/';
//                $my_image = $file->getClientOriginalName();
                $file->move(public_path($destinationPath), $fileName);

                applicants_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }

    public function get_address_via_region(Request $request)
    {
        $brgy_option = '';
        $province_option = '';
        $municipality_option = '';

        $region = ref_region::
        with('get_province', 'get_city_mun', 'get_brgy')
            ->where('regCode', $request->regCode)->get();

        foreach ($region as $prov) {
            foreach ($prov->get_province as $prov) {
                $province_option .= '<option data-ass-type="desig" value="' . $prov->provCode . '">' . $prov->provDesc . '</option>';
            }

            foreach ($prov->get_city_mun as $city_mun) {
                $municipality_option .= '<option data-ass-type="desig" value="' . $city_mun->citymunCode . '">' . $city_mun->citymunDesc . '</option>';
            }
            foreach ($prov->get_brgy as $brgy) {
                $brgy_option .= '<option data-ass-type="desig" value="' . $brgy->brgyCode . '">' . $brgy->brgyDesc . '</option>';
            }
        }

        return json_encode(array(

            "brgy_option" => $brgy_option,
            "province_option" => $province_option,
            "municipality_option" => $municipality_option,

        ));
    }

    public function get_address_via_province(Request $request)
    {
        $brgy_option = '';
        $region_option = '';
        $municipality_option = '';

        $province = ref_province::
        with('get_region', 'get_city_mun', 'get_brgy')
            ->where('provCode', $request->provCode)->get();

        foreach ($province as $prov) {
            foreach ($prov->get_region as $region) {
                $region_option .= '<option data-ass-type="desig" value="' . $region->regCode . '">' . $region->regDesc . '</option>';
            }
            foreach ($prov->get_city_mun as $city_mun) {
                $municipality_option .= '<option data-ass-type="desig" value="' . $city_mun->citymunCode . '">' . $city_mun->citymunDesc . '</option>';
            }
            foreach ($prov->get_brgy as $brgy) {
                $brgy_option .= '<option data-ass-type="desig" value="' . $brgy->brgyCode . '">' . $brgy->brgyDesc . '</option>';
            }
        }

        return json_encode(array(

            "region_option" => $region_option,
            "municipality_option" => $municipality_option,
            "brgy_option" => $brgy_option,

        ));
    }

    public function get_address_via_municipality(Request $request)
    {
        $brgy_option = '';
        $region_option = '';
        $province_option = '';

        $municipality = ref_citymun::
        with('get_region', 'get_province', 'get_brgy')
            ->where('citymunCode', $request->city_munCode)->get();

        foreach ($municipality as $mun) {
            foreach ($mun->get_region as $region) {
                $region_option .= '<option data-ass-type="desig" value="' . $region->regCode . '">' . $region->regDesc . '</option>';
            }
            foreach ($mun->get_province as $prov) {
                $province_option .= '<option data-ass-type="desig" value="' . $prov->provCode . '">' . $prov->provDesc . '</option>';
            }
            foreach ($mun->get_brgy as $brgy) {
                $brgy_option .= '<option data-ass-type="desig" value="' . $brgy->brgyCode . '">' . $brgy->brgyDesc . '</option>';
            }
        }

        return json_encode(array(

            "region_option" => $region_option,
            "province_option" => $province_option,
            "brgy_option" => $brgy_option,

        ));
    }

    public function test_(Request $request)
    {
        $get_data = doc_notification::where('active',1)
                        ->where('seen', 0)
                        ->where('target_id',Auth::user()->id)
                        ->orWhere('target_id',Auth::user()->employee)
                        ->get();


        dd($get_data);
    }

//    public function get_available_positions(Request $request)
//    {
//        $option_available_pos = '';
//
//        $today = date('Y/m/d');
//
//        $_closed_pos = tbl_hiringavailable::where('active', true)
//            ->where('hiring_start', '<=', $today)
//            ->where('status', false)
//            ->get();
//
//        $_opened_pos = tbl_hiringavailable::where('active', true)
//            ->where('hiring_until', '<', $today)
//            ->where('status', true)
//            ->get();
//
//        if ($_closed_pos)
//        {
//            foreach ($_closed_pos as $pos)
//            {
//                tbl_hiringavailable::where('id', $pos->id)->update([
//                    'status' => true,
//                ]);
//            }
//        }
//
//        if ($_opened_pos)
//        {
//            foreach ($_opened_pos as $pos)
//            {
//                tbl_hiringavailable::where('id', $pos->id)->update([
//                    'status' => false,
//                ]);
//            }
//        }
//
//
//        $get_available_pos = tbl_hiringavailable::with(['get_available_Position', 'get_sg'])
//            ->where('active', true )
//            ->where('status', true)
//            ->get();
//
//        foreach ($get_available_pos as $pos)
//        {
//            $option_available_pos .= '<a class="flex rounded-lg items-center px-4 py-2 text-white font-medium" href=""><div class="flex-1 truncate">'.$pos->emp_position.'</div></a>';
//
//        }
//
//        return json_encode(array(
//
//            "option_Value"=>$option_available_pos,
//
//        ));
//    }
}
