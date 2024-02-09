<?php

namespace App\Http\Controllers\e_hris_controllers\ProfileController;

use App\Http\Controllers\Controller;
use App\Models\applicant\applicants_tempfiles;
use App\Models\ASIS_Models\file_upload\temp_files;
use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\ASIS_Models\posgres\portal\srgb\student;
use App\Models\ASIS_Models\signature\user_signature_model;
use App\Models\ASIS_Models\signature\user_tempfiles_model;
use App\Models\e_hris_models\PDS\pds_address;
use App\Models\e_hris_models\PDS\pds_child_list;
use App\Models\e_hris_models\PDS\pds_cs_eligibility;
use App\Models\e_hris_models\PDS\pds_educational_bg;
use App\Models\e_hris_models\PDS\pds_family_bg;
use App\Models\e_hris_models\PDS\pds_government_id;
use App\Models\e_hris_models\PDS\pds_learning_development;
use App\Models\e_hris_models\PDS\pds_other_information;
use App\Models\e_hris_models\PDS\pds_references;
use App\Models\e_hris_models\PDS\pds_special_skills;
use App\Models\e_hris_models\PDS\pds_voluntary_work;
use App\Models\e_hris_models\PDS\pds_work_exp;
use App\Models\e_hris_models\ref\ref_brgy;
use App\Models\e_hris_models\ref\ref_citymun;
use App\Models\employee\employee_hr_details;
use App\Models\system\default_settingNew;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PDF;
use Response;
use Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('asis_auth');
    }

    public function index()
    {

        return view('my_Profile.profile');
    }

    public function load_profile(Request $request)
    {

        $student_data = User::where('studid', Auth::user()->studid)->first();
        $pg_student_data = student::where('studid', Auth::user()->studid)->first();

        if($student_data->profile_pic)
        {
            $profile_pic = url('') . "/uploads/profiles/" . $student_data->profile_pic;
        }else
        {
            $profile_pic = GLOBAL_PROFILE_PICTURE_GENERATOR();
        }


        return json_encode(array(

            'raw_image' => $student_data->profile_pic,
            'profile_pic' => $profile_pic,
            'full_name' => $student_data->fullname,
            'contact_number' => $pg_student_data->studcontactno,
            'email' => $student_data->email,
            'password' => $student_data->password,

            'profile_firstname' => mb_convert_encoding($pg_student_data->studfirstname, 'UTF-8', 'ISO-8859-1'),
            'profile_midname' => mb_convert_encoding($pg_student_data->studmidname, 'UTF-8', 'ISO-8859-1'),
            'profile_lastname' => mb_convert_encoding($pg_student_data->studlastname, 'UTF-8', 'ISO-8859-1'),
            'profile_ext' => mb_convert_encoding($pg_student_data->studsuffix, 'UTF-8', 'ISO-8859-1'),

        ));
    }

    public function temp_upload_profile_picture(Request $request)
    {
        $student_data = student::where('studid', Auth::user()->studid)->first();

        $last_name = $student_data->studlastname;

        if ($request->hasFile('up_profile_pic')) {

            foreach ($request->file('up_profile_pic')as $file )
            {

                $get_file_type = $file->getClientMimeType();
                $explode_file_type = explode("/", $get_file_type);
                $file_type = $explode_file_type[1];

                $fileName = $last_name.'-'.date("YmdHis").'.'.$file_type;
                $folder = $last_name.'-'.uniqid('', false) . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder,$fileName);

                $destinationPath = 'uploads/profiles/';
                $file->move(public_path($destinationPath), $fileName);

                temp_files::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }


    public function temp_upload_e_signature(Request $request)
    {

        $get_profile = student::where('studid', Auth::user()->studid)->first();

        $last_name = $get_profile->studid;

        if ($request->hasFile('e_signature'))
        {
            $file = $request->file('e_signature');
            $get_file_type = $file->getClientMimeType();
            $explode_file_type = explode("/", $get_file_type);
            $file_type = $explode_file_type[1];

            $fileName = $last_name.'-'.date("YmdHis").'.'.$file_type;
            $folder = $last_name.'-'.uniqid('', false) . '-' . now()->timestamp;
            $file->storeAs('public/tmp/' . $folder,$fileName);

            $destinationPath = 'uploads/e_signature/';
            $file->move(public_path($destinationPath), $fileName);

            user_tempfiles_model::create([
                'folder' => $folder,
                'filename' => $fileName]);

            return $folder;
        }
        return '';
    }
    public function temp_delete_e_signature(Request $request){

        $get_doc_path = request()->getContent();

        $splitDocFilePath = explode("<", $get_doc_path);

        $filePath = $splitDocFilePath[0];

        $tmp_file = user_tempfiles_model::where('folder', $filePath)->first();
        if($tmp_file)
        {
            //Remove picture from public/uploads
            $fp = public_path("uploads/e_signature") . "\\" . $tmp_file->filename;
            if(file_exists($fp)) {
                unlink($fp);
            }

            Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            return response('');
        }
    }
    public function load_e_signature(Request $request)
    {
        $student_id = Auth::user()->studid;

        $load_e_sig = user_signature_model::where('studid', $student_id)->first();

        if($load_e_sig)
        {
            if($load_e_sig->signature)
            {
                $e_signature = url('') . "/uploads/e_signature/" . $load_e_sig->signature;
                $e_signature_raw = $load_e_sig->signature;

            }else
            {
                $e_signature = url('') . "/dist/images/preview-6.jpg";
                $e_signature_raw = '';
            }

        }else
        {
            $e_signature = url('') . "/dist/images/preview-6.jpg";
            $e_signature_raw = '';
        }

        return json_encode(array(

            'e_signature' => $e_signature,
            'e_signature_raw' => $e_signature_raw,
        ));
    }
    public function delete_e_signature(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $get_old_pic = employee::where('agencyid', $employee_id)->first();

        if($get_old_pic)
        {
            employee::where('agencyid', $employee_id)->update([
                'e_signature' => '',
            ]);

            $fp = public_path("uploads/e_signature") . "\\" . $get_old_pic->e_signature;
            if(file_exists($fp))
            {
                unlink($fp);
            }


            return json_encode(array(

                "status" => 200,

            ));
        }
    }
    public function save_e_signature(Request $request)
    {
        $old_e_signature = $request->input('old_e_signature_value');

        $student_id = Auth::user()->studid;

        //Remove picture from public/uploads
        if($old_e_signature)
        {
            $get_old_signature = user_signature_model::where('studid', $student_id)->where('signature', $old_e_signature)->first();

            if($get_old_signature)
            {
                $fp = public_path("uploads/e_signature") . "\\" . $get_old_signature->signature;
                if(file_exists($fp)) {
                    unlink($fp);
                }
            }
        }

        $e_signature = $request->input('e_signature');

        $splitDocFilePath = explode("<", $e_signature);

        $filePath = $splitDocFilePath[0];

        $get_temp_e_sig = user_tempfiles_model::where('folder', $filePath)->first();

        user_signature_model::updateOrCreate(
            [
                'studid'=> $student_id,
            ],

            [
                'studid'=> $student_id,
                'signature'=> $get_temp_e_sig->filename,
                'active' => 1,
            ]
        );



        Storage::deleteDirectory('public/tmp/' . $get_temp_e_sig->folder);
        user_tempfiles_model::where('folder', $get_temp_e_sig->folder)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }
    public function download_e_signature($e_signature_value)
    {
        $employee_id = Auth::user()->employee;
        $signature_path = trim($e_signature_value);

        $get_e_signature = employee::where('agencyid', $employee_id)->where('e_signature', $signature_path)->first();

        if ($get_e_signature)
        {

            $file = public_path("uploads/e_signature") . "\\" . $get_e_signature->e_signature;

            return Response::download($file);

        }else
        {
            return json_encode(array(

                'status' => 500,
                'message' => 'Something went wrong',
            ));
        }

    }



    public function delete_profile_picture(Request $request){

        $get_doc_path = request()->getContent();

        $splitDocFilePath = explode("<", $get_doc_path);

        $filePath = $splitDocFilePath[0];

        $tmp_file = temp_files::where('folder', $filePath)->first();
        if($tmp_file)
        {
            //Remove picture from public/uploads
            $fp = public_path("uploads/profiles") . "\\" . $tmp_file->filename;
            if(file_exists($fp)) {
                unlink($fp);
            }

            Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            return response('');
        }
    }

    public function save_profile_picture(Request $request)
    {
        $old_profile_picture = $request->input('current_profile_picture_value');

        $student_id = Auth::user()->studid;

        //Remove picture from public/uploads
        if($old_profile_picture)
        {
            $get_old_pic = User::where('studid', $student_id)->where('profile_pic', $old_profile_picture)->first();

            if($get_old_pic)
            {
                $fp = public_path("uploads/profiles") . "\\" . $get_old_pic->profile_pic;
                if(file_exists($fp)) {
                    unlink($fp);
                }
            }
        }

        $profile_pic = $request->input('up_profile_pic');

        foreach ($profile_pic as $picture)
        {
            $splitDocFilePath = explode("<", $picture);

            $filePath = $splitDocFilePath[0];

            $get_profile_picture = temp_files::where('folder', $filePath)->first();

            User::where('studid', $student_id)->update([
                    'profile_pic' => $get_profile_picture->filename,
                ]);

            Storage::deleteDirectory('public/tmp/' . $get_profile_picture->folder);
            temp_files::where('folder', $get_profile_picture->folder)->delete();

        }

        return response()->json([
            'status' => 200,
        ]);
    }







    public function load_personal_information(Request $request)
    {
        $hr_details = employee_hr_details::
                        with(['get_user_details'])
                        ->where('employeeid', Auth::user()->employee)
                        ->get();

        foreach ($hr_details as $hr_detail) {

            if($hr_detail->get_user_details)
            {
                $info = $hr_detail->get_user_details;

                $last_name = $info->lastname;
                $first_name = $info->firstname;
                $mid_name = $info->mi;
                $extension = $info->extension;
                $dateofbirth = $info->dateofbirth;
                $civilstatus = $info->civilstatus;
                $religion = $info->religion;
                $spouse = $info->spouse;
                $citizenship = $info->citizenship;
                $first_name = $info->firstname;
            }

        }
    }

    public function load_residential_address(Request $request)
    {

        $employee_id = Auth::user()->employee;

        $tres = [];
        $brgy_code = '';
        $barangay = '';
        $province_code = '';
        $province = '';
        $municipality = '';
        $mun_code = '';

        $residential_address = pds_address::with('get_province', 'get_city_mun', 'get_brgy')
                        ->where('employee_id', $employee_id)
                        ->where('address_type', 'RESIDENTIAL')
                        ->where('active',1)->get();

        foreach ($residential_address as $dt) {

            if($dt->get_province)
            {
                $prov = $dt->get_province;

                $province_code = $prov->provCode;
                $province = $prov->provDesc;
            }
            if($dt->get_city_mun)
            {
                $city_mun = $dt->get_city_mun;

                $mun_code = $city_mun->citymunCode;
                $municipality = $city_mun->citymunDesc;
            }
            if($dt->get_brgy)
            {
                $brgy = $dt->get_brgy;
                $brgy_id = $brgy->id;
                $brgy_code = $brgy->brgyCode;
                $barangay = $brgy->brgyDesc;
            }else
            {
                $brgy = '';
                $brgy_id = '';
                $brgy_code = '';
                $barangay = '';
            }

            $td = [

                "id" => $dt->id,
                "address_type" => $dt->address_type,
                "house_block_no" => $dt->house_block_no,
                "street" => $dt->street,
                "subdivision_village" => $dt->subdivision_village,

                "brgy_code" => $brgy_code,
                "brgy_id" => $brgy_id,
                "brgy" => $barangay,

                "municipality" => $municipality,
                "municipality_code" => $mun_code,

                "province" => $province,
                "province_code" => $province_code,

                "zip_code" => $dt->zip_code,

            ];
            $tres[count($tres)] = $td;

        }

        echo json_encode($tres);
    }

    public function load_permanent_address(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $tres = [];
        $per_brgy_code = '';
        $per_barangay = '';
        $per_province_code = '';
        $per_province = '';
        $per_mun_code = '';
        $per_municipality = '';

        $permanent_address = pds_address::with('get_province', 'get_city_mun', 'get_brgy')
                                        ->where('employee_id', $employee_id)
                                        ->where('address_type', 'PERMANENT')
                                        ->where('active',1)
                                        ->get();

        foreach ($permanent_address as $dt) {

            if($dt->get_province)
            {
                $prov = $dt->get_province;
                $per_province_code = $prov->provCode;
                $per_province = $prov->provDesc;
            }
            if($dt->get_city_mun)
            {
                $city_mun = $dt->get_city_mun;
                $per_mun_code = $city_mun->citymunCode;
                $per_municipality = $city_mun->citymunDesc;
            }
            if($dt->get_brgy)
            {
                $brgy = $dt->get_brgy;
                $per_brgy_code = $brgy->brgyCode;
                $per_barangay = $brgy->brgyDesc;
            }

            $td = [

                "id" => $dt->id,
                "address_type" => $dt->address_type,
                "house_block_no" => $dt->house_block_no,
                "street" => $dt->street,
                "subdivision_village" => $dt->subdivision_village,

                "per_brgy_code" => $per_brgy_code,
                "per_brgy" => $per_barangay,

                "per_municipality" => $per_municipality,
                "per_municipality_code" => $per_mun_code,

                "per_province" => $per_province,
                "per_province_code" => $per_province_code,

                "zip_code" => $dt->zip_code,

            ];
            $tres[count($tres)] = $td;

        }
        echo json_encode($tres);
    }




    public function load_educ_bg(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $educational_list = '';

        $get_academic_bg = pds_educational_bg::where('employee_id', $employee_id)
                                            ->where('active', 1)
                                            ->get();

        foreach ($get_academic_bg as $index => $acad_bg)
        {

            $acad_id = Crypt::encrypt($acad_bg->id);
            $acad_level = $acad_bg->level;
            $acad_school_name = $acad_bg->school_name;
            $acad_degreee_course = $acad_bg->degreee_course;
            $acad_attendance_from = $acad_bg->attendance_from;
            $acad_attendance_to = $acad_bg->attendance_to;
            $acad_units_earned = $acad_bg->units_earned;
            $acad_year_graduated = $acad_bg->year_graduated;
            $acad_acad_honors = $acad_bg->acad_honors;

            $educational_list .= '<tr class="hover:bg-gray-200">
                                    <td class="hidden"><input type="text" style="display: none; " name="td_educ_bg_id[]" class="form-control" >'.$acad_id.'</td>
                                    <td style="text-transform:uppercase"><input type="text" style="display: none; " name="td_educ_bg_level[]" class="form-control" >'.$acad_level.'</td>
                                    <td style="text-transform:uppercase"><input type="text" style="display: none; text-transform:uppercase" name="td_educ_school_name[]" class="form-control flex text-center">'.$acad_school_name.'</td>
                                    <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_degree_course[]" class="form-control flex text-center">'.$acad_degreee_course.'</td>
                                    <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_from[]" class="form-control flex text-center" >'.$acad_attendance_from.'</td>
                                    <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_to[]" class="form-control flex text-center" >'.$acad_attendance_to.'</td>
                                    <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_highest_level_earned[]" class="form-control flex text-center">'.$acad_units_earned.'</td>
                                    <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_educ_year_graduated[]" class="form-control flex text-center" >'.$acad_year_graduated.'</td>
                                    <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_scholarship[]" class="form-control flex text-center">'.$acad_acad_honors.'</td>
                                    <td >
                                        <div class="flex justify-center items-center">
                                            <a href="javascript:void(0);" class=" text-theme-6 update_saved_educ_bg text-center mr-5"
                                                data-acad-id="'.$acad_id.'"
                                                data-acad-level="'.$acad_level.'"
                                                data-school-name="'.$acad_school_name.'"
                                                data-degree="'.$acad_degreee_course.'"
                                                data-att-from="'.$acad_attendance_from.'"
                                                data-att-to="'.$acad_attendance_to.'"
                                                data-unit-earn="'.$acad_units_earned.'"
                                                data-graduated="'.$acad_year_graduated.'"
                                                data-honors="'.$acad_acad_honors.'"
                                                >
                                                <i class="fa-solid fa-pen-to-square w-4 h-4 text-success"></i></a>
                                            <a href="javascript:void(0);" class=" text-theme-6 delete_my_educ_bg text-center" data-acad-id="'.$acad_id.'"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>';
        }

        return json_encode(array(

            "educational_list" => $educational_list,

        ));
    }
    public function add_educ_bg(Request $request)
    {
        $employee_id = Auth::user()->employee;

        /* BEGIN:: Educational Background Here  */
        if ($request->educ_bg_level)
        {
            pds_educational_bg::updateOrCreate(
                [
                    'employee_id'=> $employee_id,
                    'level' => strtoupper($request->educ_bg_level),
                    'school_name' => strtoupper($request->educ_school_name),
                    'attendance_from' => $request->educ_school_from,
                    'attendance_to' => $request->educ_school_to,
                    'degreee_course' => strtoupper($request->educ_degree_course),
                    'units_earned' => strtoupper($request->educ_highest_level_earned),
                    'year_graduated' => $request->educ_year_graduated,
                    'acad_honors' => strtoupper($request->educ_scholarship),
                ],

                [
                    'employee_id'=> $employee_id,
                    'level' => strtoupper($request->educ_bg_level),
                    'school_name' => strtoupper($request->educ_school_name),
                    'attendance_from' => $request->educ_school_from,
                    'attendance_to' => $request->educ_school_to,
                    'degreee_course' => strtoupper($request->educ_degree_course),
                    'units_earned' => strtoupper($request->educ_highest_level_earned),
                    'year_graduated' => $request->educ_year_graduated,
                    'acad_honors' => strtoupper($request->educ_scholarship),
                    'active' => 1,
                ]
            );

            return json_encode(array(
                'status' => 200,
            ));
        }
        /* END:: Educational Background Here  */
    }
    public function update_educ_bg(Request $request)
    {
        $educ_id = Crypt::decrypt($request->academic_id);

        pds_educational_bg::where('id', $educ_id)->update([
            'level' => $request->educ_bg_level,
            'school_name' => $request->educ_school_name,
            'degreee_course' => $request->educ_degree_course,
            'attendance_from' => $request->educ_school_from,
            'attendance_to' => $request->educ_school_to,
            'units_earned' => $request->educ_highest_level_earned,
            'year_graduated' => $request->educ_year_graduated,
            'acad_honors' => $request->educ_scholarship,
        ]);

        return json_encode(array(
            'status' => 200,
        ));
    }
    public function remove_educ_bg(Request $request)
    {
        $educ_id = Crypt::decrypt($request->academic_id);

        pds_educational_bg::where('id', $educ_id)->delete();

        return json_encode(array(
            'status' => 200,
        ));
    }




    public function get_family_bg(Request $request)
    {
        $employee_id = Auth::user()->employee;
        $tres = [];
        $child_name = '';
        $child_bdate = '';
        $list_tr = '';
        $child_list_id = '';
        $spouse_surname = '';
        $spouse_firstname = '';
        $spouse_ext = '';
        $spouse_mi = '';
        $father_surname = '';
        $father_firstname = '';
        $father_ext = '';
        $father_mi = '';
        $mother_maidenname = '';
        $mother_surname = '';
        $mother_firstname = '';
        $mother_mi = '';
        $occupation = '';
        $employer_name = '';
        $business_address = '';
        $tel_no = '';

        $get_family_bg = pds_family_bg::with('get_employee_child')
            ->where('employee_id', $employee_id)
            ->where('active', true)
            ->get();

        foreach ($get_family_bg as $index => $bg)
        {
            if($bg->get_employee_child()->exists())
            {
                foreach ($bg->get_employee_child as $fam)
                {
                    $child_list_id = $fam->id;
                    $child_name = $fam->name;
                    $child_bdate = $fam->birth_date;

                    $list_tr .= '<tr class="hover:bg-gray-200">
                    <td > <input id="td_input_child_name" name="td_input_child_name[]" type="text" class="form-control" placeholder="Name of Children" value="'.$child_name.'"></td>
                    <td > <input id="td_input_child_bdate" name="td_input_child_bdate[]" type="date" class="form-control pl-12" value="'.$child_bdate.'" ></td>
                    <td><a href="javascript:void(0);" class="flex items-center justify-center text-theme-6 delete_child_list_from_db" data-list-id="'.$child_list_id.'"><i  class="w-4 h-4 mr-1 text-danger fa-solid fa-trash">Remove</i></a></td>
                    </tr>';
                }
            }

            $spouse_surname = $bg->spouse_surname;
            $spouse_firstname = $bg->spouse_firstname;
            $spouse_ext = $bg->spouse_ext;
            $spouse_mi = $bg->spouse_mi;

            $father_surname = $bg->father_surname;
            $father_firstname = $bg->father_firstname;
            $father_ext = $bg->father_ext;
            $father_mi = $bg->father_mi;

            $mother_maidenname = $bg->mother_maidenname;
            $mother_surname = $bg->mother_surname;
            $mother_firstname = $bg->mother_firstname;
            $mother_mi = $bg->mother_mi;

            $occupation = $bg->occupation;
            $employer_name = $bg->employer_name;
            $business_address = $bg->business_address;
            $tel_no = $bg->tel_no;

        }


        return json_encode(array(

            "spouse_surname" => $spouse_surname,
            "spouse_firstname" => $spouse_firstname,
            "spouse_ext" => $spouse_ext,
            "spouse_mi" => $spouse_mi,

            "father_surname" => $father_surname,
            "father_firstname" => $father_firstname,
            "father_ext" => $father_ext,
            "father_mi" =>$father_mi,

            "mother_maidenname" => $mother_maidenname,
            "mother_surname" => $mother_surname,
            "mother_firstname" => $mother_firstname,
            "mother_mi" => $mother_mi,

            "occupation" => $occupation,
            "employer_name" => $employer_name,
            "business_address" => $business_address,
            "tel_no" => $tel_no,

            "child_list_tr" => $list_tr,

        ));

    }
    public function remove_child_family_bg(Request $request)
    {
        $child_list_id = $request->child_list_id;

        pds_child_list::where('id',$child_list_id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }




    public function load_civil_service_eligibility(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $cs_eligibility_list = '';

        $get_cs_eligibility = pds_child_list::where('employee_id', $employee_id)
                                    ->where('active', true)
                                    ->get();

        if ($get_cs_eligibility) {
            foreach ($get_cs_eligibility as $index => $cs) {

                $cs_eligibility_id = $cs->id;
                $cs_eligibility_type = $cs->eligibility_type;
                $cs_eligibility_rating = $cs->rating;
                $cs_date_examination = $cs->date_examination;
                $cs_place_examination = $cs->place_examination;
                $cs_license_number = $cs->license_number;
                $cs_license_validity = $cs->license_validity;

                $cs_eligibility_list .= '<tr class="hover:bg-gray-200">
                                        <td style="text-transform:uppercase"><input type="text" style="display: none; " class="form-control" value="' . $cs_eligibility_type . '">' . $cs_eligibility_type . '</td>
                                        <td style="text-transform:uppercase"><input type="text" style="display: none; text-transform:uppercase" class="form-control flex text-center" value="' . $cs_eligibility_rating . '">' . $cs_eligibility_rating . '</td>
                                        <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_degree_course[]" class="form-control flex text-center" value="' . $cs_date_examination . '">' . $cs_date_examination . '</td>
                                        <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_from[]" class="form-control flex text-center" value="' . $cs_place_examination . '">' . $cs_place_examination . '</td>
                                        <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_to[]" class="form-control flex text-center" value="' . $cs_license_number . '">' . $cs_license_number . '</td>
                                        <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_highest_level_earned[]" class="form-control flex text-center" value="' . $cs_license_validity . '">' . $cs_license_validity . '</td>
                                        <td >
                                            <div class="flex justify-center items-center">

                                                <a href="javascript:void(0);" class=" text-theme-6 text-center mr-5 update_cs_eligibility"
                                                    data-cs-id="' . $cs_eligibility_id . '"
                                                    data-cs-type="' . $cs_eligibility_type . '"
                                                    data-cs-rating="' . $cs_eligibility_rating . '"
                                                    data-cs-date="' . $cs_date_examination . '"
                                                    data-cs-place="' . $cs_place_examination . '"
                                                    data-license-number="' . $cs_license_number . '"
                                                    data-license-validity="' . $cs_license_validity . '"
                                                >
                                                <i class="fa-solid fa-pen-to-square w-4 h-4 text-success"></i></a>

                                                <a href="javascript:void(0);" class=" text-theme-6 delete_saved_cs text-center" data-cs-id="' . $cs_eligibility_id . '"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>';
            }
        }

        return json_encode(array(

            "cs_eligibility_list" => $cs_eligibility_list,

        ));
    }
    public function add_cs_eligibility(Request $request)
    {
        $employee_id = Auth::user()->employee;

        /* BEGIN:: Civil Service Eligibility */
        if($request->cs_type)
        {
            $eligibility_type = strtoupper($request->cs_type);

            pds_cs_eligibility::updateOrCreate(
                [
                    'employee_id'=> $employee_id,
                    'eligibility_type' => $eligibility_type,
                ],

                [
                    'employee_id'=> $employee_id,
                    'eligibility_type' => $eligibility_type,
                    'rating' => strtoupper($request->cs_rating),
                    'date_examination' => $request->cs_date_exam,
                    'place_examination' => strtoupper($request->cs_place_exam),
                    'license_number' => strtoupper($request->cs_license_number),
                    'license_validity' => strtoupper($request->cs_date_validity),
                    'active' => 1,
                ]
            );
            return json_encode(array(
                'status' => 200,
            ));
        }
        /* END:: Civil Service Eligibility */
    }
    public function update_cs_eligibility(Request $request)
    {
        $employee_id = Auth::user()->employee;

        pds_cs_eligibility::where('id', $request->cs_id)->update([

            'employee_id'=> $employee_id,
            'eligibility_type' => $request->cs_type,
            'rating' => strtoupper($request->cs_rating),
            'date_examination' => strtoupper($request->cs_date_exam),
            'place_examination' => strtoupper($request->cs_place_exam),
            'license_number' => strtoupper($request->cs_license_number),
            'license_validity' => strtoupper($request->cs_date_validity),
            'active' => 1,

        ]);
        return json_encode(array(
            'status' => 200,
        ));
    }
    public function remove_cs(Request $request)
    {
        $cs_id = $request->cs_id;

        pds_cs_eligibility::where('id',$cs_id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }




    public function load_work_experience(Request $request)
    {
        $employee_id = Auth::user()->employee;
        $work_exp_list = '';

        $get_work_exp = pds_work_exp::where('employee_id', $employee_id)
            ->where('active', 1)
            ->orderBy('from', 'DESC')
            ->orderBy('to', 'DESC')
            ->get();

        if ($get_work_exp) {
            foreach ($get_work_exp as $index => $exp)
            {

                $exp_id = $exp->id;
                $exp_from = Carbon::parse($exp->from)->format('d/m/Y');
                $exp_to = Carbon::parse($exp->to)->format('d/m/Y');
                $exp_position_title = $exp->position_title;
                $exp_dept_agency_office = $exp->dept_agency_office;
                $exp_monthly_sal = $exp->monthly_sal;
                $exp_sal_grade = $exp->sal_grade;
                $exp_appointment_status = $exp->appointment_status;
                $exp_gvt_service = $exp->gvt_service;

                    $work_exp_list .= '<tr class="hover:bg-gray-200">
                                            <td style="text-transform:uppercase"><input type="text" style="display: none; " class="form-control" value="' . $exp_from . '">' . $exp_from . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none; text-transform:uppercase" class="form-control flex text-center" value="' . $exp_to . '">' . $exp_to . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_degree_course[]" class="form-control flex text-center" value="' . $exp_position_title . '">' . $exp_position_title . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_from[]" class="form-control flex text-center" value="' . $exp_dept_agency_office . '">' . $exp_dept_agency_office . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_to[]" class="form-control flex text-center" value="' . $exp_monthly_sal . '">' . $exp_monthly_sal . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_highest_level_earned[]" class="form-control flex text-center" value="' . $exp_sal_grade . '">' . $exp_sal_grade . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_highest_level_earned[]" class="form-control flex text-center" value="' . $exp_appointment_status . '">' . $exp_appointment_status . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_highest_level_earned[]" class="form-control flex text-center" value="' . $exp_gvt_service . '">' . $exp_gvt_service . '</td>
                                            <td >
                                                <div class="flex justify-center items-center">
                                                    <a href="javascript:void(0);" class=" text-theme-6 update_work_exp text-center mr-5"
                                                    data-exp-id     ="' . $exp_id . '"
                                                    data-exp-from   ="' . $exp_from . '"
                                                    data-exp-to     ="' . $exp_to . '"
                                                    data-exp-title  ="' . $exp_position_title . '"
                                                    data-exp-office ="' . $exp_dept_agency_office . '"
                                                    data-exp-sal    ="' . $exp_monthly_sal . '"
                                                    data-exp-sg     ="' . $exp_sal_grade . '"
                                                    data-exp-status ="' . $exp_appointment_status . '"
                                                    data-exp-gvt    ="' . $exp_gvt_service . '"
                                                    >
                                                    <i  class="w-4 h-4 text-success fa-solid fa-pen-to-square"></i></a>

                                                    <a href="javascript:void(0);" class=" text-theme-6 delete_work_exp text-center" data-exp-id="' . $exp_id . '"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>';
            }
        }

        return json_encode(array(

            "work_exp_list" => $work_exp_list,

        ));
    }
    public function add_work_experience(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $date_from = date('Y-m-d', strtotime($request->work_exp_date_from));
        $date_to = date('Y-m-d', strtotime($request->work_exp_date_to));

        /* BEGIN:: Work Experience */

        pds_work_exp::updateOrCreate(
            [
                'employee_id'=> $employee_id,
                'position_title' => strtoupper($request->work_exp_pos_title),
                'dept_agency_office' => strtoupper($request->work_exp_dept_agency),
            ],

            [
                'employee_id'=> $employee_id,
                'from' => $date_from,
                'to' => $date_to,
                'position_title' => strtoupper($request->work_exp_pos_title),
                'dept_agency_office' => strtoupper($request->work_exp_dept_agency),
                'monthly_sal' => $request->work_exp_sal,
                'sal_grade' => strtoupper($request->work_exp_sg),
                'appointment_status' => strtoupper($request->work_exp_status),
                'gvt_service' => strtoupper($request->work_exp_govt_service),
                'active' => 1,
            ]
        );
        return json_encode(array(
            'status' => 200,
        ));
        /* END:: Work Experience */
    }
    public function update_work_experience(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $date_from = date('Y-m-d', strtotime($request->work_exp_date_from));
        $date_to = date('Y-m-d', strtotime($request->work_exp_date_to));

         pds_work_exp::where('id', $request->work_exp_id)->update([


             'employee_id'      => $employee_id,
             'from'             => $date_from,
             'to'               => $date_to,
             'position_title'   => strtoupper($request->work_exp_pos_title),
             'dept_agency_office' => strtoupper($request->work_exp_dept_agency),
             'monthly_sal'      => $request->work_exp_sal,
             'sal_grade'        => $request->work_exp_sg,
             'appointment_status' => strtoupper($request->work_exp_status),
             'gvt_service'      => strtoupper($request->work_exp_govt_service),
             'active'           => 1,

         ]);
    }
    public function remove_work_exp(Request $request)
    {
        $work_exp_id = $request->work_exp_id;

        pds_work_exp::where('id',$work_exp_id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }




    public function load_voluntary_work(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $vol_work_list = '';

        $get_vol_work = pds_voluntary_work::where('employee_id', $employee_id)
            ->where('active', 1)
            ->orderBy('from', 'DESC')
            ->orderBy('to', 'DESC')
            ->get();

        if ($get_vol_work) {
            foreach ($get_vol_work as $index => $vol)
            {
                $vol_id = $vol->id;
                $vol_org_name = $vol->org_name_address;
                $vol_from = Carbon::parse($vol->from)->format('d/m/Y');
                $vol_to = Carbon::parse($vol->to)->format('d/m/Y');
                $vol_hours_number = $vol->hours_number;
                $vol_work_position_nature = $vol->work_position_nature;

                $vol_work_list .= '<tr class="hover:bg-gray-200">
                                            <td style="text-transform:uppercase"><input type="text" style="display: none; " class="form-control" value="' . $vol_org_name . '">' . $vol_org_name . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none; text-transform:uppercase" class="form-control flex text-center" value="' . $vol_from . '">' . $vol_from . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_degree_course[]" class="form-control flex text-center" value="' . $vol_to . '">' . $vol_to . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_from[]" class="form-control flex text-center" value="' . $vol_hours_number . '">' . $vol_hours_number . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" name="td_educ_school_to[]" class="form-control flex text-center" value="' . $vol_work_position_nature . '">' . $vol_work_position_nature . '</td>
                                            <td >
                                                <div class="flex justify-center items-center">
                                                    <a href="javascript:void(0);" class=" text-theme-6 update_vol_work text-center mr-5"
                                                    data-vol-id         ="' . $vol_id . '"
                                                    data-vol-org-name   ="' . $vol_org_name . '"
                                                    data-vol-from       ="' . $vol_from . '"
                                                    data-vol-to         ="' . $vol_to . '"
                                                    data-vol-number     ="' . $vol_hours_number . '"
                                                    data-vol-nature     ="' . $vol_work_position_nature . '"
                                                    >
                                                    <i class="fa-solid fa-pen-to-square w-4 h-4 text-success"></i></a>
                                                    <a href="javascript:void(0);" class=" text-theme-6 delete_vol_work text-center" data-vol-id="' . $vol_id . '"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>';
            }
        }

        return json_encode(array(

            "vol_work_list" => $vol_work_list,

        ));
    }
    public function add_voluntary_work(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $date_from = date('Y-m-d', strtotime($request->vol_work_date_from));
        $date_to = date('Y-m-d', strtotime($request->vol_work_date_to));

        /* BEGIN:: Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization/s */
        pds_voluntary_work::updateOrCreate(
            [
                'employee_id'=> $employee_id,
                'org_name_address' => strtoupper($request->vol_work_org_name),
            ],

            [
                'employee_id'=> $employee_id,
                'org_name_address' => strtoupper($request->vol_work_org_name),
                'from' => $date_from,
                'to' => $date_to,
                'hours_number' => $request->vol_work_hr_number,
                'work_position_nature' => strtoupper($request->vol_work_nature),
                'active' => 1,
            ]
        );
        return json_encode(array(
            'status' => 200,
        ));
        /* END::  Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization/s */

    }
    public function update_vol_work(Request $request)
    {
        $date_from = date('Y-m-d', strtotime($request->vol_work_date_from));
        $date_to = date('Y-m-d', strtotime($request->vol_work_date_to));

        pds_voluntary_work::where('id', $request->vol_work_id)->update([

            'org_name_address' => strtoupper($request->vol_work_org_name),
            'from' => $date_from,
            'to' => $date_to,
            'hours_number' => $request->vol_work_hr_number,
            'work_position_nature' => strtoupper($request->vol_work_nature),
            'active' => 1,

        ]);
        return json_encode(array(
            'status' => 200,
        ));
    }
    public function remove_voluntary_work(Request $request)
    {
        $vol_work_id = $request->vol_work_id;

        pds_voluntary_work::where('id',$vol_work_id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }




    public function add_learning_development(Request $request)
    {
        /* BEGIN:: VII.  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED */
        $employee_id = Auth::user()->employee;

        $date_from = date('Y-m-d', strtotime($request->ld_date_from));
        $date_to = date('Y-m-d', strtotime($request->ld_date_to));

        pds_learning_development::updateOrCreate(
            [
                'employee_id'=> $employee_id,
                'learning_dev_title' => $request->ld_title,
                'from' => $request->ld_date_from,
                'to' => $request->ld_date_to,
            ],

            [
                'employee_id'=> $employee_id,
                'learning_dev_title' => $request->ld_title,
                'from' => $date_from,
                'to' => $date_to,
                'hours_number' => $request->ld_hr_number,
                'learning_dev_type' => strtoupper($request->ld_type),
                'conducted_sponsored' => strtoupper($request->ld_sponsored_by),
                'ld_others' => strtoupper($request->ld_type_others),
                'active' => 1,
            ]
        );
        return json_encode(array(
            'status' => 200,
        ));
        /* END::  VII.  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED */
    }
    public function load_learning_development(Request $request)
    {
        $employee_id = Auth::user()->employee;
        $ld_list = '';

        $get_ld = pds_learning_development::where('employee_id', $employee_id)
            ->where('active', 1)
            ->orderBy('from', 'DESC')
            ->orderBy('to', 'DESC')
            ->get();

        if ($get_ld) {
            foreach ($get_ld as $index => $ld)
            {
                $ld_id = $ld->id;
                $ld_learning_dev_title = $ld->learning_dev_title;
                $ld_from = Carbon::parse($ld->from)->format('d/m/Y');
                $ld_to = Carbon::parse($ld->to)->format('d/m/Y');
                $ld_hours_number = $ld->hours_number;
                $ld_learning_dev_type = $ld->learning_dev_type;
                $ld_conducted_sponsored = $ld->conducted_sponsored;
                $ld_type_others = $ld->ld_others;


                $ld_list .= '<tr class="hover:bg-gray-200">
                                            <td style="text-transform:uppercase"><input type="text" style="display: none; " class="form-control" value="' . $ld_learning_dev_title . '">' . $ld_learning_dev_title . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none; text-transform:uppercase" class="form-control flex text-center" value="' . $ld_from . '">' . $ld_from . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" class="form-control flex text-center" value="' . $ld_to . '">' . $ld_to . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" class="form-control flex text-center" value="' . $ld_hours_number . '">' . $ld_hours_number . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" class="form-control flex text-center" value="' . $ld_learning_dev_type . '">' . $ld_learning_dev_type . '</td>
                                              <td style="text-transform:uppercase"><input type="text" style="display: none" class="form-control flex text-center" value="' . $ld_conducted_sponsored . '">' . $ld_conducted_sponsored . '</td>
                                            <td >
                                                <div class="flex justify-center items-center">

                                                    <a href="javascript:void(0);" class=" text-theme-6 update_my_ld text-center mr-5"
                                                    data-ld-id      ="' . $ld_id . '"
                                                    data-ld-title   ="' . $ld_learning_dev_title . '"
                                                    data-ld-from    ="' . $ld_from . '"
                                                    data-ld-to      ="' . $ld_to . '"
                                                    data-ld-number  ="' . $ld_hours_number . '"
                                                    data-ld-type    ="' . $ld_learning_dev_type . '"
                                                    data-ld-sponsored="' . $ld_conducted_sponsored . '"
                                                    data-ld-others="' . $ld_type_others . '"
                                                    >
                                                    <i class="fa-solid fa-pen-to-square w-4 h-4 text-success"></i></a>

                                                    <a href="javascript:void(0);" class=" text-theme-6 delete_ld text-center" data-ld-id="' . $ld_id . '"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>';
            }
        }

        return json_encode(array(

            "ld_list" => $ld_list,

        ));
    }
    public function remove_learning_development(Request $request)
    {
        $ld_id = $request->ld_id;

        pds_learning_development::where('id',$ld_id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }
    public function update_learning_development(Request $request)
    {
        $date_from = date('Y-m-d', strtotime($request->ld_date_from));
        $date_to = date('Y-m-d', strtotime($request->ld_date_to));

        pds_learning_development::where('id', $request->ld_id)->update([

            'learning_dev_title' => strtoupper($request->ld_title),
            'from' => $date_from,
            'to' => $date_to,
            'hours_number' => $request->ld_hr_number,
            'learning_dev_type' => strtoupper($request->ld_type),
            'ld_others' => strtoupper($request->ld_type_others),
            'conducted_sponsored' => strtoupper($request->ld_sponsored_by),
            'active' => 1,

        ]);
        return json_encode(array(
            'status' => 200,
        ));
    }





    public function add_special_skills(Request $request)
    {
        /* BEGIN:: VIII.  OTHER INFORMATION */
        $employee_id = Auth::user()->employee;

        pds_special_skills::updateOrCreate(
            [
                'employee_id'=> $employee_id,
                'special_skills' => strtoupper($request->others_skills),
                'distinctions' => strtoupper($request->others_distinction),
                'org_membership' => strtoupper($request->others_membership),
            ],

            [
                'employee_id'=> $employee_id,
                'special_skills' => strtoupper($request->others_skills),
                'distinctions' => strtoupper($request->others_distinction),
                'org_membership' => strtoupper($request->others_membership),
                'active' => 1,
            ]
        );
        return json_encode(array(
            'status' => 200,
        ));
        /* END::  VIII.  OTHER INFORMATION */
    }
    public function load_special_skills(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $special_skill_list = '';

        $get_special_skills = pds_special_skills::where('employee_id', $employee_id)
            ->where('active', 1)
            ->get();

        if ($get_special_skills) {
            foreach ($get_special_skills as $index => $skill)
            {
                $skill_id = $skill->id;
                $skill_special_skills = $skill->special_skills;
                $skill_distinctions = $skill->distinctions;
                $skill_org_membership = $skill->org_membership;

                $special_skill_list .= '<tr class="hover:bg-gray-200">
                                            <td style="text-transform:uppercase"><input type="text" style="display: none; " class="form-control" value="' . $skill_special_skills . '">' . $skill_special_skills . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none; text-transform:uppercase" class="form-control flex text-center" value="' . $skill_distinctions . '">' . $skill_distinctions . '</td>
                                            <td style="text-transform:uppercase"><input type="text" style="display: none" class="form-control flex text-center" value="' . $skill_org_membership . '">' . $skill_org_membership . '</td>
                                            <td >
                                                <div class="flex justify-center items-center">
                                                    <a href="javascript:void(0);" class=" text-theme-6 update_special_skills text-center mr-5"
                                                    data-skill-id="' . $skill_id . '"
                                                    data-skills="' . $skill_special_skills . '"
                                                    data-skill-distinctions="' . $skill_distinctions . '"
                                                    data-skill-org="' . $skill_org_membership . '"
                                                    >
                                                    <i class="fa-solid fa-pen-to-square w-4 h-4 text-success"></i></a>

                                                    <a href="javascript:void(0);" class=" text-theme-6 delete_special_skills text-center" data-skill-id="' . $skill_id . '"><i  class="w-4 h-4 text-danger fa-solid fa-trash">Remove</i></a>
                                                </div>
                                            </td>
                                        </tr>';
            }
        }

        return json_encode(array(

            "special_skill_list" => $special_skill_list,

        ));
    }
    public function remove_special_skills(Request $request)
    {
        $skill_id = $request->skill_id;

        pds_special_skills::where('id',$skill_id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }
    public function update_special_skills(Request $request)
    {
        pds_special_skills::where('id', $request->special_skills_id)->update([

            'special_skills' => strtoupper($request->others_skills),
            'distinctions' => strtoupper($request->others_distinction),
            'org_membership' => strtoupper($request->others_membership),

        ]);
        return json_encode(array(
            'status' => 200,
        ));
    }



    public function load_other_information(Request $request)
    {
        $employee_id = Auth::user()->employee;
        $tres = [];

        $other_infos = pds_other_information::where('employee_id', $employee_id)->where('active',1)->get();

        foreach ($other_infos as $dt) {

            $td = [

                "id" => $dt->id,
                "other_info_34_a" => $dt->other_info_34_a,
                "other_info_34_b" => $dt->other_info_34_b,
                "other_info_34_b_details" => $dt->other_info_34_b_details,

                "other_info_35_a" => $dt->other_info_35_a,
                "other_info_35_a_details" => $dt->other_info_35_a_details,
                "other_info_35_b" => $dt->other_info_35_b,
                "other_info_35_b_details" => $dt->other_info_35_b_details,
                "other_info_35_b_date_filed" => $dt->other_info_35_b_date_filed,
                "other_info_35_b_status" => $dt->other_info_35_b_status,

                "other_info_36" => $dt->other_info_36,
                "other_info_36_details" => $dt->other_info_36_details,

                "other_info_37" => $dt->other_info_37,
                "other_info_37_details" => $dt->other_info_37_details,

                "other_info_38_a" => $dt->other_info_38_a,
                "other_info_38_a_details" => $dt->other_info_38_a_details,

                "other_info_38_b" => $dt->other_info_38_b,
                "other_info_38_b_details" => $dt->other_info_38_b_details,

                "other_info_39" => $dt->other_info_39,
                "other_info_39_details" => $dt->other_info_39_details,

                "other_info_40_a" => $dt->other_info_40_a,
                "other_info_40_a_details" => $dt->other_info_40_a_details,

                "other_info_40_b" => $dt->other_info_40_b,
                "other_info_40_b_details" => $dt->other_info_40_b_details,

                "other_info_40_c" => $dt->other_info_40_c,
                "other_info_40_c_details" => $dt->other_info_40_c_details,

            ];
            $tres[count($tres)] = $td;

        }

        //dd($fullname);
        echo json_encode($tres);
    }



    public function add_references(Request $request)
    {
        /*BEGIN:: REFERENCES*/
        $employee_id = Auth::user()->employee;
        pds_references::updateOrCreate(
            [
                'employee_id'=> $employee_id,
                'name'=> strtoupper($request->ref_name),
                'address'=> strtoupper($request->ref_address),
            ],

            [
                'employee_id'=> $employee_id,
                'name'=> strtoupper($request->ref_name),
                'address'=> strtoupper($request->ref_address),
                'tel_no'=> strtoupper($request->ref_tel_no),
                'active'  => 1,
            ]
        );
        return json_encode(array(
            'status' => 200,
        ));
        /*BEGIN:: REFERENCES*/
    }
    public function update_references(Request $request)
    {
        /*BEGIN:: REFERENCES*/
        pds_references::where('id', $request->reference_id)->update([

            'name'=> strtoupper($request->ref_name),
            'address'=> strtoupper($request->ref_address),
            'tel_no'=> strtoupper($request->ref_tel_no),

        ]);

        return json_encode(array(
            'status' => 200,
        ));
        /*BEGIN:: REFERENCES*/
    }
    public function load_reference_info(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $reference_list = '';

        $references = pds_references::where('employee_id', $employee_id)->where('active', 1)->get();

        foreach ($references as $dt) {

            $reference_id = $dt->id;
            $name = $dt->name;
            $address = $dt->address;
            $tel_no = $dt->tel_no;

            $reference_list .=
                '<tr class="hover:bg-gray-200">
                    <td style="text-transform:uppercase"><input type="text" style="display: none; " class="form-control" value="' . $name . '">' . $name . '</td>
                    <td style="text-transform:uppercase"><input type="text" style="display: none; text-transform:uppercase" class="form-control flex text-center" value="' . $address . '">' . $address . '</td>
                    <td style="text-transform:uppercase"><input type="text" style="display: none" class="form-control flex text-center" value="' . $tel_no . '">' . $tel_no . '</td>
                    <td >
                        <div class="flex justify-center items-center">

                         <a href="javascript:void(0);" class=" text-theme-6 update_my_references text-center mr-5"
                                                    data-ref-id     ="' . $reference_id . '"
                                                    data-ref-name   ="' . $name . '"
                                                    data-ref-address="' . $address . '"
                                                    data-ref-tel    ="' . $tel_no . '"
                                                    >
                                                    <i class="fa-solid fa-pen-to-square w-4 h-4 text-success"></i></a>
                            <a href="javascript:void(0);" class=" text-theme-6 delete_references text-center" data-ref-id="' . $reference_id . '"><i  class="w-4 h-4 text-danger fa-solid fa-trash">Remove</i></a>
                        </div>
                    </td>
                </tr>';

        }

        return json_encode(array(

            "reference_list" => $reference_list,

        ));
    }
    public function remove_references(Request $request)
    {
        $reference_id = $request->reference_id;

        pds_references::where('id',$reference_id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }





    public function load_government_id(Request $request)
    {
        $employee_id = Auth::user()->employee;

        $tres = [];

        $government_id = pds_government_id::where('employee_id', $employee_id)->where('active', true)->get();

        foreach ($government_id as $id)
        {
            $td = [

                "gvt_issued_id" => $id->gvt_issued_id,
                "id_license_passport_no" => $id->id_license_passport_no,
                "date_place_issuance" => $id->date_place_issuance,
            ];

            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }

    public function save_pds(Request $request)
    {

        $employee_id = Auth::user()->employee;
        $user_id = Auth::user()->id;

        /* BEGIN::  PERSONAL INFO HERE  */
        employee::updateOrCreate(
            [
                'user_id' => $user_id,
                'agencyid' => $employee_id,
            ],

            [
                'lastname' => strtoupper($request->profile_last_name),
                'firstname' => strtoupper($request->profile_first_name),
                'mi' => strtoupper($request->profile_mid_name),
                'extension' => strtoupper($request->profile_name_extension),
                'dateofbirth' => $request->profile_date_birth,
                'placeofbirth' => strtoupper($request->profile_place_birth),
                'sex' => $request->application_gender,
                'citizenship' => $request->citizenship_value,
                'dual_citizenship_type' => strtoupper($request->citizenship_type_value),
                'dual_citizenship_country' => strtoupper($request->citizenship_country),
                'civilstatus' => $request->profile_civil_status,
                'height' => $request->profile_height,
                'weight' => $request->profile_weight,
                'bloodtype' => strtoupper($request->profile_blood_type),
                'gsis' => strtoupper($request->profile_gsis),
                'pagibig' => strtoupper($request->profile_pagibig),
                'philhealth' => strtoupper($request->profile_philhealth),
                'tin' => strtoupper($request->profile_tin),
                'govissueid' => strtoupper($request->profile_agency),
                'telephone' => $request->profile_tel_number,
                'mobile_number' => $request->profile_mobile_number,
                'email' => $request->profile_email,
                'active' => 1,
            ]
        );
        /* END::  PERSONAL INFO HERE  */


        /* BEGIN::  MY ADDRESS HERE  */
        if ($request->res_address_type) {
            pds_address::updateOrCreate(
                [
                    'employee_id' => $employee_id,
                    'address_type' => $request->res_address_type,
                ],

                [
                    'employee_id' => $employee_id,
                    'address_type' => strtoupper($request->res_address_type),
                    'house_block_no' => strtoupper($request->res_house_block),
                    'street' => strtoupper($request->res_street),
                    'subdivision_village' => strtoupper($request->res_sub),
                    'brgy' => strtoupper($request->res_bgry),
                    'city_mun' => strtoupper($request->res_city_mun),
                    'province' => strtoupper($request->res_province),
                    'zip_code' => $request->res_zip_code,
                    'active' => true,
                ]
            );
        }

        if ($request->per_address_type)
        {
            pds_address::updateOrCreate(
                [
                    'employee_id'=> $employee_id,
                    'address_type' => $request->per_address_type,
                ],

                [
                    'employee_id'=> $employee_id,
                    'address_type' => strtoupper($request->per_address_type),
                    'house_block_no' => strtoupper($request->per_house_block),
                    'street' => strtoupper($request->per_street),
                    'subdivision_village' => strtoupper($request->per_sub),
                    'brgy' => strtoupper($request->per_bgry),
                    'city_mun' => strtoupper($request->per_city_mun),
                    'province' => strtoupper($request->per_province),
                    'zip_code' => $request->per_zip_code,
                    'active' => true,
                ]
            );
        }
        /* END::  MY ADDRESS HERE  */

        /* BEGIN::  Family Background Here  */
        $family_bg_pk = [
            'employee_id'=> $employee_id,
        ];

        pds_family_bg::query()->updateOrCreate($family_bg_pk,

            array_filter([
                'spouse_surname' => strtoupper($request->spouse_surname),
                'spouse_firstname' => strtoupper($request->spouse_firstname),
                'spouse_ext' => strtoupper($request->spouse_name_ext),
                'spouse_mi' => strtoupper($request->spouse_mid_name),

                'father_surname' => strtoupper($request->fam_father_surname),
                'father_firstname' =>  strtoupper($request->fam_father_first_name),
                'father_ext' =>  strtoupper($request->fam_father_name_ext),
                'father_mi' => strtoupper($request->fam_father_mid_name),

                'mother_maidenname' =>  strtoupper($request->fam_mother_maiden_name),
                'mother_surname' => strtoupper($request->fam_mother_surname),
                'mother_firstname' =>  strtoupper($request->fam_mother_first_name),
                'mother_mi' => strtoupper($request->fam_mother_mid_name),

                'occupation' =>  strtoupper($request->spouse_occupation),
                'employer_name' => strtoupper($request->occupation_employer),
                'business_address' =>  strtoupper($request->occupation_address),
                'tel_no' => $request->occupation_tel_no,
                'active' => true,
            ]));

        if ($request->td_input_child_name)
        {
            foreach ($request->td_input_child_name as $list_index => $child)
            {
                $child_name = strtoupper($child);

                $child_list = pds_child_list::updateOrCreate(
                    [
                        'name' => $child_name,
                        'employee_id'=> $employee_id,
                        'birth_date'=> $request->td_input_child_bdate[$list_index],
                    ],

                    [
                        'employee_id'=> $employee_id,
                        'name'=> $child_name,
                        'birth_date'=> $request->td_input_child_bdate[$list_index],
                        'active' => true,
                    ]
                );
            }
        }
        /* END:: Family Background Here  */


        /* BEGIN:: VIII.  OTHER INFORMATION NUMBER 34-40*/
        if($request->_token)
        {
            pds_other_information::updateOrCreate(
                [
                    'employee_id'=> $employee_id,
                ],

                [
                    'employee_id'=> $employee_id,
                    'other_info_34_a' => $request->cb_34_a,
                    'other_info_34_b' => $request->cb_34_b,
                    'other_info_34_b_details' => $request->others_34_b_yes,

                    'other_info_35_a' => $request->cb_35_a,
                    'other_info_35_a_details' => $request->others_35_a_yes,

                    'other_info_35_b' => $request->cb_35_b,
                    'other_info_35_b_details' => $request->others_35_b_yes,
                    'other_info_35_b_date_filed' => $request->others_35_b_date_filed,
                    'other_info_35_b_status' => $request->others_35_b_status_case,

                    'other_info_36' => $request->cb_36,
                    'other_info_36_details' => $request->others_36_yes,

                    'other_info_37' => $request->cb_37,
                    'other_info_37_details' => $request->others_37_yes,

                    'other_info_38_a' => $request->cb_38_a,
                    'other_info_38_a_details' => $request->others_38_a_yes,

                    'other_info_38_b' => $request->cb_38_b,
                    'other_info_38_b_details' => $request->others_38_b_yes,

                    'other_info_39' => $request->cb_39,
                    'other_info_39_details' => $request->others_39_yes,

                    'other_info_40_a' => $request->cb_40_a,
                    'other_info_40_a_details' => $request->others_40_a_yes,

                    'other_info_40_b' => $request->cb_40_b,
                    'other_info_40_b_details' => $request->others_40_b_yes,

                    'other_info_40_c' => $request->cb_40_c,
                    'other_info_40_c_details' => $request->others_40_c_yes,
                    'active'  => 1,
                ]
            );
        }


        if($request->government_id)
        {
            pds_government_id::updateOrCreate(
                [
                    'employee_id'=> $employee_id,
                ],

                [
                    'employee_id'=> $employee_id,
                    'gvt_issued_id'=> $request->government_id,
                    'id_license_passport_no'=> strtoupper($request->government_license_no),
                    'date_place_issuance'=> strtoupper($request->government_license_issuance),
                    'active'  => true,
                ]
            );
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function save_account_settings(Request $request)
    {
        $student_id = Auth::user()->studid;
        $password = trim($request->password);


        User::where('studid', $student_id)->update([

            'password' => $password,

        ]);

        return json_encode(array(

            'status' => 200,

        ));
    }

    public function print_pds($user_id)
    {
        $_user_id = Crypt::decrypt($user_id);
        $employee_id_col = 'employee_id';


        if ($_user_id)
        {
            $pds = employee::with(['res_address','per_address','family_bg'])
                ->where('agencyid', $_user_id)
                ->first();
        }else
        {
            $pds = employee::with(['res_address','per_address','family_bg'])
                ->where('agencyid', Auth::user()->employee)
                ->first();
        }


        if($pds)
        {
            $last_name = $pds->lastname;
            $first_name = $pds->firstname;

            $fullname = $last_name.'_'.$first_name;

        }else
        {
            $fullname = '';
        }

        $filename = $fullname.'_'.'PDS';

        $res_address = pds_address::with(['get_brgy', 'get_province', 'get_city_mun'])->where('address_type', 'RESIDENTIAL')->where($employee_id_col, $_user_id)->where('active', 1)->first();
        $per_address = pds_address::with(['get_brgy', 'get_province', 'get_city_mun'])->where('address_type', 'PERMANENT')->where($employee_id_col, $_user_id)->where('active', 1)->first();

        $elementary = pds_educational_bg::where($employee_id_col, $_user_id)->where('level', 'ELEMENTARY')->first();
        $secondary = pds_educational_bg::where($employee_id_col, $_user_id)->where('level', 'SECONDARY')->first();
        $vocational = pds_educational_bg::where($employee_id_col, $_user_id)->where('level', 'VOCATIONAL_TRADE_COURSE')->first();
        $college = pds_educational_bg::where($employee_id_col, $_user_id)->where('level', 'COLLEGE')->first();
        $masters = pds_educational_bg::where($employee_id_col, $_user_id)->where('level', 'GRADUATE_STUDIES')->first();


        $educational_background = pds_educational_bg::where($employee_id_col, $_user_id)->where('active', 1)->get();
        $count_educ_bg = $educational_background->count();


        $civil_service = pds_cs_eligibility::where($employee_id_col, $_user_id)->where('active', 1)->skip(0)->take(8)->get();
        $count_cs = $civil_service->count();


        $work_experience = pds_work_exp::where($employee_id_col, $_user_id)->where('active', 1)->orderBy('from', 'DESC')->orderBy('to', 'DESC')->get();
        $count_work_exp = $work_experience->count();



        $voluntary_work = pds_voluntary_work::where($employee_id_col, $_user_id)->where('active', 1)->skip(0)->take(6)->orderBy('from', 'DESC')->orderBy('to', 'DESC')->get();
        $count_vol_work = $voluntary_work->count();


        $learning_dev = pds_learning_development::where($employee_id_col, $_user_id)->where('active', 1)->skip(0)->take(21)->orderBy('from', 'DESC')->orderBy('to', 'DESC')->get();
        $count_ld = $learning_dev->count();


        $special_skills = pds_special_skills::where($employee_id_col, $_user_id)->where('active', 1)->skip(0)->take(7)->get();
        $count_special_skills = $special_skills->count();


        $child = pds_child_list::where($employee_id_col, $_user_id)->where('active', 1)->get();
        $count_child = $child->count();

        $other_info = pds_other_information::where($employee_id_col, $_user_id)->where('active', 1)->first();

        $references = pds_references::where($employee_id_col, $_user_id)->where('active', 1)->skip(0)->take(3)->latest('id')->get();

        $government_id = pds_government_id::where($employee_id_col, $_user_id)->where('active', 1)->first();

        $long_BondPaper =  array(0, 0, 612.00, 936.0);

        $pdf = PDF::loadView('my_Profile.PDS.print_pds',
            compact(
                'filename','pds',
                'child',
                'res_address',
                'per_address',
                'educational_background',
                'elementary','secondary','vocational','college', 'masters',

                'civil_service',
                'work_experience',
                'voluntary_work',
                'learning_dev',
                'special_skills',
                'other_info',
                'references',
                'government_id',

                'count_child',
                'count_educ_bg',
                'count_cs',
                'count_work_exp',
                'count_vol_work',
                'count_ld',
                'count_special_skills',

            ))->setPaper($long_BondPaper);


        return $pdf->stream($filename . '.pdf');
    }



    public function get_ref_brgy(Request $request)
    {
        $municipality_code = $request->res_municipality_code;
        $this->_query_ref_brgy($municipality_code);
    }

    public function get_per_brgy(Request $request)
    {
        $municipality_code = $request->per_city_mun_code;

        $this->_query_ref_brgy($municipality_code);
    }

    public function _query_ref_brgy($municipality_code)
    {

        $tres = [];
        $option_val = '';

        $get_brgy = ref_brgy::where('citymunCode', $municipality_code)->get();

        if($get_brgy)
        {
            foreach ($get_brgy as $brgy)
            {
                $brgy_id = $brgy->brgyCode;
                $brgy_ = $brgy->brgyDesc;

                $option_val .= '<option value="'.$brgy->brgyCode.'">'.$brgy->brgyDesc.'</option>';

                $td = [
                    "brgy_id" => $brgy_id,
                    "brgy_" => $brgy_,
                ];

                $tres[count($tres)] = $td;
            }
            echo json_encode($tres);
        }
    }


    public function get_res_municipality(Request $request)
    {
        $province_code = $request->res_province_code;
        $this->_query_ref_municipality($province_code);
    }

    public function _query_ref_municipality($province_code)
    {
        $tres = [];
        $option_val = '';

        $get_city_mun = ref_citymun::where('provCode', $province_code)->get();

        if($get_city_mun)
        {
            foreach ($get_city_mun as $city_mun)
            {
                $city_mun_id = $city_mun->citymunCode;
                $city_mun_ = $city_mun->citymunDesc;

                $td = [
                    "city_mun_id" => $city_mun_id,
                    "city_mun_" => $city_mun_,
                ];

                $tres[count($tres)] = $td;
            }
            echo json_encode($tres);
        }
    }

}
