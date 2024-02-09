<?php

namespace App\Http\Controllers\Clearance;

use App\Http\Controllers\Controller;
use App\Models\agency\agency_employees;
use App\Models\applicant\applicants_academic_bg;
use App\Models\clearance\clearance;
use App\Models\clearance\clearance_csc_iii;
use App\Models\clearance\clearance_csc_iv;
use App\Models\clearance\clearance_csc_others;
use App\Models\clearance\clearance_notes;
use App\Models\clearance\clearance_request;
use App\Models\clearance\clearance_semestral;
use App\Models\clearance\clearance_signatories;
use App\Models\document\doc_modules;
use App\Models\document\_user_privilege;
use App\Models\document\doc_user_rc_g;
use App\Models\global_signatories;
use App\Models\Hiring\tbl_step;
use App\Models\PDS\pds_educational_bg;
use App\Models\system\default_settingNew;
use App\Models\tbl_responsibilitycenter;
use App\Models\tblemployee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use PDF;

class ClearanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function my_clearance()
    {
        $check_my_signatories = clearance_signatories::has('Active_Clearance')->where('clearing_officer', Auth::user()->employee)->where('active', 1)->first();

        if($check_my_signatories)
        {
            $has_signatories = true;
        }else
        {
            $has_signatories = false;
        }
        return view('clearanceSignatories.my_clearance')->with(compact('has_signatories'));
    }

    public function Overview()
    {
        $Clearance_request_count = 0;


        $check_my_signatories = clearance_signatories::has('Active_Clearance')->where('clearing_officer', Auth::user()->employee)->where('active', 1)->first();

        $clearance_request = clearance_request::has('Active_Clearance')->where('status', 1)->where('active', 1)->get();

        if($clearance_request)
        {
            $Clearance_request_count = $clearance_request->count();
        }


        $Clearance_completed_count = clearance_request::has('Active_Clearance')->where('active', 1)->where('completed', 1)->get()->count();


        if($check_my_signatories)
        {
            $has_signatories = true;
        }else
        {
            $has_signatories = false;
        }

        return view('clearanceSignatories.clearance_overview')->with(compact('has_signatories', 'Clearance_completed_count', 'Clearance_request_count'));
    }

    public function load_employee_completed_clearance(Request $request)
    {
        $tres = [];
        $employee_name = '';
        $responsibility_center = 'N/A';
        $position_designation = 'N/A';


        $Clearance_completed_employee = clearance_request::has('Active_Clearance')
                                                            ->with(['Employee_Details'])
                                                            ->where('active', 1)
                                                            ->where('completed', 1)
                                                            ->orderBy('created_at', 'DESC')->get();

        foreach ($Clearance_completed_employee as $data)
        {
            if($data->completed == 1)   //  1 is for Completed True
            {

                if($data->Employee_Details)
                {
                    $first_name = $data->Employee_Details->firstname;
                    $last_name = $data->Employee_Details->lastname;

                    if($data->Employee_Details->mi)
                    {
                        $my_mid_name   = $data->Employee_Details->mi;
                        $my_mid_name_new = substr($my_mid_name, 0, 1);

                        $mi = $my_mid_name_new.'.';

                    }else
                    {
                        $mi = '';
                    }

                    $employee_name = $first_name.' '.$mi.' '.$last_name;
                }

                if ($data->Responsibility_Center)
                {
                    if($data->Responsibility_Center->getOffice)
                    {
                        $responsibility_center = $data->Responsibility_Center->getOffice->centername;
                    }else
                    {
                        $responsibility_center = 'N/A';
                    }

                }

                if ($data->Agency_Employee)
                {
                    if($data->Agency_Employee->getPosition)
                    {
                        $position = $data->Agency_Employee->getPosition->emp_position;
                    }else
                    {
                        $position = 'N/A';
                    }

                    if($data->Agency_Employee->getDesig)
                    {
                        $designation = $data->Agency_Employee->getDesig->userauthority;
                    }
                    else
                    {
                        $designation = 'N/A';
                    }

                    $position_designation = $position .' - '.$designation;

                }

                $date = Carbon::parse($data->date_completed, 'UTC');
                $date_completed = $date->isoFormat('MMMM DD YYYY, h:mm:ss a');

                $td = [

                    "employee_name" => $employee_name,
                    "responsibility_center" => $responsibility_center,
                    "position_designation" => $position_designation,
                    "date_completed" => $date_completed,

                ];

                $tres[count($tres)] = $td;
            }

        }

        echo json_encode($tres);
    }

    public function load_employee_completed_clearance_name(Request $request)
    {
        $clearance_id = trim($request->clearance_id);

        $tres = [];
        $employee_name = '';
        $responsibility_center = 'N/A';
        $position_designation = 'N/A';


        $Clearance_completed_employee =
            clearance_request::has('Active_Clearance')
                                ->with(['Employee_Details'])
                                ->where('active', 1)
                                ->where('clearance_id', $clearance_id)
                                ->where('completed', 1)
                                ->orderBy('created_at', 'DESC')
                                ->get();

        foreach ($Clearance_completed_employee as $data)
        {
            if($data->completed == 1)   //  1 is for Completed True
            {

                if($data->Employee_Details)
                {
                    $first_name = $data->Employee_Details->firstname;
                    $last_name = $data->Employee_Details->lastname;

                    if($data->Employee_Details->mi)
                    {
                        $my_mid_name   = $data->Employee_Details->mi;
                        $my_mid_name_new = substr($my_mid_name, 0, 1);

                        $mi = $my_mid_name_new.'.';

                    }else
                    {
                        $mi = '';
                    }

                    $employee_name = $first_name.' '.$mi.' '.$last_name;
                }

                if ($data->Responsibility_Center)
                {
                    if($data->Responsibility_Center->getOffice)
                    {
                        $responsibility_center = $data->Responsibility_Center->getOffice->centername;
                    }else
                    {
                        $responsibility_center = 'N/A';
                    }

                }

                if ($data->Agency_Employee)
                {
                    if($data->Agency_Employee->getPosition)
                    {
                        $position = $data->Agency_Employee->getPosition->emp_position;
                    }else
                    {
                        $position = 'N/A';
                    }

                    if($data->Agency_Employee->getDesig)
                    {
                        $designation = $data->Agency_Employee->getDesig->userauthority;
                    }
                    else
                    {
                        $designation = 'N/A';
                    }

                    $position_designation = $position .' - '.$designation;

                }

                $date = Carbon::parse($data->date_completed, 'UTC');
                $date_completed = $date->isoFormat('MMMM DD YYYY, h:mm:ss a');

                $td = [

                    "employee_name" => $employee_name,
                    "responsibility_center" => $responsibility_center,
                    "position_designation" => $position_designation,
                    "date_completed" => $date_completed,

                ];

                $tres[count($tres)] = $td;
            }

        }

        echo json_encode($tres);
    }


    public function load_csc_iii_data(Request $request)
    {
        $tres = [];
        $employee_name = '';
        $clearance_id = trim($request->clearance_id);

        $get_csc_iii_data = clearance_csc_iii::with(['getProfile'])->where('clearance_id', $clearance_id)->where('active', 1)->get();

        foreach ($get_csc_iii_data as $data)
        {
            $clearance_type = $data->type;
            $unit_office_dept = $data->unit_office_dept_name;
            $officer_id = $data->clearing_officer;

            if($data->getProfile)
            {
                $first_name = $data->getProfile->firstname;
                $last_name = $data->getProfile->lastname;

                if($data->getProfile->mi)
                {
                    $my_mid_name   = $data->getProfile->mi;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }else
                {
                    $mi = '';
                }

                $employee_name = $first_name.' '.$mi.' '.$last_name;
            }

            $td = [

                "clearance_type"    => $clearance_type,
                "unit_office_dept"  => $unit_office_dept,
                "employee_name"     => $employee_name,
                "officer_id"        => $officer_id,

            ];

            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }

    public function load_csc_iv_data(Request $request)
    {
        $tres = [];
        $employee_name = '';
        $clearance_id = trim($request->clearance_id);

        $get_csc_iii_data = clearance_csc_iv::with(['getProfile'])->where('clearance_id', $clearance_id)->where('active', 1)->get();

        foreach ($get_csc_iii_data as $data)
        {
            $clearance_type = $data->type;
            $unit_office_dept = $data->unit_office_dept_name;
            $officer_id = $data->clearing_officer;

            if($data->getProfile)
            {
                $first_name = $data->getProfile->firstname;
                $last_name = $data->getProfile->lastname;

                if($data->getProfile->mi)
                {
                    $my_mid_name   = $data->getProfile->mi;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }else
                {
                    $mi = '';
                }

                $employee_name = $first_name.' '.$mi.' '.$last_name;
            }

            $td = [

                "clearance_type"    => $clearance_type,
                "unit_office_dept"  => $unit_office_dept,
                "employee_name"     => $employee_name,
                "officer_id"        => $officer_id,

            ];

            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }

    public function load_my_clearance(Request $request)
    {
        $tres = [];
        $can_write  = false;
        $can_create = false;
        $can_delete = false;
        $can_print  = false;
        $is_approved = false;
        $has_requested = false;
        $is_admin = false;

        if (get_User_Privilege())
        {
            foreach (get_User_Privilege() as $user_priv)
            {
                $can_write  = $user_priv['can_write'];
                $can_create = $user_priv['can_create'];
                $can_delete = $user_priv['can_delete'];
                $can_print  = $user_priv['can_print'];
            }
        }

        if(Auth::user()->role_name == 'Admin' || $can_create)
        {
            $is_admin = true;
            $load_sem_clearance = clearance::with(['get_Clearance_Type', 'get_RC', 'get_User_Details', 'check_request'])->get();
        }else
        {
            $load_sem_clearance = clearance::with(['get_Clearance_Type', 'get_RC', 'get_User_Details', 'check_request'])->where('active', 1)->get();
        }

        if($load_sem_clearance)
        {
            foreach ($load_sem_clearance as $sem_clearance)
            {
                $active_clearance = $sem_clearance->active;

                if($sem_clearance)
                {
                    $clearance_id = Crypt::encrypt($sem_clearance->id);
                    $clearance_name = $sem_clearance->name;
                    $clearance_description = $sem_clearance->description;
                    $clearance_type_id = $sem_clearance->type;
                    $my_rc = $sem_clearance->rc;


                    if($sem_clearance->get_User_Details)
                    {
                        $clearance_created_by = $sem_clearance->get_User_Details->firstname.' '.$sem_clearance->get_User_Details->lastname;
                    }else
                    {
                        $clearance_created_by = '';
                    }

                    if($sem_clearance->get_RC)
                    {
                        $rc = $sem_clearance->get_RC->centername;
                    }else
                    {
                        $rc = '';
                    }

                    if($sem_clearance->get_Clearance_Type)
                    {
                        $clearance_type = $sem_clearance->get_Clearance_Type->type;
                    }else
                    {
                        $clearance_type = '';
                    }

                }
                else
                {
                    $clearance_id = '';
                    $clearance_name = '';
                    $clearance_description = '';
                    $clearance_created_by = '';
                    $clearance_type = '';
                    $clearance_type_id = '';
                    $my_rc = '';
                    $rc = '';
                }

                if (get_User_Privilege())
                {
                    foreach (get_User_Privilege() as $user_priv)
                    {
                        $can_write  = $user_priv['can_write'];
                        $can_create = $user_priv['can_create'];
                        $can_delete = $user_priv['can_delete'];
                        $can_print  = $user_priv['can_print'];
                    }
                }

                if($sem_clearance->check_request)
                {
                    $has_requested = true;
                    $check_clearance_request =  $sem_clearance->check_request->status;

                    if($check_clearance_request == '11')
                    {
                        $is_approved = true;

                    }elseif($check_clearance_request == '12')
                    {
                        $is_approved = false;

                    }elseif($check_clearance_request == '1')
                    {
                        $is_approved = 'Pending';
                    }
                }

                if(Auth::user()->role_name == 'Admin')
                {
                    $is_admin = true;
                }

                $td = [

                    "clearance_id" => $clearance_id,
                    "clearance_name" => $clearance_name,
                    "clearance_description" => $clearance_description,
                    "clearance_created_by" => $clearance_created_by,
                    "my_rc" => $my_rc,
                    "rc" => $rc,

                    "clearance_type" => $clearance_type,
                    "clearance_type_id" => $clearance_type_id,


                    "can_write"     => $can_write,
                    "can_create"    => $can_create,
                    "can_delete"    => $can_delete,
                    "can_print"     => $can_print,
                    "has_requested" => $has_requested,
                    "is_approved" => $is_approved,
                    "is_admin" => $is_admin,
                    "active_clearance" => $active_clearance,

                ];

                $tres[count($tres)] = $td;
            }
        }

        echo json_encode($tres);
    }

    public function create_new_clearance(Request $request)
    {
        if($request->clearance_type)
        {
            $insert_new_clearance = [
                'type'          => trim($request->clearance_type),
                'name'          => trim($request->clearance_name),
                'description'   => trim($request->clearance_desc),
                'rc'            => trim($request->clearance_rc),
                'created_by'    => Auth::user()->employee,
                'active'  => 1,
            ];

           $clearance = clearance::create($insert_new_clearance);

            return json_encode(array(

                "status" => 200,
                "clearance_id" => Crypt::encrypt($clearance->id),
            ));
        }


//        if($clearance_created)
//        {
//            if($request->approval_sem_clearance_user_id)
//            {
//                foreach ($request->approval_sem_clearance_user_id as $list_index => $user_id)
//                {
//                    $insert_global_signature = [
//                        'name'          => trim($request->approval_sem_clearance_user_name[$list_index]),
//                        'type'          => trim('Semestral_Clearance'),
//                        'type_id'       => $clearance_created->id,
//                        'employee_id'   => $user_id,
//                        'for'           => trim($request->approval_sem_clearance_desc[$list_index]),
//                        'description'   => trim($request->approval_sem_clearance_desc[$list_index]),
//                        'created_by'    => Auth::user()->employee,
//                        'active'  => 1,
//                    ];
//                    global_signatories::create($insert_global_signature);
//                }
//            }
//
//            if($request->sem_clearance_docs)
//            {
//                foreach ($request->sem_clearance_docs as $list_index => $docs)
//                {
//                    $insert_sem_clearance = [
//                        'clearance_id' => $clearance_created->id,
//                        'documents'    => trim($docs),
//                        'signatory'    => trim($request->sem_clearance_sign[$list_index]),
//                        'office'       => trim($request->sem_clearance_rc[$list_index]),
//                        'active'       => 1,
//                        'created_by'   => Auth::user()->employee,
//                    ];
//                    clearance_semestral::create($insert_sem_clearance);
//                }
//            }
//
//            return json_encode(array(
//                "status" => 200,
//            ));
//        }
//        else
//        {
//            return json_encode(array(
//                "status" => 500,
//            ));
//        }

    }
    public function update_created_csc(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);

        clearance::where('id', $clearance_id)->update([

            'name' => trim($request->clearance_name),
            'description' => trim($request->clearance_desc),
            'updated_by' => Auth::user()->employee,

        ]);


        return json_encode(array(

            "status" => 200,

        ));
    }




    public function get_Responsibility_Center(Request $request)
    {
        $check_rc = agency_employees::with(['get_RC'])->where('agency_id', Auth::user()->employee)->where('active', 1)->first();

        $immediate_head_option = '';
        $position_option = '';

        if($check_rc)
        {
            if($check_rc->get_RC)
            {
                $rc_id = $check_rc->get_RC->responid;

                if($check_rc->get_RC->rc_head)
                {
                    $agency_id = $check_rc->get_RC->rc_head->agencyid;
                    $first_name = $check_rc->get_RC->rc_head->firstname;
                    $mid_name = $check_rc->get_RC->rc_head->mi;
                    $last_name = $check_rc->get_RC->rc_head->lastname;

                    if($check_rc->get_RC->rc_head->mi)
                    {
                        $my_mid_name   = $check_rc->get_RC->rc_head->mi;
                        $my_mid_name_new = substr($my_mid_name, 0, 1);

                        $mi = $my_mid_name_new.'.';

                    }else
                    {
                        $mi = '';
                    }

                    $full_name = $first_name.' '.$mi.' '.$last_name;

                    $immediate_head_option .= '<option value="'.$agency_id.'">'.$full_name.'</option>';

                }else
                {
                    $full_name = 'No Data';
                    $immediate_head_option = '<option value="">No Data Found</option>';
                }

            }
            else
            {
                $rc_id = '';
                $full_name = 'No Data';
            }

            if($check_rc->get_position)
            {
                $position_id = $check_rc->get_position->id;
                $position = $check_rc->get_position->emp_position;

                $position_option .= '<option value="'.$position_id.'">'.$position.'</option>';
            }
            else
            {
                $positions = get_employee_position();

                if($positions)
                {
                    foreach ($positions as $data)
                    {
                        $position_option .= '<option value="'.$data->id.'">'.$data->emp_position.'</option>';
                    }
                }
            }

            return json_encode(array(

                "rc_id" => $rc_id,
                "position_option" => $position_option,
                "immediate_head" => $immediate_head_option,

                ));
        }
    }
    public function get_Agency(Request $request)
    {
        $default_agency = default_settingNew::where('key', 'agency_name')->where('active', 1)->first();

        if($default_agency)
        {
            $agency = $default_agency->value;
        }else
        {
            $agency = 'Not Set';
        }

        return json_encode(array(

            "agency" => $agency,

        ));
    }
    public function get_sg_steps(Request $request)
    {
        $_query_sg_steps = tbl_step::where('sg_id', $request->sg_id)->get();
        $sg_step_options = '';

        if($_query_sg_steps)
        {
            foreach ($_query_sg_steps as $steps)
            {
                $sg_step_options .= '<option data-ass-type="desig" value="' . $steps->id . '">' . $steps->stepname . '</option>';
            }

            return json_encode(array(

                "sg_step_options" => $sg_step_options,

            ));
        }
    }




    public function load_csc_clearance_III(Request $request)
    {
        $can_write  = false;
        $can_create = false;
        $can_delete = false;
        $can_print  = false;

        $clearance_id = Crypt::decrypt($request->clearance_id);

        $clearance_III = '';

        $_get = clearance_csc_iii::with('getProfile')->where('clearance_id', $clearance_id)->where('active', 1)->get();

        if($_get)
        {
            foreach ($_get as $data)
            {
                $iii_clearance_id = Crypt::encrypt($data->id);
                $type = $data->type;
                $unit_office_dept_name = $data->unit_office_dept_name;
                $cleared = $data->cleared;
                $clearing_officer_id = $data->clearing_officer;
                $not_cleared = $data->not_cleared;

                if($data->getProfile)
                {
                    $first_name = $data->getProfile->firstname;
                    $mid_name = $data->getProfile->mi;
                    $last_name = $data->getProfile->lastname;

                    if($data->getProfile->mi)
                    {
                        $my_mid_name   = $data->getProfile->mi;
                        $my_mid_name_new = substr($my_mid_name, 0, 1);

                        $mi = $my_mid_name_new.'.';

                    }else
                    {
                        $mi = '';
                    }

                    $clearing_officer = $first_name.' '.$mi.' '.$last_name;

                    if($data->getProfile->e_signature)
                    {
                        $signature = $data->getProfile->e_signature;
                        $signature_table_row = '<td class="whitespace-nowrap">'.$signature.'</td>';
                    }else
                    {
                        $signature = 'No e-signature attached';
                        $signature_table_row = '<td class="whitespace-nowrap text-danger text-center">'.$signature.'</td>';
                    }


                }
                else
                {
                    $clearing_officer = 'N/A';
                    $signature = 'No e-signature attached';
                    $signature_table_row = '<td class="whitespace-nowrap text-danger text-center">'.$signature.'</td>';
                    $clearing_officer_id = '';
                }

                if(Auth::user()->role_name == 'Admin')
                {
                    $is_admin = true;
                }else
                {
                    $is_admin = false;
                }

                if (get_User_Privilege())
                {
                    foreach (get_User_Privilege() as $user_priv)
                    {
                        $can_write  = $user_priv['can_write'];
                        $can_create = $user_priv['can_create'];
                        $can_delete = $user_priv['can_delete'];
                        $can_print  = $user_priv['can_print'];
                    }
                }

                if($can_write || $is_admin)
                {
                    $edit_button = '<a href="javascript:void(0);" class=" text-theme-6 text-center mr-5 update_III_clearance"
                                                data-iii-clearanceSignatories-id   ="' . $iii_clearance_id . '"
                                                data-iii-clearanceSignatories-type ="' . $type . '"
                                                data-iii-unit-office    ="' . $unit_office_dept_name . '"
                                                data-iii-cleared        ="' . $cleared . '"
                                                data-iii-not-cleared    ="' . $not_cleared . '"
                                                data-iii-officer-id    ="' . $clearing_officer_id . '"
                                            >
                                            <i class="fa-solid fa-pen-to-square w-4 h-4 text-success"></i></a>';
                }else
                {
                    $edit_button = '';
                }

                if($can_delete || $is_admin)
                {
                    $delete_button = '<a href="javascript:void(0);" class=" text-theme-6 delete_iii_clearance text-center"  data-iii-clearanceSignatories-id="' . $iii_clearance_id . '"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>';
                }else
                {
                    $delete_button = '';
                }



                $clearance_III .= '<tr>
                                    <td class="whitespace-nowrap">'.$type.'</td>
                                    <td class="whitespace-nowrap">'.$unit_office_dept_name.'</td>

                                    <td class="whitespace-nowrap text-center">'.$clearing_officer.'</td>
                                    '.$signature_table_row.'
                                    <td>

                                        <div class="flex justify-center items-center">

                                            '.$edit_button.'
                                            '.$delete_button.'

                                        </div>
                                    </td>
                                </tr>';
            }
            return json_encode(array(

                "clearance_III" => $clearance_III,

            ));
        }
    }
    public function add_clearance_iii(Request $request)
    {

        $clearance_id = Crypt::decrypt($request->clearance_id);

        clearance_csc_iii::updateOrCreate(
            [
                'clearance_id' => $clearance_id,
                'type'=> $request->csc_clearance_office_type,
                'unit_office_dept_name'=> $request->csc_clearance_unit_office_name,
            ],

            [
                'clearance_id' => $clearance_id,
                'type'=> $request->csc_clearance_office_type,
                'unit_office_dept_name'=> $request->csc_clearance_unit_office_name,
                'clearing_officer'=> $request->csc_clearance_employees,
                'active'=> 1,
            ]
        );

        return json_encode(array(
            'status' => 200,
        ));
    }
    public function update_csc_clearance_III(Request $request)
    {

        $csc_iii_id = Crypt::decrypt($request->csc_iii_id);

        clearance_csc_iii::where('id', $csc_iii_id)->update([

            'type'                  => $request->csc_clearance_office_type,
            'unit_office_dept_name' => $request->csc_clearance_unit_office_name,
            'clearing_officer'      => $request->csc_clearance_employees,

        ]);

        return json_encode(array(
            'status' => 200,
        ));
    }
    public function delete_csc_clearance_III(Request $request)
    {

        $csc_iii_id = Crypt::decrypt($request->csc_iii_id);

        clearance_csc_iii::where('id', $csc_iii_id)->update([

            'active' => 0,

        ]);

        return json_encode(array(
            'status' => 200,
        ));
    }


    public function add_csc_iii_data_setup(Request $request)
    {

        $clearance_id = Crypt::decrypt($request->clearance_id);

        clearance_csc_iii::updateOrCreate(
            [
                'clearance_id' => $clearance_id,
                'type'=> $request->clearance_type,
                'unit_office_dept_name'=> $request->unit_office_dept,
            ],

            [
                'clearance_id' => $clearance_id,
                'type'=> $request->clearance_type,
                'unit_office_dept_name'=> $request->unit_office_dept,
                'clearing_officer'=> $request->officer_id,
                'active'=> 1,
            ]
        );

        return json_encode(array(
            'status' => 200,
        ));
    }

    public function add_csc_iv_data_setup(Request $request)
    {

        $clearance_id = Crypt::decrypt($request->clearance_id);

        clearance_csc_iv::updateOrCreate(
            [
                'clearance_id' => $clearance_id,
                'type'=> $request->clearance_type,
                'unit_office_dept_name'=> $request->unit_office_dept,
            ],

            [
                'clearance_id' => $clearance_id,
                'type'=> $request->clearance_type,
                'unit_office_dept_name'=> $request->unit_office_dept,
                'clearing_officer'=> $request->officer_id,
                'active'=> 1,
            ]
        );

        return json_encode(array(
            'status' => 200,
        ));
    }



    public function load_csc_clearance_IV(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);

        $clearance_IV = '';

        $_get = clearance_csc_iv::with('getProfile')->where('clearance_id', $clearance_id)->where('active', 1)->get();

        if($_get)
        {
            foreach ($_get as $data)
            {
                $iii_clearance_id = Crypt::encrypt($data->id);
                $type = $data->type;
                $unit_office_dept_name = $data->unit_office_dept_name;
                $cleared = $data->cleared;
                $clearing_officer_id = $data->clearing_officer;
                $not_cleared = $data->not_cleared;

                if($data->getProfile)
                {
                    $first_name = $data->getProfile->firstname;
                    $mid_name = $data->getProfile->mi;
                    $last_name = $data->getProfile->lastname;

                    if($data->getProfile->mi)
                    {
                        $my_mid_name   = $data->getProfile->mi;
                        $my_mid_name_new = substr($my_mid_name, 0, 1);

                        $mi = $my_mid_name_new.'.';

                    }else
                    {
                        $mi = '';
                    }

                    $clearing_officer = $first_name.' '.$mi.' '.$last_name;

                    if($data->getProfile->e_signature)
                    {
                        $signature = $data->getProfile->e_signature;
                        $signature_table_row = '<td class="whitespace-nowrap text-center">'.$signature.'</td>';
                    }else
                    {
                        $signature = 'No e-signature attached';
                        $signature_table_row = '<td class="whitespace-nowrap text-danger text-center">'.$signature.'</td>';
                    }

                }
                else
                {
                    $clearing_officer = 'N/A';
                    $signature = 'No e-signature attached';
                    $signature_table_row = '<td class="whitespace-nowrap text-danger text-center">'.$signature.'</td>';
                    $clearing_officer_id = '';
                }

                $clearance_IV .= '<tr>
                                    <td class="whitespace-nowrap">'.$type.'</td>
                                    <td class="whitespace-nowrap">'.$unit_office_dept_name.'</td>

                                    <td class="whitespace-nowrap text-center">'.$clearing_officer.'</td>
                                    '.$signature_table_row.'
                                    <td >
                                        <div class="flex justify-center items-center">

                                            <a href="javascript:void(0);" class=" text-theme-6 text-center mr-5 update_IV_clearance"
                                                data-iv-clearanceSignatories-id   ="' . $iii_clearance_id . '"
                                                data-iv-clearanceSignatories-type ="' . $type . '"
                                                data-iv-unit-office    ="' . $unit_office_dept_name . '"
                                                data-iv-cleared        ="' . $cleared . '"
                                                data-iv-not-cleared    ="' . $not_cleared . '"
                                                data-iv-officer-id    ="' . $clearing_officer_id . '"
                                            >
                                            <i class="fa-solid fa-pen-to-square w-4 h-4 text-success"></i></a>

                                            <a href="javascript:void(0);" class=" text-theme-6 delete_IV_clearance text-center tbl_btn_delete_csc_iv"  data-iii-clearanceSignatories-id="' . $iii_clearance_id . '"><i  class="w-4 h-4 text-danger fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>';
            }
            return json_encode(array(

                "clearance_IV" => $clearance_IV,

            ));
        }
    }
    public function add_clearance_IV(Request $request)
    {

        $clearance_id = Crypt::decrypt($request->clearance_id);

        clearance_csc_iv::updateOrCreate(
            [
                'clearance_id' => $clearance_id,
                'type'=> $request->csc_clearance_office_type,
                'unit_office_dept_name'=> $request->csc_clearance_unit_office_name,
            ],

            [
                'clearance_id' => $clearance_id,
                'type'=> $request->csc_clearance_office_type,
                'unit_office_dept_name'=> $request->csc_clearance_unit_office_name,
                'clearing_officer'=> $request->csc_clearance_employees,
                'active'=> 1,
            ]
        );

        return json_encode(array(
            'status' => 200,
        ));
    }

    public function update_csc_clearance_IV(Request $request)
    {

        $csc_iii_id = Crypt::decrypt($request->csc_iii_id);

        clearance_csc_iv::where('id', $csc_iii_id)->update([

            'type'                  => $request->csc_clearance_office_type,
            'unit_office_dept_name' => $request->csc_clearance_unit_office_name,
            'clearing_officer'      => $request->csc_clearance_employees,

        ]);

        return json_encode(array(
            'status' => 200,
        ));
    }
    public function delete_csc_clearance_IV(Request $request)
    {

        $csc_iii_id = Crypt::decrypt($request->csc_iii_id);

        clearance_csc_iv::where('id', $csc_iii_id)->update([

            'active' => 0,

        ]);

        return json_encode(array(
            'status' => 200,
        ));
    }





    public function load_csc_clearance_information(Request $request)
    {

        $clearance_id = Crypt::decrypt($request->clearance_id);

        $purpose = '';
        $purpose_others = '';
        $date_filing = '';
        $date_effective = '';

        $rc = '';
        $position = '';
        $sg = '';
        $step = '';

        $cleared = '';
        $immediate_supervisor = '';

        $case = '';

        $_get = clearance_csc_others::where('clearance_id', $clearance_id)->where('active', 1)->get();

        if($_get)
        {
            foreach ($_get as $data)
            {
                $purpose = $data->purpose;
                $purpose_others = $data->purpose_others;
                $date_filing = $data->date_filing;
                $date_effective = $data->date_effective;

                $rc = $data->rc;
                $position = $data->position;
                $sg = $data->sg;
                $step = $data->step;

                $cleared = $data->cleared;
                $immediate_supervisor = $data->immediate_supervisor;

                $case = $data->case;
            }
        }
        return json_encode(array(

            "purpose" => $purpose,
            "purpose_others" => $purpose_others,
            "date_filing" => $date_filing,
            "date_effective" => $date_effective,
            "rc" => $rc,
            "position" => $position,
            "sg" => $sg,
            "step" => $step,
            "cleared" => $cleared,
            "immediate_supervisor" => $immediate_supervisor,

            "emp_case" => $case,

        ));
    }





    public function create_my_csc_clearance(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);
        $employee_id = Auth::user()->employee;

        clearance_csc_others::updateOrCreate(
            [
                'clearance_id' => $clearance_id,
                'employee_id' => $employee_id,
            ],

            [
                'clearance_id' => $clearance_id,
                'employee_id' => $employee_id,
                'purpose' => $request->purpose,
                'purpose_others' => $request->others_mode_sep,
                'date_filing' => $request->date_filing,
                'date_effective' => $request->date_effective,
                'rc' => $request->csc_clearance_rc,
                'position' => $request->csc_clearance_pos,
                'sg' => $request->csc_clearance_sg,
                'step' => $request->csc_clearance_step,
                'cleared' => $request->cleared_or_not,
                'immediate_supervisor' => $request->csc_immediate_supervisor,
                'case' => $request->pending_or_ongoing,
                'active'=> 1,
            ]
        );

        return json_encode(array(
            'status' => 200,
        ));
    }
    public function check_clearance_request(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);
        $employee_id = Auth::user()->employee;

        $check_request = clearance_request::where('clearance_id', $clearance_id)->where('employee_id', $employee_id)->first();


        if(!$check_request)
        {
            return json_encode(array(

                "status" => 200,
                'can_request' => true,

            ));
        }else
        {
            return json_encode(array(

                "status" => 500,
                'can_request' => false,

            ));
        }

    }
    public function send_request_csc_clearance(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);
        $request_note = $request->csc_note_request;

        $get_signatories_csc_iii = clearance_csc_iii::where('clearance_id', $clearance_id)->get();

        if ($get_signatories_csc_iii)
        {
            $send_request = [
                'clearance_id'      => trim($clearance_id),
                'employee_id'       => Auth::user()->employee,
                'request_note'      => trim($request_note),
                'status'       => 1,
                'active'            => 1,
            ];
            $clearance_request = clearance_request::create($send_request);

            foreach ($get_signatories_csc_iii as $data)
            {
                $clearing_officer = $data->clearing_officer;

                $add_signatories = [

                    'clearance_id'          => trim($clearance_id),
                    'clearance_request_id'  => $clearance_request->id,
                    'employee_id'           => Auth::user()->employee,
                    'clearing_officer'      => $clearing_officer,
                    'status'                => 1,
                    'active'                => 1,
                ];

                clearance_signatories::create($add_signatories);
            }

            return json_encode(array(

                "status" => 200,

            ));
        }
    }





    public function get_my_csc_clearance_iii(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);
        $counter = 1; //List Number
        $alphabet = range('a', 'z'); //Sub-List Number
        $My_III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES = '';

        $_query_csc_iii_data = clearance_csc_iii::with(['getProfile', 'Signatories'])->where('clearance_id', $clearance_id)->where('active', 1)->get();

        if($_query_csc_iii_data)
        {
            $grouped_csc_iii_data = $_query_csc_iii_data->groupBy(function($item,$key)
            {
                return $item->type;     //Return Office Type

            })->sortBy(function($item,$key){

                //sorts A-Z at the top level
                return $key;

            });

            foreach ($grouped_csc_iii_data as $key => $tr_data)
            {
                $count = $counter++;

                $My_III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES .=
                    '<tr style="background:#eaeaea;">
                        <td style="width: 26px; height: 5px" class="border-l border-t">
                            <div class="text-left px-1"><label class="text-xs">'.$count.'.'.'</label></div>
                        </td>
                        <td colspan="6" style="height: 5px" class="border-r border-t">
                            <div class="text-left px-1"><label class="text-xs">'.$key.'</label></div>
                        </td>
                    </tr>';

                foreach($tr_data as $index => $table_row)
                {
                    $officer_name = $table_row->getProfile->firstname.' '.substr($table_row->getProfile->mi, 0, 1).'. '. $table_row->getProfile->lastname;

                    $table_number = $alphabet[$index];

                    $My_III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES .=
                        '<tr>
                        <td width="5%" height="30px" class="border-l border-r">
                            <div class="text-right px-1"><label class="text-xs">'.$table_number.'.'.'</label></div>
                        </td>

                        <td width="35%" height="30px" class="border-l border-r">
                            <div class="text-left px-1"><label class="text-xs">'.$table_row->unit_office_dept_name.'</label></div>
                        </td>
                        <td width="10%" height="30px" class="border-l border-r">
                            <div class="text-center px-1 arial font-normal text-11px mt-1">
                                <label></label>
                            </div>
                        </td>
                        <td width="10%" height="30px" class="border-l border-r">
                            <div class="text-center px-1 arial font-normal text-11px mt-1">
                                <label></label>
                            </div>
                        </td>
                        <td width="30%" height="30px" class="border-l border-r">
                            <div class="text-center text-xs">
                                <label>'.$officer_name.'</label>
                            </div>
                        </td>
                        <td width="10%" height="30px" class="border-l border-r">
                            <div class="text-center px-1 arial font-normal text-11px mt-1">
                                <label></label>
                            </div>
                        </td>
                    </tr>';
                }
            }
            return json_encode(array(

                'My_III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES' => $My_III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES,

            ));
        }
    }
    public function get_my_csc_clearance_iv(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);
        $counter = 1; //List Number
        $alphabet = range('a', 'z'); //Sub-List Number
        $My_IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES = '';

        $_query_csc_iv_data = clearance_csc_iv::with('getProfile')->where('clearance_id', $clearance_id)->get();

        $grouped_csc_iv_data = $_query_csc_iv_data->groupBy(function($item,$key)
        {
            return $item->type;     //Return Office Type

        })->sortBy(function($item,$key){

            return $key;

        });

        $iv_counter = 1;

        foreach ($grouped_csc_iv_data as $key => $tr_data)
        {

            $iv_count = $iv_counter++;

            if($key == 'N/A' || $key == null || $key == '')
            {
                $My_IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES = '';


            }
            else
            {
                $My_IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES =
                    '<tr>
                        <td width="26px" class="border-l border-t">
                            <div class="text-left px-1"><label class="text-xs">IV</label></div>
                        </td>
                        <td colspan="6" class="border-r border-t">
                            <div class="text-left px-1"><label class="text-xs">CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE:</label></div>
                        </td>
                    </tr>';

                $My_IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES .=
                    '<tr>
                        <td width="26px" class="border-l border-t">
                            <div class="text-left px-1"><label class="text-xs">'.$iv_count.'.'.'</label></div>
                        </td>
                        <td colspan="6" class="border-r border-t">
                            <div class="text-left px-1"><label class="text-xs">'.$key.'</label></div>
                        </td>
                    </tr>';
            }


            foreach($tr_data as $index => $table_row)
            {
                if($table_row->getProfile)
                {
                    $officer_name = $table_row->getProfile->firstname.' '.substr($table_row->getProfile->mi, 0, 1).'. '. $table_row->getProfile->lastname;
                }
                else
                {
                    $officer_name = 'N/A';
                }



                $table_number = $alphabet[$index];

                $My_IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES .=
                    '<tr>
                        <td width="5%" height="30px" class="border-l border-r">
                            <div class="text-right px-1"><label class="text-xs">'.$table_number.'.'.'</label></div>
                        </td>

                        <td width="35%" height="30px" class="border-l border-r">
                            <div class="text-left px-1"><label class="text-xs">'.$table_row->unit_office_dept_name.'</label></div>
                        </td>
                        <td width="10%" height="30px" class="border-l border-r">
                            <div class="text-center px-1 arial font-normal text-11px mt-1">
                                <label></label>
                            </div>
                        </td>
                        <td width="10%" height="30px" class="border-l border-r">
                            <div class="text-center px-1 arial font-normal text-11px mt-1">
                                <label></label>
                            </div>
                        </td>
                        <td width="30%" height="30px" class="border-l border-r">
                            <div class="text-center text-xs">
                                <label>'.$officer_name.'</label>
                            </div>
                        </td>
                        <td width="10%" height="30px" class="border-l border-r">
                            <div class="text-center px-1 arial font-normal text-11px mt-1">
                                <label></label>
                            </div>
                        </td>
                    </tr>';
            }
            return json_encode(array(

                'My_IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES' => $My_IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES,

            ));
        }
    }
    public function get_my_csc_clearance_others(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);
        $employee_id = Auth::user()->employee;

        $purpose = '';
        $purpose_others = '';
        $date_filing = '';
        $date_effective = '';
        $rc = '';
        $position = '';
        $sg = '';
        $step = '';
        $cleared = '';
        $immediate_supervisor = '';
        $case = '';

        $others = clearance_csc_others::where('clearance_id', $clearance_id)->where('employee_id', $employee_id)->first();

        if ($others)
        {
            $purpose        = $others->purpose;
            $purpose_others = $others->purpose_others;
            $date_filing    = $others->date_filing;
            $date_effective = $others->date_effective;
            $rc             = $others->rc;
            $position       = $others->position;
            $sg             = $others->sg;
            $step           = $others->step;
            $cleared        = $others->cleared;
            $immediate_supervisor = $others->immediate_supervisor;
            $case           = $others->case;
        }
        return json_encode(array(

            'purpose'           => $purpose,
            'purpose_others'    => $purpose_others,
            'date_filing'       => $date_filing,
            'date_effective'    => $date_effective,
            'rc'                => $rc,
            'position'          => $position,
            'sg'                => $sg,
            'step'              => $step,
            'cleared'           => $cleared,
            'immediate_supervisor' => $immediate_supervisor,
            'case_data'         => $case,
        ));
    }





    public function load_admin_clearance_request(Request $request)
    {
        $check_requests = clearance_request::with(['Employee_Details', 'Clearance_Details', 'Status_Codes'])
                                            ->where('active', 1)
                                            ->where('status', 1)
                                            ->orWhere('status', 12)
                                            ->orderBy('updated_at', 'DESC')
                                            ->get();

        $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
        $get_image = $query->image;
        $profile_pic = url('') . "/uploads/settings/" . $get_image;

        $raw_image      = '';
        $first_name     = '';
        $middle_name    = '';
        $last_name      = '';
        $extension      = '';
        $full_name      = '';
        $mi             = '';
        $html_data      = '';
        $clearance_name = '';
        $clearance_id   = '';
        $clearance_request_id   = '';
        $status   = '';
        $class    = '';

        if($check_requests)
        {
            foreach ($check_requests as $data)
            {
                $clearance_request_id = $data->id;
                $clearance_id = $data->clearance_id;

                if($data->Clearance_Details)
                {
                    $clearance_name = $data->Clearance_Details->name;
//                    $clearance_id = $data->Clearance_Details->id;
                }

                if ($data->Employee_Details)
                {
                    $first_name     = $data->Employee_Details->firstname;
                    $middle_name    = $data->Employee_Details->mi;
                    $last_name      = $data->Employee_Details->lastname;
                    $extension      = $data->Employee_Details->extension;

                    if ($data->Employee_Details->image)
                    {
                        $profile_pic = url('') . "/uploads/profiles/" . $data->Employee_Details->image;
                    }else
                    {
                        $query = default_settingNew::where('key', 'agency_logo')->where('active', true)->first();
                        $get_image = $query->image;
                        $profile_pic = url('') . "/uploads/settings/" . $get_image;
                    }

                    if($data->Employee_Details->mi)
                    {
                        $my_mid_name        = $data->Employee_Details->mi;
                        $my_mid_name_new    = substr($my_mid_name, 0, 1);

                        $mi = $my_mid_name_new.'.';
                    }

                    $full_name = $first_name.' '.$mi.' '.$last_name.' '.$extension;
                }

                if($data->Status_Codes)
                {
                    $status = $data->Status_Codes->name;
                    $class  = $data->Status_Codes->class;
                }

                $requested_at = $data->created_at->diffForHumans();

                $html_data .=
                    '<div   data-clearanceSignatories-id="'.$clearance_id.'"
                            data-clearanceSignatories-name="'.$clearance_name.'"
                            data-clearanceSignatories-request-id="'.$clearance_request_id.'"
                            class="intro-x clearance_request_btn">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Profile Picture" src="'.$profile_pic.'">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">'.$full_name.'</div>
                                    <div class="text-slate-500 text-xs mt-0.5">'.$requested_at.'</div>
                                </div>
                                <div class="text-'.$class.'">'.$status.'</div>
                            </div>
                        </div>';
            }
        }

        return json_encode(array(

            'request_html_data' => $html_data,

        ));

    }
    public function approve_disapprove_request(Request $request)
    {
        $clearance_id = trim($request->clearance_id);
        $clearance_request_id = trim($request->clearance_request_id);

        clearance_request::where('clearance_id', $clearance_id)
                         ->where('id', $clearance_request_id)
                         ->update([

                            'status' => $request->approval,
                            'response_note' => $request->clearance_response_note,

                        ]);

        return json_encode(array(
            'status' => 200,
        ));
    }






    public function load_my_signatories(Request $request)
    {

        $raw_image      = '';
        $first_name     = '';
        $middle_name    = '';
        $last_name      = '';
        $extension      = '';
        $full_name      = '';
        $mi             = '';
        $html_data      = '';
        $clearance_name = '';
        $clearance_id   = '';
        $signatory_id   = '';
        $status   = '';
        $class    = '';
        $unit_office    = '';
        $employee_id    = '';
        $has_request    = false;

        $check_if_request_approved = clearance_request::has('Active_Clearance')->where('status', 11)->where('active', 1)->get();

        if ($check_if_request_approved)
        {
            $has_request = true;
            foreach ($check_if_request_approved as $data)
            {
                if($data)
                {
                    $check_signatories = clearance_signatories::has('Active_Clearance')
                        ->with(['Employee_Details', 'Unit_Office'])
                        ->where('clearing_officer', Auth::user()->employee)
                        ->where('active', 1)
                        ->where('status', 1)
                        ->orWhere('status', 4)
                        ->orderBy('updated_at', 'DESC')
                        ->get();


                    if($check_signatories)
                    {
                        foreach ($check_signatories as $data)
                        {
                            $signatory_id = $data->id;
                            $clearance_request_id = $data->clearance_request_id;

                            if($data->Clearance_Details)
                            {
                                $clearance_name = $data->Clearance_Details->name;
                                $clearance_id = $data->Clearance_Details->id;
                            }

                            if ($data->Employee_Details)
                            {
                                $employee_id    = $data->Employee_Details->agencyid;
                                $first_name     = $data->Employee_Details->firstname;
                                $middle_name    = $data->Employee_Details->mi;
                                $last_name      = $data->Employee_Details->lastname;
                                $extension      = $data->Employee_Details->extension;

                                if ($data->Employee_Details->image)
                                {
                                    $profile_picture = url('') . "/uploads/profiles/" . $data->Employee_Details->image;
                                }else
                                {
                                    $query = default_settingNew::where('key', 'agency_logo')->where('active', 1)->first();
                                    $get_default = $query->image;
                                    $profile_picture = url('') . "/uploads/settings/" . $get_default;
                                }


                                if($data->Employee_Details->mi)
                                {
                                    $my_mid_name        = $data->Employee_Details->mi;
                                    $my_mid_name_new    = substr($my_mid_name, 0, 1);

                                    $mi = $my_mid_name_new.'.';
                                }

                                $full_name = $first_name.' '.$mi.' '.$last_name.' '.$extension;
                            }

                            if($data->Status_Codes)
                            {
                                $status = $data->Status_Codes->name;
                                $class  = $data->Status_Codes->class;
                            }

                            if($data->Unit_Office)
                            {
                                $unit_office = $data->Unit_Office->unit_office_dept_name;
                            }



                            $requested_at = $data->updated_at->diffForHumans();

                            $html_data .=
                                '<div   data-clearanceSignatories-id   =   "'.$clearance_id.'"
                            data-unit-office    =   "'.$unit_office.'"
                            data-clearanceSignatories-name =   "'.$clearance_name.'"
                            data-signatory-id   =   "'.$signatory_id.'"
                            data-employee-id    =   "'.$employee_id.'"
                            data-request-id    =   "'.$clearance_request_id.'"
                            class="intro-x clearance_signatories_btn">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Profile Picture" src="'.$profile_picture.'">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">'.$full_name.'</div>
                                     <div class="text-slate-500 text-xs mt-0.5">'.$requested_at.'</div>
                                </div>
                                <div class="text-'.$class.'">'.$status.'</div>
                            </div>
                        </div>';
                        }
                    }

                    return json_encode(array(

                        'signatories_html_data' => $html_data,
                        'unit_office' => $unit_office,

                    ));
                }
            }

            return json_encode(array(

                'signatories_html_data' => $html_data,
                'tae' => $has_request,

            ));

        }
    }
    public function submit_my_signatory(Request $request)
    {
        $signatory_id = trim($request->mdl_input_signatory_id);
        $employee_id = trim($request->mdl_input_employee_id);
        $request_id = trim($request->mdl_input_clearance_request_id);

        if($request->cleared_checkbox == '1')
        {
            clearance_notes::where('employee_id', $employee_id)->where('created_by', Auth::user()->employee)->where('dismiss', 1)->update([
               'dismiss' => 0,
            ]);
            $status = 7;    //Completed

        }else
        {
            $status = 17;   //Failed
        }

        clearance_signatories::where('id', $signatory_id)->update([

           'cleared'    => $request->cleared_checkbox,
           'note'       => $request->mdl_signatory_note,
           'signature'  => $request->signature_checkbox,
           'status'     => $status,

        ]);



        $count_signatories = clearance_signatories::where('employee_id', $employee_id)
                            ->where('clearance_request_id', $request_id)
                            ->where('active', 1)
                            ->get()->count();

        $check_cleared = clearance_signatories::where('employee_id', $employee_id)
                                ->where('clearance_request_id', $request_id)
                                ->where('status', 7)
                                ->where('active', 1)
                                ->get()->count();

        $currentTime = Carbon::now();
        $date_completed =  $currentTime->toDateTimeString();


        if($count_signatories == $check_cleared)
        {
            clearance_request::where('id', $request_id)->update([

                'completed'         => 1,
                'date_completed'    => $date_completed,

            ]);
        }

        return json_encode(array(

            'status' => 200,

        ));
    }



    public function load_clearance_recent_activities(Request $request)
    {
        $logged_employee = Auth::user()->employee;
        $html_data = '';
        $full_name = '';
        $mi = '';
        $status = '';
        $class = '';
        $icons = url('') . "/dist/images/empty.webp";

        $profile_picture = GLOBAL_PROFILE_GENERATOR();

        if($request->clearance_id)
        {
            $clearance_id = Crypt::decrypt($request->clearance_id);
            $get_via_id = clearance_signatories::has('Clearance_Active')->where('employee_id', $logged_employee)->where('clearance_id', $clearance_id)->orderBy('updated_at', 'DESC')->get();

            if($get_via_id)
            {
                foreach ($get_via_id as $data)
                {
                    $created_at = $data->created_at;
                    $updated_at = $data->updated_at;

                    if($data->status == 7)
                    {
                        $icons = url('') . "/dist/images/checked-01.png";

                    }
                    elseif($data->status == 4)
                    {
                        $icons = url('') . "/dist/images/returned-01.png";
                    }


                    if ($data->Clearing_Officer_Details)
                    {
                        $employee_id    = $data->Clearing_Officer_Details->agencyid;
                        $first_name     = $data->Clearing_Officer_Details->firstname;
                        $middle_name    = $data->Clearing_Officer_Details->mi;
                        $last_name      = $data->Clearing_Officer_Details->lastname;
                        $extension      = $data->Clearing_Officer_Details->extension;


                        if($data->Clearing_Officer_Details->mi)
                        {
                            $my_mid_name        = $data->Clearing_Officer_Details->mi;
                            $my_mid_name_new    = substr($my_mid_name, 0, 1);

                            $mi = $my_mid_name_new.'.';
                        }

                        $full_name = $first_name.' '.$mi.' '.$last_name.' '.$extension;
                    }

                    if($data->Status_Codes)
                    {
                        $status = $data->Status_Codes->name;
                        $class  = $data->Status_Codes->class;
                    }

                    $acted_at = $data->updated_at->diffForHumans();
                    $note = $data->note;

                    if($created_at != $updated_at)
                    {
                        $html_data .=
                            '<div class="intro-x relative flex items-center mb-3">
                                <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Icon" src="'.$icons.'">
                                    </div>
                                </div>

                                <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                                    <div class="flex items-center">
                                        <div class="font-medium">'.$full_name.'</div>
                                        <div class="text-xs text-'.$class.' text-slate-500 ml-auto">'.$status.'</div>
                                    </div>
                                    <div class="text-xs text-slate-500 ml-auto">'.$acted_at.'</div>
                                    <div class="text-slate-500 mt-1">'.$note.'</div>
                                </div>
                            </div>';
                    }
                }
            }

            return json_encode(array(

                'html_data' => $html_data,

            ));
        }
        else
        {
            $recent_activities = clearance_signatories::has('Clearance_Active')->where('employee_id', $logged_employee)->orderBy('updated_at', 'DESC')->get();

            if($recent_activities)
            {
                foreach ($recent_activities as $data)
                {
                    $signatory_id = $data->id;

                    $created_at = $data->created_at;
                    $updated_at = $data->updated_at;

                    if($data->status == 7)
                    {
                        $icons = url('') . "/dist/images/checked-01.png";

                    }elseif($data->status == 4)
                    {
                        $icons = url('') . "/dist/images/returned-01.png";

                    }elseif($data->status == 17)
                    {
                        $icons = url('') . "/dist/images/warning.png";
                    }


                    if ($data->Clearing_Officer_Details)
                    {
                        $employee_id    = $data->Clearing_Officer_Details->agencyid;
                        $first_name     = $data->Clearing_Officer_Details->firstname;
                        $middle_name    = $data->Clearing_Officer_Details->mi;
                        $last_name      = $data->Clearing_Officer_Details->lastname;
                        $extension      = $data->Clearing_Officer_Details->extension;

                        if ($data->Clearing_Officer_Details->image)
                        {
//                            $profile_picture = url('') . "/uploads/profiles/" . $data->Clearing_Officer_Details->image;
                        }


                        if($data->Clearing_Officer_Details->mi)
                        {
                            $my_mid_name        = $data->Clearing_Officer_Details->mi;
                            $my_mid_name_new    = substr($my_mid_name, 0, 1);

                            $mi = $my_mid_name_new.'.';
                        }

                        $full_name = $first_name.' '.$mi.' '.$last_name.' '.$extension;
                    }

                    if($data->Status_Codes)
                    {
                        $status = $data->Status_Codes->name;
                        $class  = $data->Status_Codes->class;
                    }

                    $acted_at = $data->updated_at->diffForHumans();
                    $note = $data->note;

                    if($created_at != $updated_at)
                    {
                        $html_data .=
                            '<div class="intro-x relative flex items-center mb-3">
                                <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                        <img alt="Icon" src="'.$icons.'">
                                    </div>
                                </div>

                                <div data-fullname  ="'.$full_name.'"
                                     data-status    ="'.$status.'"
                                     data-class     ="'.$class.'"
                                     data-note      ="'.$note.'"
                                     data-signatory-id ="'.$signatory_id.'"
                                     class="box px-5 py-3 ml-4 flex-1 zoom-in box_recent_activity">
                                    <div class="flex items-center">
                                        <div class="font-medium">'.$full_name.'</div>
                                        <div class="text-xs text-'.$class.' text-slate-500 ml-auto">'.$status.'</div>
                                    </div>
                                    <div class="text-xs text-slate-500 ml-auto">'.$acted_at.'</div>
                                    <div class="text-slate-500 mt-1">'.$note.'</div>
                                </div>
                            </div>';
                    }
                }
                return json_encode(array(

                    'html_data' => $html_data,

                ));
            }
            return json_encode(array(

                'html_data' => $html_data,

            ));
        }
    }



    public function admin_update_clearance_status(Request $request)
    {
        $clearance_id = Crypt::decrypt($request->clearance_id);
        $status_value = $request->clearance_status_checkbox;

        clearance::where('id', $clearance_id)->update([

           'active'     => $status_value,
           'updated_by' => Auth::user()->employee,

        ]);

        return json_encode(array(

           'status' => 200,

        ));
    }




    public function resubmit_for_signatory(Request $request)
    {
        clearance_signatories::where('id', $request->signatory_id)->update([
           'status' => 4,
        ]);

        return json_encode(array(
            'status' => 200,
        ));
    }



    public function load_important_notes(Request $request)
    {
        $logged_user = Auth::user()->employee;
        $is_admin = '';
        $html_data = '';

        $get_notes = clearance_notes::where('employee_id', $logged_user)
                                    ->orWhere('created_by', $logged_user)
                                    ->where('dismiss', 1)
                                    ->where('active', 1)
                                    ->get();




        if($get_notes)
        {
            foreach ($get_notes as $notes)
            {
                $date_created = $notes->updated_at->diffForHumans();
                $html_data .=
                    '<div class="p-5">
                        <div class="text-base font-medium truncate">'.$notes->title.'</div>
                        <div class="text-slate-400 mt-1">'.$date_created.'</div>
                        <div class="text-slate-500 text-justify mt-1">'.$notes->desc.'</div>
                        <div class="font-medium flex mt-5">
                            <button type="button" class="btn btn-secondary py-1 px-2">View Notes</button>
                            <button type="button" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto">Dismiss</button>
                        </div>
                    </div>
                    </div>';
            }
        }else
        {
            $html_data =
                '<div class="p-5">
                    <div class="text-base font-medium truncate">Nothing Found!</div>
                </div>';
        }

        return json_encode(array(

            'html_data' => $html_data,
        ));
    }
    public function submit_important_notes(Request $request)
    {
        $tile       = trim($request->mdl_note_title);
        $desc       = trim($request->mdl_important_notes);
        $note_type  = 'clearance_signatory_note';

        if($request->clearance_note_rc)
        {
            $get_rc_employee = doc_user_rc_g::where('type', 'rc')->where('rc_id', $request->clearance_note_rc)->get();
            if($get_rc_employee)
            {
                foreach ($get_rc_employee as $rc)
                {
                    $add_notes = [

                        'title'         => $tile,
                        'desc'          => $desc,
                        'note_type'     => $note_type,
                        'target_type'   => 'rc',
                        'target_id'     => $request->clearance_note_rc,
                        'employee_id'   => $rc->user_id,
                        'created_by'    => Auth::user()->employee,
                        'dismiss'       => 1,
                        'active'        => 1,
                    ];

                    clearance_notes::create($add_notes);
                }
            }
        }

        if($request->clearance_note_employees)
        {
            foreach ($request->clearance_note_employees as $employee)
            {
                $add_notes = [

                    'title'         => $tile,
                    'desc'          => $desc,
                    'note_type'     => $note_type,
                    'target_type'   => 'employee',
                    'target_id'     => $employee,
                    'employee_id'   => $employee,
                    'created_by'    => Auth::user()->employee,
                    'dismiss'       => 1,
                    'active'        => 1,
                ];

                clearance_notes::create($add_notes);
            }
        }

        return json_encode(array(

            'status' => 200,

        ));
    }



    public function dismiss_notes(Request $request)
    {
        clearance_notes::where('id', $request->note_id)->update([
            'dismiss' => 0,
        ]);

        return json_encode(array(

            'status' => 200,

        ));
    }




    public function count_clearance_request(Request $request)
    {
        $clearance_request = clearance_request::has('Clearance_Active')->where('status', 1)->where('active', 1)->get();

        if($clearance_request)
        {
            $count = $clearance_request->count();

            return json_encode(array(

                'status' => 200,
                'count' => $count,

            ));
        }else
        {
            return json_encode(array(

                'status' => 500,

            ));
        }
    }
    public function count_clearance_completed(Request $request)
    {
        $clearance_request = clearance_request::has('Clearance_Active')->where('completed', 1)->where('active', 1)->get();

        if($clearance_request)
        {
            $count = $clearance_request->count();

            return json_encode(array(

                'status' => 200,
                'count' => $count,

            ));
        }else
        {
            return json_encode(array(

                'status' => 500,

            ));
        }
    }







    public function print_semestral_clearance($clearance_id)
    {
        $clearance_id = Crypt::decrypt($clearance_id);
        $filename = 'Semestral Clearance';

        $sem_clearance = clearance::where('id', $clearance_id)->first();

        $now = date('m/d/Y g:ia');

        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');

        $clearance = clearance_semestral::with('get_User_Details')->where('clearance_id', $clearance_id)->get();

        $signatories = global_signatories::where('type_id', $clearance_id)->where('type', 'Semestral_Clearance')->where('active', 1)->get();

        if(system_settings())
        {
            $system_image_header = system_settings()->where('key','image_header')->first();
            $system_image_footer = system_settings()->where('key','image_footer')->first();
            $system_agency_name = system_settings()->where('key','agency_name')->first();

        }else
        {
            $system_image_header = '';
            $system_image_footer = '';
            $system_agency = '';
        }

        $pdf = PDF::loadView('clearanceSignatories.Print.semestral_clearance',
            compact('sem_clearance',
                'system_image_header',
                'system_image_footer',
                'system_agency_name',
                'filename',
                'current_date',
                'clearance',
                'signatories',

            ))->setPaper('A4', 'portrait');

        return $pdf->stream($filename . '.pdf');
    }






    public function print_CSC_clearance($clearance_id)
    {
        $clearance_id = Crypt::decrypt($clearance_id);

        $counter = 1; //List Number
        $alphabet = range('a', 'z'); //Sub-List Number

        $officer_name = '';
        $csc_iii_cleared_not_cleared = '';
        $csc_iii_signature = '';

        $csc_iv_cleared_not_cleared = '';
        $csc_iv_signature = '';
        $agency_head_signature = '';
        $my_signature = '';

        if(system_settings())
        {
            $system_image_header = system_settings()->where('key','image_header')->first();
            $system_image_footer = system_settings()->where('key','image_footer')->first();
            $system_agency_name = system_settings()->where('key','agency_name')->first();

            $filename = $system_agency_name->value.' Clearance Form';

        }
        else
        {
            $system_image_header = '';
            $system_image_footer = '';
            $system_agency = '';
            $system_agency_name = 'CSC';

            $filename = 'Davao del Sur State College';
        }

        $_query_head = agency_employees::with(['get_user_profile'])->where('designation_id', 1)->orWhere('position_id', 4)->first();

        if($_query_head)
        {
            if($_query_head->get_user_profile)
            {
                $agency_head_firstname  = $_query_head->get_user_profile->firstname;
                $agency_head_last_name  = $_query_head->get_user_profile->lastname;

                if($_query_head->get_user_profile->mi)
                {
                    $agency_head_mid_name   = $_query_head->get_user_profile->mi;
                    $mid_name = substr($agency_head_mid_name, 0, 1);

                    $mi = $mid_name.'.';

                }else
                {
                    $mi = '';
                }


                $agency_head_full_name = $agency_head_firstname.' '.$mi.' '.$agency_head_last_name;
                $agency_head_signature = 'uploads/e_signature/'.$_query_head->get_user_profile->e_signature;

            }else
            {
                $agency_head_full_name = 'N/A';
                $agency_head_signature = '';
            }
        }
        else
        {
            $agency_head_full_name = 'N/A';
        }

        $_query_rc = doc_user_rc_g::with('getOffice')->where('type', 'rc')->where('user_id', Auth::user()->employee)->first();
        $office_assign = ' Not added to any responsibility center yet';

        if($_query_rc)
        {

            if($_query_rc->getOffice)
            {
                $office_assign = $_query_rc->getOffice->centername;

            }
        }
        else
        {
            $get_clearance_csc_others = clearance_csc_others::with('RC')->where('clearance_id', $clearance_id)->first();

            if($get_clearance_csc_others)
            {
                if($get_clearance_csc_others->RC)
                {
                    $office_assign = $get_clearance_csc_others->RC->centername;
                }
            }


        }

        $_query_my_full_name = tblemployee::where('agencyid', Auth::user()->employee)->first();

        if($_query_my_full_name)
        {
            $first_name = $_query_my_full_name->firstname;
            $mid_name = $_query_my_full_name->mi;
            $last_name = $_query_my_full_name->lastname;

            if($_query_my_full_name->mi)
            {
                $my_mid_name   = $_query_my_full_name->mi;
                $my_mid_name_new = substr($mid_name, 0, 1);

                $mi = $my_mid_name_new.'.';

            }else
            {
                $mi = '';
            }

            $my_full_name = $first_name.' '.$mi.' '.$last_name;

            if($_query_my_full_name->e_signature)
            {
                $my_signature = 'uploads/e_signature/'.$_query_my_full_name->e_signature;
            }

        }
        else
        {
            $my_full_name = '';
            $my_signature = '';
        }


        $get_clearance_csc_others = clearance_csc_others::with(['getProfile' ,'get_SG', 'get_Step', 'get_Immediate_Head'])->where('clearance_id', $clearance_id)->first();

        //GET CSC III DATA
        $_query_csc_iii_data = clearance_csc_iii::with(['getProfile', 'Signatories'])->where('clearance_id', $clearance_id)->where('active', 1)->get();

        $grouped_csc_iii_data = $_query_csc_iii_data->groupBy(function($item,$key)
        {
            return $item->type;     //Return Office Type

        })->sortBy(function($item,$key){

            //sorts A-Z at the top level
                return $key;

            });

        $III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES = '';
        $IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES = '';
        $IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES_TITLE = '';


        foreach ($grouped_csc_iii_data as $key => $tr_data)
        {
            $count = $counter++;

            $III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES .=
                    '<tr class="column-color">
                        <td width="26px" class="border-left-bold border-top border-bottom">
                            <div class="text-left px-1"><label class="arial font-normal text-11px">'.$count.'.'.'</label></div>
                        </td>
                        <td colspan="5" class="border-right-bold border-top border-bottom">
                            <div class="text-left px-1"><label class="arial font-normal text-11px text-italic">'.$key.'</label></div>
                        </td>
                    </tr>';

            foreach($tr_data as $index => $table_row)
            {
                if($table_row->getProfile)
                {
                    $officer_name = $table_row->getProfile->firstname.' '.substr($table_row->getProfile->mi, 0, 1).'. '. $table_row->getProfile->lastname;
                }

                if($table_row->Signatories)
                {
                    if($table_row->Signatories->cleared == 1)
                    {
                        $csc_iii_cleared_not_cleared =
                            '<td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox" checked > <label class="ml-1"></labe>
                                    </div>
                                </td>
                                <td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox"> <label class="ml-1"></labe>
                                    </div>
                                </td>';

                    }
                    elseif ($table_row->Signatories->cleared == 0)
                    {
                        $csc_iii_cleared_not_cleared =
                            '<td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox"> <label class="ml-1"></labe>
                                    </div>
                                </td>
                                <td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                       <input type="checkbox" checked > <label class="ml-1"></labe>
                                    </div>
                                </td>';
                    }elseif ($table_row->Signatories->cleared == null)
                    {
                        $csc_iii_cleared_not_cleared =
                            '<td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <label></label>
                                    </div>
                                </td>
                                <td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                       <label></label>
                                    </div>
                                </td>';
                    }

                    if($table_row->Signatories->signature == 1)
                    {
                        if($table_row->getProfile->e_signature)
                        {
                            $csc_iii_signature =
                                '<td width="10%" height="50px" class="border-bottom border-right-bold">
                                    <div style="padding: 5px;">
                                        <img src="uploads/e_signature/'.$table_row->getProfile->e_signature.'" style="width: 80px; height: 40px">
                                   </div>
                                </td>';
                        }else
                        {
                            $csc_iii_signature =
                                '<td width="10%" height="50px" class="border-bottom border-right-bold">
                                   <div style="width: 80px;" class="text-center px-1 arial font-normal text-11px mt-1">
                                     <label>No E-Signature Uploaded!</label>
                                </div>
                                </td>';
                        }

                    }
                    else
                    {
                        $csc_iii_signature =
                            '<td width="10%" height="50px" class="border-bottom border-right-bold">
                               <div style="width: 80px;" class="text-center px-1 arial font-normal text-11px mt-1">
                                    <label></label>
                               </div>
                            </td>';
                    }
                }
                else
                {
                    $csc_iii_cleared_not_cleared =
                        '<td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox"> <label class="ml-1"></labe>
                                    </div>
                                </td>
                                <td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox"> <label class="ml-1"></labe>
                                    </div>
                                </td>';

                    $csc_iii_signature =
                        '<td width="10%" height="50px" class="border-bottom border-right-bold">
                                <div style="width: 80px;" class="text-center px-1 arial font-normal text-11px mt-1">
                                    <label></label>
                               </div>
                            </td>';
                }

                $table_number = $alphabet[$index];

                $III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES .=
                    '<tr>
                        <td width="5%" height="50px" class="border-bottom border-left-bold">
                            <div class="text-right px-1"><label class="arial font-normal text-11px-new">'.$table_number.'.'.'</label></div>
                        </td>

                        <td width="35%" height="50px" class="border-bottom border-right">
                            <div class="text-left px-1"><label class="arial font-normal text-11px-new">'.$table_row->unit_office_dept_name.'</label></div>
                        </td>
                        '.$csc_iii_cleared_not_cleared.'
                        <td width="30%" height="50px" class="border-bottom border-right">
                            <div class="text-center px-1 arial font-bold text-11px-new mt-1">
                                <label>'.$officer_name.'</label>
                            </div>
                        </td>
                        '.$csc_iii_signature.'
                    </tr>';
            }
        }




        //GET CSC IV DATA
        $_query_csc_iv_data = clearance_csc_iv::with(['getProfile', 'Signatories'])->where('clearance_id', $clearance_id)->get();
        $grouped_csc_iv_data = $_query_csc_iv_data->groupBy(function($item,$key)
        {
            return $item->type;     //Return Office Type

        })->sortBy(function($item,$key){

            return $key;

        });

        $iv_counter = 1;

        foreach ($grouped_csc_iv_data as $key => $tr_data)
        {

            $iv_count = $iv_counter++;

            if($key == 'N/A' || $key == null || $key == '')
            {
                $IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES =
                    '<tr>
                        <td width="26px" class="border-left-bold border-right border-bottom border-top">
                            <div class="text-left px-1"><label class="arial font-bold text-11px">IV</label></div>
                        </td>
                        <td colspan="5" class="border-right-bold border-bottom border-top">
                            <div class="text-left px-1"><label class="arial font-bold text-11px">CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE:</label></div>
                        </td>
                    </tr>';


            }
            else
            {
                $IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES_TITLE =
                    '<tr>
                        <td width="26px" class="border-left-bold border-right border-bottom border-top">
                            <div class="text-left px-1"><label class="arial font-bold text-11px">IV</label></div>
                        </td>
                        <td colspan="5" class="border-right-bold border-bottom border-top">
                            <div class="text-left px-1"><label class="arial font-bold text-11px">CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE:</label></div>
                        </td>
                    </tr>';

                $IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES .=
                    '<tr class="column-color">
                        <td width="26px" class="border-left-bold border-top border-bottom">
                            <div class="text-left px-1"><label class="arial font-normal text-11px">'.$iv_count.'.'.'</label></div>
                        </td>
                        <td colspan="5" class="border-right-bold border-top border-bottom">
                            <div class="text-left px-1"><label class="arial font-normal text-11px text-italic">'.$key.'</label></div>
                        </td>
                    </tr>';
            }


            foreach($tr_data as $index => $table_row)
            {
                if($table_row->getProfile)
                {
                    $officer_name = $table_row->getProfile->firstname.' '.substr($table_row->getProfile->mi, 0, 1).'. '. $table_row->getProfile->lastname;
                }
                else
                {
                    $officer_name = 'N/A';
                }

                if($table_row->Signatories)
                {
                    if($table_row->Signatories->cleared == 1)
                    {
                        $csc_iv_cleared_not_cleared =
                            '<td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox" checked > <label class="ml-1"></labe>
                                    </div>
                                </td>
                                <td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox"> <label class="ml-1"></labe>
                                    </div>
                                </td>';

                    }
                    elseif ($table_row->Signatories->cleared == 0 || $table_row->Signatories->cleared == null)
                    {
                        $csc_iv_cleared_not_cleared =
                            '<td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox"> <label class="ml-1"></labe>
                                    </div>
                                </td>
                                <td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                       <input type="checkbox" checked > <label class="ml-1"></labe>
                                    </div>
                                </td>';
                    }

                    if($table_row->Signatories->signature == 1)
                    {
                        if($table_row->getProfile->e_signature)
                        {
                            $csc_iv_signature =
                                '<td width="11%" height="50px" class="border-bottom border-right-bold">
                                    <div style="padding: 5px;">
                                        <img src="uploads/e_signature/'.$table_row->getProfile->e_signature.'" style="width: 80px; height: 40px">
                                   </div>
                                </td>';
                        }else
                        {
                            $csc_iv_signature =
                                '<td width="15%" height="50px" class="border-bottom border-right-bold">
                                <div style="width: 80px;" class="text-center px-1 arial font-normal text-11px mt-1">
                                     <label>No E-Signature Uploaded!</label>
                                </div>
                            </td>';
                        }
                    }else
                    {
                        $csc_iv_signature =
                            '<td width="15%" height="50px" class="border-bottom border-right-bold">
                                <div style="width: 80px;" class="text-center px-1 arial font-normal text-11px mt-1">
                                     <label></label>
                                </div>
                            </td>';
                    }
                }
                else
                {
                    $csc_iv_cleared_not_cleared =
                        '<td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox" checked> <label class="ml-1"></labe>
                                    </div>
                                </td>
                                <td width="10%" height="50px" class="border-bottom border-right">
                                    <div class="text-center px-1 arial font-normal text-11px mt-1">
                                        <input type="checkbox"> <label class="ml-1"></labe>
                                    </div>
                                </td>';

                    $csc_iv_signature =
                        '<td width="15%" height="50px" class="border-bottom border-right-bold">
                                <div style="width: 80px;" class="text-center px-1 arial font-normal text-11px mt-1">
                                    <label></label>
                                </div>
                            </td>';
                }

                $table_number = $alphabet[$index];

                $IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES .=
                    '<tr>
                        <td width="5%" height="50px" class="border-bottom border-left-bold">
                            <div class="text-right px-1"><label class="arial font-normal text-11px-new">'.$table_number.'.'.'</label></div>
                        </td>

                        <td width="35%" height="50px" class="border-bottom border-right">
                            <div class="text-left px-1"><label class="arial font-normal text-11px-new">'.$table_row->unit_office_dept_name.'</label></div>
                        </td>
                            '.$csc_iv_cleared_not_cleared.'
                        <td width="25%" height="50px" class="border-bottom border-right">
                             <div class="text-center px-1 arial font-bold text-11px-new mt-1">
                                <label>'.$officer_name.'</label>
                            </div>
                        </td>
                        '.$csc_iv_signature.'
                    </tr>';
            }
        }


        $filing_date = date("F j, Y, g:i a");


        $pdf = PDF::loadView('clearanceSignatories.Print.csc_clearance',
            compact('system_image_header',
                'system_image_footer',
                'system_agency_name',
                'filename',
                'agency_head_full_name',
                'agency_head_signature',
                'filing_date',
                'office_assign',
                'my_full_name',
                'my_signature',
                '_query_csc_iii_data',
                '_query_csc_iv_data',
                'get_clearance_csc_others',
                'grouped_csc_iii_data',
                'III_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES',
                'IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES',
                'IV_CLEARANCE_FROM_MONEY_AND_PROPERTY_ACCOUNTABILITIES_TITLE',

            ))->setPaper('A4', 'portrait');


        return $pdf->stream($filename . '.pdf');
    }




    public function print_cleared_clearance_report($clearance_id)
    {
        if(system_settings())
        {
            $system_image_header = system_settings()->where('key','image_header')->first();
            $system_image_footer = system_settings()->where('key','image_footer')->first();
            $system_agency_name = system_settings()->where('key','agency_name')->first();

            $filename = $system_agency_name->value.' Clearance Form';

        }
        else
        {
            $system_image_header = '';
            $system_image_footer = '';
            $system_agency = '';
            $system_agency_name = 'CSC';

            $filename = 'Davao del Sur State College';
        }


        $now = date('m/d/Y g:ia');

        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');


        $get_clearance = clearance::where('id', $clearance_id)->where('active', 1)->first();

        if($get_clearance)
        {
            $clearance_title = $get_clearance->name;

            $date = Carbon::parse($get_clearance->created_at, 'UTC');
            $date_published = $date->isoFormat('MMMM DD YYYY, h:mm:ss A');

        }
        else
        {
            $clearance_title = 'N/A';
            $date_published = 'N/A';
        }


        $cleared_list_table_body = '';
        $employee_name = '';
        $responsibility_center = 'N/A';
        $position_designation = 'N/A';


        $Clearance_completed_employee = clearance_request::has('Active_Clearance')
            ->with(['Employee_Details'])
            ->where('clearance_id', $clearance_id)
            ->where('active', 1)
            ->where('completed', 1)
            ->orderBy('created_at', 'DESC')->get();

        foreach ($Clearance_completed_employee as $index => $data)
        {
            if($data->completed == 1)   //  1 is for Completed True
            {

                if($data->Employee_Details)
                {
                    $first_name = $data->Employee_Details->firstname;
                    $last_name = $data->Employee_Details->lastname;

                    if($data->Employee_Details->mi)
                    {
                        $my_mid_name   = $data->Employee_Details->mi;
                        $my_mid_name_new = substr($my_mid_name, 0, 1);

                        $mi = $my_mid_name_new.'.';

                    }else
                    {
                        $mi = '';
                    }

                    $employee_name = $first_name.' '.$mi.' '.$last_name;
                }

                if ($data->Responsibility_Center)
                {
                    if($data->Responsibility_Center->getOffice)
                    {
                        $responsibility_center = $data->Responsibility_Center->getOffice->centername;
                    }else
                    {
                        $responsibility_center = 'N/A';
                    }

                }

                if ($data->Agency_Employee)
                {
                    if($data->Agency_Employee->getPosition)
                    {
                        $position = $data->Agency_Employee->getPosition->emp_position;
                    }else
                    {
                        $position = 'N/A';
                    }

                    if($data->Agency_Employee->getDesig)
                    {
                        $designation = $data->Agency_Employee->getDesig->userauthority;
                    }
                    else
                    {
                        $designation = 'N/A';
                    }

                    $position_designation = $position .' - '.$designation;

                }

                $date = Carbon::parse($data->date_completed, 'UTC');
                $date_completed = $date->isoFormat('MMMM DD YYYY, h:mm:ss A');

                $td = [

                    "employee_name" => $employee_name,
                    "responsibility_center" => $responsibility_center,
                    "position_designation" => $position_designation,
                    "date_completed" => $date_completed,

                ];

                $list_number = $index+1;

                $cleared_list_table_body .=
                    '<tr>
                        <td width="5%" height="30px" class="border-right border-top border-bottom">
                            <div class="text-center py-1 "><label class="arial font-normal text-11px">'.$list_number.'</label></div>
                        </td>

                        <td width="35%" height="30px" class=" border-right border-top border-bottom">
                            <div class="text-left px-1 py-1"><label class="arial font-normal text-11px-new">'.$employee_name.'</label></div>
                        </td>
                        <td width="20%" height="30px" class=" border-right border-top border-bottom">
                            <div class="text-center px-1 py-1 arial font-normal text-11px-new">
                                <label>'.$position_designation.'</label>
                            </div>
                        </td>
                        <td width="20%" height="30px" class=" border-right border-top border-bottom">
                            <div class="text-center px-1 py-1 arial font-normal text-11px-new">
                                <label>'.$responsibility_center.'</label>
                            </div>
                        </td>
                        <td width="20%" height="30px" class=" border-top border-bottom">
                            <div class="text-left px-1 py-1 arial font-normal text-11px">
                                <label>'.$date_completed.'</label>
                            </div>
                        </td>
                    </tr>';
            }

        }

        $pdf = PDF::loadView('clearanceSignatories.Print.cleared_clearance_report',
            compact('system_image_header',
                  'system_image_footer',
                            'system_agency_name',
                            'filename',
                            'current_date',
                            'clearance_title',
                            'date_published',
                            'cleared_list_table_body',
                    ))->setPaper('A4', 'portrait');


        return $pdf->stream($filename . '.pdf');
    }
}
