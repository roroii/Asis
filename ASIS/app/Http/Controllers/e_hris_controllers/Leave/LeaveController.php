<?php
namespace App\Http\Controllers\Leave;
use App\Models\tblposition;
use App\Models\tblemployee;
use App\Models\tbluserassignment;
use App\Models\Leave\leave_type;
use App\Models\Leave\employee_leave_available;
use App\Models\Leave\leave_tardiness_deduction;
use App\Models\Leave\employee_hr_details;
use App\Models\Leave\agency_employees;
use App\Models\Leave\leave_submitted;
use App\Models\Leave\leave_category;
use App\Models\Leave\leave_approved;
use App\Models\applicant\applicants_tempfiles;
use App\Models\Leave\leave_employee_attachments;
use App\Models\Leave\leave_recommendation;
use App\Models\Leave\leave_president_approval;
use App\Models\User;
use App\Models\document\doc_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Hash;
use DB;
use Session;
use Carbon\Carbon;
use PDF;
use Dompdf\Dompdf;
use Response;
use Hashids\Hashids;

class LeaveController extends Controller
{

//Start Leave dashboard
public function index(){
    $load_employee_hr_details = tblemployee::all();
    $tblemployee_count = tblemployee::count();
    $load_leave_type = leave_type::all();
    $leave_category = leave_category::all();

    $leave_submitted_count_approved =leave_submitted::join('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                                ->select(['leave_submitted.*','leave_type.typename','leave_submitted.status','leave_submitted.appliedno','leave_submitted.entrydate','leave_submitted.status'])
                                ->OrderBy('entrydate', 'desc')
                                ->get()->where('status', '=', 'Approved')->count();


    $leave_submitted_count_Pending =leave_submitted::join('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                                ->select(['leave_submitted.*','leave_type.typename','leave_submitted.status','leave_submitted.appliedno','leave_submitted.entrydate','leave_submitted.status'])
                                ->OrderBy('entrydate', 'desc')
                                ->get()->where('status', '=', '')->count();

    $leave_submitted_count_disapproved =leave_submitted::join('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                                ->select(['leave_submitted.*','leave_type.typename','leave_submitted.status','leave_submitted.appliedno','leave_submitted.entrydate','leave_submitted.status'])
                                ->OrderBy('entrydate', 'desc')
                                ->get()->where('status', '=', 'Disapproved')->count();

    $load_employee_available_leave = employee_leave_available::join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                                ->select('typename')
                                ->groupBy('typename')
                                ->orderBy('typename', 'asc')
                                ->where('employeeid', Auth::user()->employee)
                                ->get();

    $doc_type = doc_type::all();


    return view('leave.dashboard', compact('tblemployee_count','load_employee_hr_details',
                                         'load_leave_type', 'leave_category',
                                         'load_employee_available_leave',
                                         'leave_submitted_count_approved','doc_type',
                                         'leave_submitted_count_Pending','leave_submitted_count_disapproved'));

}
//End Leave dashboard

// My Leave Dashboard
public function my_leave(){

    $special_priviledge_leave = "0.00";
    $force_leave = "0.00";
    $vacation = "0.00";
    $sick="0.00";
    $load_employee_hr_details = tblemployee::all();
    $doc_type = doc_type::all();

    $agency_employees = agency_employees::with('get_designation')
        ->where('agency_id',  Auth::user()->employee)
        ->get();


    $load_employee_available_leave =DB::table('employee_leave_available')
        ->join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
        ->select('leave_type.id', 'leave_type.typename','employee_leave_available.leave_type_id', DB::raw('COUNT(*) AS total'))
        ->where('employeeid', Auth::user()->employee)
        ->groupBy('leave_type_id')
        ->orderBy('leave_type_id', 'asc')
        ->get();


    $load_employee_available_leave_with_sum = employee_leave_available::with('get_leave_type')
        ->where('employeeid', Auth::user()->employee)
        ->selectRaw('leave_type_id,sum(no_of_leaves) as no_of_leaves_sum')
        ->groupBy('leave_type_id')
        ->get();


    $get_user_information_to_leave_ledger = agency_employees::join('profile', 'profile.agencyid', '=', 'agency_employees.agency_id')
                                                            ->leftjoin('tblposition', 'tblposition.id', '=', 'agency_employees.position_id')
                                                            ->select('agency_employees.*','profile.firstname', 'profile.mi', 'profile.lastname','profile.extension',
                                                            'tblposition.emp_position', 'agency_employees.start_date')
                                                            ->where('agency_employees.agency_id', Auth::user()->employee)
                                                            ->get();

    foreach($get_user_information_to_leave_ledger as $getName){

        $firstname =  $getName->firstname;
        $mi = mb_substr($getName->mi, 0, 1). '.';
        $lastname = $getName-> lastname;
        $extension = $getName-> extension;
        $position = $getName->emp_position;
        $start_date = $getName->start_date;

        $my_fullname =  $firstname .' '. $mi .' '. $lastname .' '. $extension;

    }


    foreach ($load_employee_available_leave_with_sum as $get_total) {

        if ($get_total->leave_type_id == 5){

                $sick = $get_total->no_of_leaves_sum;

            }elseif($get_total->leave_type_id == 4){

                    $vacation = $get_total->no_of_leaves_sum;

            }elseif($get_total->leave_type_id == 2){

                $force_leave = $get_total->no_of_leaves_sum;

            }elseif($get_total->leave_type_id == 3){

                $special_priviledge_leave = $get_total->no_of_leaves_sum;
            }

        }

    $load_leave_submitted_sum = leave_approved::with('get_leave_type_val')
            ->where('employeeid', Auth::user()->employee)
            ->selectRaw('leavesubmittedid,sum(no_of_leaves) as no_of_leaves_submitted')
            ->groupBy('leavesubmittedid')
            ->get();

    $sick_submitted=0;
    $vacation_submitted=0;
    $force_leave_submitted=0;
    $special_priviledge_leavesubmitted=0;

    foreach ($load_leave_submitted_sum as $getV) {

    if ($getV->leavesubmittedid == 5){

                $sick_submitted = $getV->no_of_leaves_submitted;

        }elseif($getV->leavesubmittedid == 4){

                    $vacation_submitted = $getV->no_of_leaves_submitted;

        }elseif($getV->leavesubmittedid == 2){

                $force_leave_submitted = $getV->no_of_leaves_submitted;

        }elseif($getV->leavesubmittedid == 3){

                $special_priviledge_leavesubmitted = $getV->no_of_leaves_submitted;

        }

    }

        $_sickbalance = ( $sick - $sick_submitted);
        $_vacation_balance = ($vacation - $vacation_submitted );
        $_force_leave_balance = ( $force_leave - $force_leave_submitted);
        $special_priviledge_balance = ($special_priviledge_leave - $special_priviledge_leavesubmitted );


    $number_leave_balance ="";
    $leave_approved=leave_submitted::join('leave_type','leave_type.id','=','leave_submitted.type')
                                    ->where('employeeid', Auth::user()->employee)->get();

    $emp_ledger_available_leave = employee_leave_available::join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                                                        ->leftjoin('leave_submitted','leave_submitted.type', '=', 'employee_leave_available.leave_type_id')
                                                        ->orderBy('ledger_col_order', 'asc')
                                                        ->where('employee_leave_available.employeeid', Auth::user()->employee)
                                                        ->get()->unique('id');


    // $count_leave_available = employee_leave_available::join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
    //                         ->groupBy('leave_type_id')
    //                         ->orderBy('ledger_col_order', 'asc')
    //                         ->selectRaw('leave_type_id,sum(no_of_leaves) as total_balance')
    //                         ->where('employeeid', Auth::user()->employee)
    //                         ->get();

    $count_leave_available = employee_leave_available::join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                            ->select('leave_type_id', DB::raw('sum(no_of_leaves) as total_balance', ' entrydate'))
                            ->where('employeeid', Auth::user()->employee, true)
                            ->groupBy('leave_type_id')
                            ->orderBy('ledger_col_order', 'asc')
                            ->get();



    $emp_available_leave_data= employee_leave_available::join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                            ->select('leave_type_id','no_of_leaves')
                            ->where('employeeid', Auth::user()->employee, true)
                            ->orderBy('ledger_col_order', 'asc')
                            ->get();



    return view('leave.myleave', compact('load_employee_hr_details','load_employee_available_leave','agency_employees',
                                    '_sickbalance','_vacation_balance','_force_leave_balance','special_priviledge_balance','doc_type',
                                    'my_fullname','position','start_date','emp_ledger_available_leave','count_leave_available','emp_available_leave_data'));
}
// End My Leave Dashboard

//Start  load leave type function
public function load_leave_type(Request $request){

    $data = $request->all();

    $get_leave_type = [];

    $load_leave_type = leave_type::all();


    foreach ($load_leave_type as $dt) {

        $td = [

            "id" => $dt->id,
            "typename" => $dt->typename,
            "category" => $dt->category,
            "qualifygender" => $dt->qualifygender,
            "numberofleaves" => $dt->numberofleaves,
            "long_name" => $dt->long_name,
            "leave_cat" => $dt ->leave_cat,
            "ledger_col_order" => $dt->ledger_col_order,
        ];

        $get_leave_type[count($get_leave_type)] = $td;


    }

    echo json_encode($get_leave_type);


}
//End load leave type function

//Start store leave type function
public function store_leave_type(Request $request){

    $data = $request->all();

    $add_leave_type = [

        'username' => $request->username,
        'typename' => $request->typename,
        'category' => $request ->category,
        'qualifygender'=> $request->qualifygender,
        'numberofleaves' => $request->numberofleaves,
        'active' => 1,
        'leave_cat' => $request->leave_cat,
        'long_name' => $request ->long_name,
        'ledger_col_order' => $request->ledger_col_order,


    ];

    leave_type::create($add_leave_type);
    __notification_set(1,'Success','Leave Type Successfuly Added!');

    return json_encode(array(
        "data"=>$data,
    ));

}
//End store leave type function

//Start edit leave type function
public function edit_leave_type($id){

    $data = leave_type::find($id);

    return response()->json($data);


}
//End edit leave type function

//Start update leave type function
public function update_leave_type(Request $request, $id){

    $data = $request->all();

    $leave_type=leave_type::find($id);
    $leave_type->username=$request->input('edit_username');
    $leave_type->typename=$request->input('edi_typename');
    $leave_type->category=$request->input('edit_category');
    $leave_type->qualifygender=$request->input('edit_qualifygender');
    $leave_type->numberofleaves=$request->input('edit_numberofleaves');
    $leave_type->leave_cat=$request->input('edit_leave_cat');
    $leave_type->long_name=$request->input('edit_long_name');
    $leave_type->ledger_col_order=$request->input('edit_ledger_col_order');


    $leave_type->save();

    __notification_set(1,'Success','Leave Type Successfuly Updated!');

    return redirect()->back();

}
//end update leave type function

//Start delete leave type function
public function delete_leave_type(Request $request, $id){

    $data = $request->all();

    $delete_leave_type = leave_type::findOrFail($request->id);

    $delete_leave_type->delete();


    return response()->json([
        'error' => false,
        'data'  => $delete_leave_type->id,

    ], 200);

}
//End delete leave type function

//start load employee leave details
public function load_employee_leave_details(Request $request){

    $data = $request->all();

    $get_leave_type_details = [];

     $load_employee_hr_details = agency_employees::join('profile','profile.agencyid', '=', 'agency_employees.agency_id')
                                ->leftjoin('employee_leave_available', 'employee_leave_available.employeeid', '=' , 'agency_employees.agency_id')
                                ->leftjoin('tblposition','tblposition.id', '=', 'agency_employees.position_id')
                                ->leftjoin('tbluserassignment','tbluserassignment.id', '=', 'agency_employees.designation_id')
                                ->leftjoin('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                                ->select('agency_employees.*','profile.agencyid','profile.firstname','profile.lastname','profile.mi',
                                'profile.extension','profile.sex','tblposition.emp_position','tbluserassignment.userauthority','leave_type.typename')
                                ->orderBy('lastname', 'desc')
                                ->get()->where('active', 1)->unique('id');




    foreach ($load_employee_hr_details  as $index => $dt ) {

        $designation="N/A";
        $typename="N/A";
        $position = "N/A";
        $typename="N/A";

        if($dt->userauthority)
        {
            $designation = $dt->userauthority;

        }else if($dt->emp_position)
        {
            $position = $dt->emp_position;

        }

        if ($dt->typename)
        {
            $typename = $dt->typename;
        }

        $td = [
            "id" => $dt ->id,
            "agencyid" => $dt->agencyid,
            "firstname" =>$dt ->firstname,
            "mi" => mb_substr($dt->mi, 0, 1). '.',
            "lastname" => $dt->lastname,
            "extension"=> $dt->extension,
            "sex" => $dt->sex,
            "typename"=>  $typename ,
            "emp_position" => $position,
            "userauthority"=> $designation,
            "active"=>$dt->active,


        ];


        $get_leave_type_details[count($get_leave_type_details)] = $td;

    }

    echo json_encode($get_leave_type_details);


}
//End load employee leave details

//start delete leave employee details
public function delete_leave_employee_details(Request $request, $agency_id){

    $data = $request->all();

    $delete_employee_details = agency_employees::findOrFail($request->agency_id)->with(
                'get_employee_profile', 'get_position','get_designation',
                'get_employment_status');

    $delete_employee_details->delete();


    return response()->json([
        'error' => false,
        'data'  => $delete_employee_details->agency_id,

    ], 200);

}
//End delete leave employee details

//Start load applied leave submitted
public function load_applied_leave_submitted(Request $request){

    $data = $request->all();

    $get_submitted_leave_application = [];

  $load_applied_leave_submitted =leave_recommendation::join('profile', 'profile.agencyid', '=', 'leave_recommendation.employeeid')
                                ->leftjoin('leave_submitted', 'leave_submitted.employeeid', '=', 'leave_recommendation.employeeid')
                                ->leftjoin('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                                ->select(['leave_submitted.*','profile.firstname','profile.lastname','profile.mi','profile.extension',
                                'leave_type.typename','leave_submitted.appliedno','leave_submitted.entrydate','leave_recommendation.status'])
                                ->get()->where('supervisor_id',  Auth::User()->employee )->where('active', 1);

    foreach ($load_applied_leave_submitted  as $index => $dt ) {


        $swhere= "N/A";
        $status="Pending";

        if ($dt->swhere)
        {
            $swhere = $dt->swhere;
        }

        if ($dt->status)
        {
            $status = $dt->status;
        }
        $td = [
            "id" => $dt -> id,
            "firstname" =>$dt ->firstname,
            "mi" => mb_substr($dt->mi, 0, 1). '.',
            "lastname" => $dt->lastname,
            "extension"=> $dt->extension,
            "typename"=> $dt->typename,
            "swhere" => $swhere,
            "appliedno" =>$dt->appliedno,
            "entrydate" => $dt->entrydate,
            "status" => $status,



        ];

        $get_submitted_leave_application[count($get_submitted_leave_application)] = $td;

    }

    echo json_encode($get_submitted_leave_application);


}
//End load applied leave submitted

//Start HR for Approval
public function hr_for_approval(Request $request){

    $data = $request->all();
    $get_for_approval_leave_submitted = [];


     $load_hr_for_approval_leave_submitted =leave_submitted::join('profile', 'profile.agencyid', '=', 'leave_submitted.employeeid')
                                ->leftjoin('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                                ->leftjoin('leave_employee_attachments','leave_employee_attachments.leavesubmittedid','=','leave_submitted.id')
                                ->select(['leave_submitted.*','profile.firstname','profile.lastname','profile.mi','profile.extension',
                                'leave_type.typename','leave_submitted.appliedno','leave_submitted.entrydate','leave_submitted.status',
                                'leave_employee_attachments.attachment_type','leave_employee_attachments.path','leave_employee_attachments.filename'])
                                ->OrderBy('entrydate', 'desc')
                                ->get()->where('active', 1);

    foreach ($load_hr_for_approval_leave_submitted  as $index => $dt ) {


        $swhere= "N/A";
        $status="Pending";
        $attachment_type="No Attachment";

        if ($dt->swhere)
        {
            $swhere = $dt->swhere;
        }

        if ($dt->status)
        {
            $status = $dt->status;
        }

        if ($dt->attachment_type)
        {
            $attachment_type = $dt->attachment_type;
        }

        $td = [
            "id" => $dt ->id,
            "firstname" =>$dt ->firstname,
            "mi" => mb_substr($dt->mi, 0, 1). '.',
            "lastname" => $dt->lastname,
            "extension"=> $dt->extension,
            "typename"=> $dt->typename,
            "swhere" => $swhere,
            "appliedno" =>$dt->appliedno,
            "entrydate" => \Carbon\Carbon::parse($dt->entrydate)->format('m/d/Y'),
            "attachment_type" => $attachment_type,
            "status" => $status,
            "filename"=> $dt->filename,
            "path"=> $dt->path,


        ];

        $get_for_approval_leave_submitted[count($get_for_approval_leave_submitted)] = $td;

    }

    echo json_encode($get_for_approval_leave_submitted);



}
//End HR for Approval


//start download attachement documents
public function download_attachment_documents(Request $request){

    $get_id = $request->input('at_id');

    $leave_submitted_documents = leave_submitted::join('leave_employee_attachments','leave_employee_attachments.leavesubmittedid', '=', 'leave_submitted.id')
                                                ->select('leave_submitted.*','leave_employee_attachments.path', 'leave_employee_attachments.filename')
                                                ->where('leavesubmittedid', $request->id)
                                                ->get();

    foreach( $leave_submitted_documents as $file){

        $path = $file->path;
        $filename = $file->filename;
    }

    $storage = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();


    $pathfile = $storage . "public/leave/" .  $path . "/" .   $filename ;


    if (file_exists($pathfile)) {

      return response()->download($pathfile);

    } else {

        echo('File not found.');

    }


}
//end download attachement documents

//Start Get HR approval Information
public function get_hr_approval_info(Request $request){

    $get_hr_approval_info = leave_submitted::join('profile','profile.agencyid', '=', 'leave_submitted.employeeid')
                            ->select(['leave_submitted.*','profile.agencyid','leave_submitted.id','leave_submitted.type','leave_submitted.status','profile.firstname','profile.lastname','profile.mi','profile.extension'])
                            ->where('leave_submitted.id', $request->id)
                            ->first();

    return response()->json($get_hr_approval_info);

}
//End Get HR approval Information

//Start HR Approval leave submitted
public function hr_approval_leave_submitted(Request $request){
    $data = $request->all();
    $current_userid= Auth::user()->employee;

    $hr_id =  $request->input('leavesubmittedid');


    $id_exist = leave_submitted::where('id', $hr_id );

    if($id_exist){

        $id_exist->update([

            'status' =>$request->status,

        ]);


        $approve_recommendation = [

            'leavesubmittedid' => $request-> leavesubmittedid ,
            'employeeid' => $request->employeeid,
            'active' => 1,

        ];

        leave_recommendation::updateOrCreate($approve_recommendation);


        __notification_set(1,'Success','Success!');


    }else{

        __notification_set(-2,'Error','Contact ICTC !');
    }



        // $leave_president_approval = [

        //     'leavesubmittedid' => $request-> leavesubmittedid ,
        //     'employeeid' => $request->employeeid,
        //     'notedby' => $request->notedby,
        //     'active' => 1,
        // ];

        // leave_president_approval::create($leave_president_approval);

        // __notification_set(1,'Success','Success!');



}
//End HR Approval leave submitted

//Start load president leave for approval
public function load_president_leave_for_approval(Request $request){

        $data = $request->all();

        $get_submitted_leave__for_approval = [];


      $load_president_leave_for_approval = leave_president_approval::join('leave_submitted', 'leave_submitted.id', '=', 'leave_president_approval.leavesubmittedid')
                                        ->leftjoin('profile', 'profile.agencyid', '=', 'leave_president_approval.employeeid')
                                        ->leftjoin('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                                        ->select(['leave_president_approval.*','leave_president_approval.id as lid','profile.firstname','profile.lastname','profile.mi','profile.extension',
                                        'leave_type.typename','leave_submitted.appliedno','leave_submitted.entrydate','leave_president_approval.status'])
                                        ->get()->unique('lid');

        foreach ($load_president_leave_for_approval  as $index => $dt ) {


            $swhere= "N/A";
            $status = "Pending";
            if ($dt->swhere)
            {
                $swhere = $dt->swhere;
            }
            if ($dt->status)
            {
                $status = $dt->status;
            }

            $td = [
                "id" => $dt->id,
                "firstname" =>$dt ->firstname,
                "mi" => mb_substr($dt->mi, 0, 1). '.',
                "lastname" => $dt->lastname,
                "extension"=> $dt->extension,
                "typename"=> $dt->typename,
                "swhere" => $swhere,
                "appliedno" =>$dt->appliedno,
                "entrydate" => $dt->created_at,
                "due_to" => $dt->due_to,
                "status" =>  $status ,



            ];

            $get_submitted_leave__for_approval[count($get_submitted_leave__for_approval)] = $td;

        }

        echo json_encode($get_submitted_leave__for_approval);


}
//End load president leave for approval

//Start Get ID approval for President
public function get_id_approval_for_president(Request $request){

    $load_president_leave_for_approval = leave_president_approval::join('profile','profile.agencyid', '=', 'leave_president_approval.employeeid')
                                        ->leftjoin('leave_submitted', 'leave_submitted.employeeid', '=', 'leave_president_approval.employeeid')
                                        ->select(['leave_president_approval.*','profile.agencyid','leave_president_approval.leavesubmittedid','leave_submitted.type','profile.firstname','profile.lastname','profile.mi','profile.extension'])
                                        ->where('leave_president_approval.id', $request->id)
                                        ->find($request->id);


    return response()->json($load_president_leave_for_approval);

}
//End Get ID approval for President

//Start Update approval for President
public function update_approval_for_president(Request $request){
    $data = $request->all();

    $id =  $request->input('id');


    leave_president_approval::where('id', $id)->update([

        'status' => $request->p_status,
        'due_to' => $request->due_to,
        'notedby' => Auth::user()->employee,

    ]);

        return json_encode(array(
            'update_status' => 200,
        ));

}
//End Update approval for President

//Start my leave submitted
public function my_leave_submitted(Request $request){

    $data = [];

    $current_user_id = Auth::User()->employee;

    $myleave_submitted =leave_submitted::join('profile','profile.agencyid', '=', 'leave_submitted.employeeid')
                        ->leftjoin('leave_type', 'leave_type.id', '=' , 'leave_submitted.type')
                        ->leftjoin('leave_president_approval', 'leave_president_approval.leavesubmittedid', '=', 'leave_submitted.id')
                        ->select(['leave_submitted.*','leave_submitted.id as lid','profile.firstname','profile.lastname','profile.mi','profile.extension',
                        'leave_submitted.swhere','leave_type.typename','leave_submitted.employeeid','leave_submitted.appliedno','leave_submitted.entrydate',
                        'leave_president_approval.status','leave_president_approval.due_to','leave_submitted.supervisor_id','leave_president_approval.id'])
                        ->where('leave_submitted.employeeid', $current_user_id )
                        ->get();

                        foreach ($myleave_submitted  as $index => $dt ) {

                        $swhere= "N/A";
                        $status = "Pending";

                            if ($dt->swhere)
                            {
                                $swhere = $dt->swhere;

                            }

                            if($dt->status){

                                $status= $dt->status;
                            }

                            $td = [
                                "lid" => Crypt::encryptString($dt->lid),
                                "agency_id" => $current_user_id,
                                "typename"=> $dt-> typename,
                                "swhere" => $swhere ,
                                "status"=> $status,
                                "appliedno"=> $dt->appliedno,
                                "supervisor_id" => $dt->supervisor_id,

                            ];

                            $data[count($data)] = $td;

                        }
                        echo json_encode($data);

}
//End my leave submitted

//Start print my leave application
public function print_my_leave_application(Request $request){


    $pdf_data = [];

    $user_id = Auth::user()->employee;

    //query for submitted leave
    $id = Crypt::decryptString($request->lid);

    $print_myleave_submitted =leave_submitted::join('agency_employees', 'agency_employees.agency_id', '=', 'leave_submitted.employeeid')
                        ->leftjoin('profile','profile.agencyid', '=', 'agency_employees.agency_id')
                        ->leftjoin('tblposition', 'tblposition.id', '=', 'agency_employees.position_id')
                        ->leftjoin('tbluserassignment','tbluserassignment.id', '=', 'agency_employees.designation_id')
                        ->leftjoin('leave_recommendation', 'leave_recommendation.leavesubmittedid', '=', 'leave_submitted.id', 'active',1)
                        ->leftjoin('leave_president_approval', 'leave_president_approval.leavesubmittedid', '=', 'leave_submitted.id','active', 1)
                        ->leftjoin('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                        ->Select(['leave_submitted.*','agency_employees.agency_id','profile.firstname','profile.mi','profile.lastname','profile.extension',
                        'leave_type.id','leave_type.typename','leave_type.category','leave_type.leave_cat','leave_type.ledger_col_order','leave_type.long_name','leave_submitted.swhere','leave_submitted.from_date','leave_submitted.to_date','leave_submitted.appliedno','leave_submitted.updated_at as hr_noted_date',
                        'leave_submitted.type','leave_submitted.commutation','leave_president_approval.status','leave_president_approval.updated_at as predisent_note_date','leave_submitted.entrydate','tblposition.emp_position','tbluserassignment.userauthority','leave_recommendation.notedate as supervisor_note_date',
                        DB::raw('DATE_FORMAT(leave_submitted.entrydate, "%d-%b-%Y") as date_of_filing')])
                        ->where('leave_submitted.employeeid', $user_id)
                        ->where('leave_submitted.id', $id)
                        ->get($id)
                        ->unique('employeeid');


    //end query for submitted leave

    //condition for inclusive dates
    foreach($print_myleave_submitted as $get_val){

        $swhere = $get_val->swhere;
        $applied_number = $get_val->appliedno;
        $from_date = \Carbon\Carbon::parse($get_val->from_date  )->format('M d, Y');
        $to_date = \Carbon\Carbon::parse($get_val->to_date  )->format('M d, Y');
        $predisent_note_date = $get_val->predisent_note_date;
        $hr_note_date = $get_val->hr_noted_date;
        $supervisor_note_date = $get_val->supervisor_note_date;

        $get_inclusive_date =  $from_date .' - '.$to_date;
    }
    //end condition for inclusive dates

   //condition for details of leave
    $swhere_philipiines ="";
    $swhere_abroad = "";
    if($swhere =="Within the Philippines" ){

        $swhere_philipiines ="checked";

    }elseif($swhere =="Abroad"){

        $swhere_abroad ="checked";

    }
   //end condition for details of leave

   //condition for requested or not
   $requested = "";
   $not_requested = "";
   foreach ($print_myleave_submitted  as $index =>  $commutation) {

       $commutation =  $commutation->commutation;

       if ($commutation =="Requested")
      {
           $requested ="checked";

       }
       if($commutation == "Not Requested")
       {
           $not_requested ="checked";

       }

    }

   //end condition for requested or not

   //query for supervisor and president
    $get_supervisor = leave_submitted::with('get_supervisor_info')->first();
    $get_president = leave_president_approval::with('get_President_info')->first();
    //end query for supervisor and president

    //query for current HR Officer
    $get_hr_head = agency_employees::join('profile','profile.agencyid', 'agency_employees.agency_id')
                                    ->leftjoin('tblposition', 'tblposition.emp_position', '=', 'agency_employees.position_id')
                                    ->select('agency_employees.*','agency_employees.position_id','profile.lastname','profile.firstname','profile.mi','profile.extension','agency_employees.status', 'profile.e_signature')
                                    ->where('position_id', 15)
                                    ->where('agency_employees.status', 3)
                                    ->where('agency_employees.active', 1)
                                    ->get();
    //end query for current HR Officer

    //query for salary
    $get_emp_salary = DB::table('profile')
                           ->join('pr_salary', 'pr_salary.agency_id', 'profile.agencyid')
                           ->where('agencyid', Auth::user()->employee)->get();
    //end query for salary

    //query for leave type
    $get_leave_type = leave_type::join('leave_submitted','leave_submitted.type', '=', 'leave_type.id')
                            ->select('leave_submitted.*','leave_submitted.id', 'leave_submitted.employeeid')
                            ->where('leave_submitted.employeeid', $user_id)
                            ->where('leave_submitted.id', $id)
                            ->get($id);

               foreach( $get_leave_type as $get_longname){

                $get_longnametext = $get_longname->type;

               }
    //end query for leave type

    //query for leave order ascending
    $leave_type = leave_type::orderBy('ledger_col_order', 'asc')->get();
    //end query for leave order ascending

    //query for profile information
    $get_profile_info = leave_submitted::join('profile', 'profile.agencyid', '=', 'leave_submitted.employeeid')
                        ->select('firstname')
                        ->groupBy('firstname')
                        ->orderBy('firstname', 'asc')
                        ->where('employeeid', Auth::user()->employee)
                        ->get($request->id);
    //end query for profile information


    //query for settings header, footer and agency name
    if(system_settings())
        {
            $system_image_header = system_settings()->where('key','image_header')->first();
            $system_image_footer = system_settings()->where('key','image_footer')->first();
            $system_agency_name = system_settings()->where('key','agency_name')->first();

    }else
        {
            $system_image_header = '';
            $system_image_footer = '';
            $system_agency_name = '';
    }
    //end query for settings header, footer and agency name


    //start calculate sick and vacation balance

    $load_employee_available_leave_with_sum = employee_leave_available::with('get_leave_type')
                            ->where('employeeid', Auth::user()->employee)
                            ->selectRaw('leave_type_id,sum(no_of_leaves) as no_of_leaves_sum')
                            ->groupBy('leave_type_id')
                            ->get();
        $vacation = 0;
        $sick= 0;

        foreach ($load_employee_available_leave_with_sum as $get_total) {

            if ($get_total->leave_type_id == 5){

                    $sick = $get_total->no_of_leaves_sum;

                }elseif($get_total->leave_type_id == 4){

                        $vacation = $get_total->no_of_leaves_sum;

                }

            }

    $load_leave_submitted_sum = leave_approved::with('get_leave_type_val')
                            ->where('employeeid', Auth::user()->employee)
                            ->selectRaw('leavesubmittedid,sum(no_of_leaves) as no_of_leaves_submitted')
                            ->groupBy('leavesubmittedid')
                            ->get();

    $sick_submitted=0;
    $vacation_submitted=0;

    foreach ($load_leave_submitted_sum as $getV) {

        if ($getV->leavesubmittedid == 5){

                    $sick_submitted = $getV->no_of_leaves_submitted;

            }elseif($getV->leavesubmittedid == 4){

                        $vacation_submitted = $getV->no_of_leaves_submitted;

            }

        }

        $_sickbalance = ( $sick - $sick_submitted);
        $_vacation_balance = ($vacation - $vacation_submitted );


        $pdf = PDF::loadView('leave.print.print_my_leave',compact('print_myleave_submitted',
        'system_image_header',
        'system_image_footer',
        'system_agency_name',
        'leave_type',
        'requested',
        'not_requested',
        'get_longnametext',
        'get_supervisor',
        'get_hr_head',
        'get_president',
        'get_emp_salary',
        'swhere_philipiines',
        'swhere_abroad',
        'get_inclusive_date',
        'applied_number',
        'supervisor_note_date',
        'hr_note_date',
        'predisent_note_date',
        '_sickbalance',
        '_vacation_balance',
        'vacation_submitted',
        'sick_submitted',

        ))->setPaper('A4', 'portrait');

        return $pdf->stream($print_myleave_submitted . '.pdf');

}
//End print my leave application

//Start leave settings view
public function leave_settings_view(){

    $load_employee_hr_details = tblemployee::all();
    $tblemployee_count = tblemployee::count();
    $load_leave_type = leave_type::all();
    $leave_category = leave_category::all();

    return view('leave.leave_settingsfrm', compact('tblemployee_count','load_employee_hr_details','load_leave_type', 'leave_category'));

}
//End leave settings view

//Start leave category
public function store_leave_category(Request $request){


    $leave_category = leave_category::create([

        'name' =>trim($request->input('name'))

    ]);

    __notification_set(1,'Success','Leave Type Category Successfuly Added!');

    return redirect()->back();


}
//End leave category

//Start delete leave type function
public function delete_leave_category(Request $request, $id){

    $data = $request->all();

    $leave_category = leave_category::find($request->id);

    $leave_category->delete();


    return response()->json([
        'error' => false,
        'data'  => $leave_category->id,

    ], 200);

}
//End delete leave type function

//Start store employee leave beginning balance earn
public function store_employee_leave_beginning_balance_earn(Request $request){
    $data = $request->all();
    $Year =date("Y");
    $current_userid= Auth::user()->employee;

    $store_employee_leave_available=[
        'employeeid'=> $request->employeeid,
        'period_type' => $request->period_type,
        'no_of_leaves'=> $request->no_of_leaves,
        'leave_type_id' => $request->leave_type_id,

        'period_from'=> $request->period_from,
        'period_to' =>$request->period_to,
        'year' => $Year ,
        'particulars' => $request->particulars,
        'active'=> 1 ,
        'username' => $current_userid,


    ];
    //dd($store_employee_leave_available);

    employee_leave_available::create($store_employee_leave_available);

    __notification_set(1,'Success', 'Leave Type Earn is successfully added!');

    return json_encode(array(
        "data"=>$data,
    ));

}
//End store employee leave beginning balance earn

//Start store employee leave beginning balance deduction
public function store_employee_leave_beginning_balance_deduction(Request $request){
    $data = $request->all();
    $Year =date("Y");
    $current_userid= Auth::user()->employee;

    $days = 0;
    $hours = 0;
    $minutes = 0;
    $tardines = 0;

    //get day
    $days = $request->no_of_day;
    //get hour
    $hours = $request->no_of_hours;
    //get minute
    $minutes= $request->no_of_min;
    //get tardines
    $tardines = $request->no_of_tardines;




    $get_time_convertion = DB::table('conversion_time')
                        ->select('equivalent')
                        ->where('c_value', $minutes)
                        ->where('c_value', $hours)
                        ->where('c_value', $days)
                        ->get();


    $particulars = $tardines . "XT " . $days . "-" . $hours . "-" . $minutes;


    //END PARTICULAR

    //TIME CONVERSION

    $get_minutes = 0.000;
    $get_hours = 0.000;
    $get_time_miniutes = DB::table('conversion_time')
                    ->select('equivalent')
                    ->where('c_value', $minutes)
                    ->where('type', '=', 'min')
                    ->get();

    foreach($get_time_miniutes as   $row){

        $get_minutes = $row->equivalent;

    }

    if($hours > 8){
        $day = number_format(intdiv($hours, 8),3);
        $hours = number_format(fmod($hours, 8),3);
    }

    $get_time_hours = DB::table('conversion_time')
                    ->select('equivalent')
                    ->where('c_value', $hours)
                    ->where('type', '=', 'hour')
                    ->get();


    foreach($get_time_hours as $row){

        $get_hours = $row->equivalent;

        $total_deducted = number_format($get_minutes + $get_hours,3);

    }

    $total_deducted += number_format(($days * 1.000),3);

    // dd( $total_deducted );

    $store_leave_tardiness_deduction=[
        'employeeid'=> $request->employeeid,
        'leave_type_id'=> $request->leave_type_no,
        'deducted'=> $total_deducted,
        'particulars'=> $particulars,
        'month' => $request->month,
        'year' => $request-> year ,
        'no_of_min' => $request->no_of_min,
        'no_of_hours'=> $request->no_of_hours,
        'no_of_day'=> $request->no_of_day,
        'no_of_tardines'=> $request->no_of_tardiness,
        'active' => 1,
        'username' => $current_userid,

    ];

    leave_tardiness_deduction::create($store_leave_tardiness_deduction);

    __notification_set(1,'Success','Leave is successfully added!');

    return json_encode(array(
        "data"=>$data,
    ));

}
//End store employee leave beginning balance deduction

//Start get employee details set leave
public function get_employee_details_set_leave(Request $request){

    $get_load_employee_hr_details = [];

    $table = '';

    $load_employee_hr_details = tblemployee::join('agency_employees','agency_employees.agency_id', '=', 'profile.agencyid')
                                ->leftjoin('tblposition','tblposition.id', '=', 'agency_employees.position_id')
                                ->leftjoin('tbluserassignment','tbluserassignment.id', '=', 'agency_employees.designation_id')
                                ->leftjoin('employee_leave_available', 'employee_leave_available.employeeid', '=', 'profile.agencyid')
                                ->leftjoin('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                                ->select(['agency_employees.*','employee_leave_available.no_of_leaves','agency_employees.agency_id','leave_type.typename','profile.firstname','profile.lastname','profile.mi','profile.extension','profile.sex','employee_leave_available.no_of_leaves','employee_leave_available.particulars','employee_leave_available.period_from','employee_leave_available.period_to','tblposition.emp_position'])
                                ->where('agency_employees.id', $request->id)
                                ->get($request->id);


    return response()->json($load_employee_hr_details);


}
//End get employee details set leave

//Start get leave ledger details
public function get_leave_ledger_details(Request $request, $agency_id){

    $table = '';
    $filters = false;
    // {*Query for employee_leave_available and Details*}

    $load_employee_leave_ledger_details = DB::table('agency_employees')
                                ->join('profile','profile.agencyid', '=', 'agency_employees.agency_id')
                                ->join('tblposition','tblposition.id', '=', 'agency_employees.position_id')
                                ->join('tbluserassignment','tbluserassignment.id', '=', 'agency_employees.designation_id')
                                ->join('employee_leave_available', 'employee_leave_available.employeeid', '=', 'profile.agencyid')
                                ->join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                                ->select('agency_employees.*','leave_type.typename','leave_type.ledger_col_order','agency_employees.agency_id',
                                'leave_type.typename','profile.firstname','profile.lastname','profile.mi','profile.extension','profile.sex',
                                'employee_leave_available.no_of_leaves','employee_leave_available.particulars','employee_leave_available.period_from',
                                'employee_leave_available.period_to','tblposition.emp_position','agency_employees.start_date')
                                ->where('agency_id', $request->agency_id)
                                ->get();

    // {*Query for Leave Type By Order*}


    $load_employee_leave_ledger_details->where('agency_id', '<>', true);



    $get_leave_type_col =DB::table('employee_leave_available')
                                ->join('profile','profile.agencyid', '=', 'employee_leave_available.employeeid')
                                ->join('agency_employees','agency_employees.agency_id', '=', 'profile.agencyid')
                                ->join('tblposition','tblposition.id', '=', 'agency_employees.position_id')
                                ->join('tbluserassignment','tbluserassignment.id', '=', 'agency_employees.designation_id')
                                ->join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                                ->select('leave_type.ledger_col_order','leave_type.id', 'leave_type.typename','employee_leave_available.leave_type_id')
                                ->where('employeeid', $request->agency_id)
                                ->groupBy('leave_type_id')
                                ->orderBy('ledger_col_order', 'asc')
                                ->get();

    if($load_employee_leave_ledger_details){
    // {*Start Leave Ledger Function*}


    $table .= '<table class="table table-bordered">';
        foreach($load_employee_leave_ledger_details as $index => $get_name)
        {

        }
        $table .= '<th colspan="5" style="font-weight:bold;text-transform: uppercase; text-align:left;"> Name:&nbsp'.$get_name->lastname.',&nbsp'.$get_name->firstname.'&nbsp'.$get_name->extension.'&nbsp'.$get_name->mi.'</th>';
        $table .= '<th colspan="5" style="font-weight:bold;text-transform: uppercase; text-align:left;">Date of Employement:&nbsp'.\Carbon\Carbon::parse($get_name->start_date  )->format('m/d/Y').'</th>';
        $table .= '<th colspan="6" style="font-weight:bold;text-transform: uppercase; text-align:left;">Position:&nbsp'.$get_name->emp_position.'</th><br>';

            $table .= "<tr>";
            $table .= '<th rowspan="2"></th>';
            $table .= '<th rowspan="2">PERIOD</th>';
            $table .= '<th rowspan="2">PARTICULARS</th>';

    // {*get Leave Type By Order*}

            foreach ($get_leave_type_col  as $index => $row ) {

                if($row->id == 4 || $row->id == 5){

                $table .= '<th colspan="4" style="font-weight:bold;text-transform: uppercase; text-align:center;">'.$row->typename.' LEAVE</th>';

            }
            else if($row->id == 2){

                    $table .= '<th  style="font-weight:bold;text-transform: uppercase; text-align:center;">'.$row->typename.' LEAVE</th>';

                }
                else if($row->id == 15){

                    $table .= '<th  style="font-weight:bold;text-transform: uppercase; text-align:center;">'.$row->typename.'</th>';
                }
                else{
                    $table .= '<th style="font-weight:bold;text-transform: uppercase; text-align:center;" colspan="3">'.$row->typename.' LEAVE</th>';
                }
            }

                        $table .= '<th rowspan="2">Remarks</th>';
                        $table .= "</tr>";
                        $table .= "<tr>";



                     foreach ($get_leave_type_col  as $index => $row ) {

                        if($row->id == 4 || $row->id == 5){
                            $table .= '<td style="color:green;font-weight:bold">EARNED</td>';
                            $table .= '<td style="color:red;font-weight:bold">ABS. UND. W/P (MINUTES)</td>';
                            $table .= '<td style="color:black;font-weight:bold">BALANCE</td>';
                            $table .= '<td  style="color:red;font-weight:bold">ABS. UND. WOP</td>';
                        }
                        else if($row->id == 2 || $row->id == 15){
                            $table .= '<td style="color:black;font-weight:bold">BALANCE</td>';
                        }
                        else{
                            $table .= '<td style="color:green;font-weight:bold">ADDED</td>';
                            $table .= '<td style="color:red;font-weight:bold">DEDUCTED</td>';
                            $table .= '<td style="color:black;font-weight:bold">BALANCE</td>';

                        }
                    }

                    $table .= "</tr>";
                    $table .= "</thead>";
                    $table .= "<tbody>";

    // {*get Employee Name*}



                $table .='<tr>';

                $load_employee_available_leave_with_sum = employee_leave_available::join('leave_type', 'leave_type.id', '=', 'employee_leave_available.leave_type_id')
                ->groupBy('leave_type_id')
                ->orderBy('ledger_col_order', 'asc')
                ->selectRaw('leave_type_id,sum(no_of_leaves) as no_of_leaves_sum')
                ->where('employeeid', $request->agency_id)
                ->get();


                    $table.='<td style="color:rgb(66, 64, 64);font-weight:bold">' .'Balance'. '</td>
                            <td style="font: 5px;">' . ''. '</td>
                            <td style="font: 5px;">' . ''. '</td>';


                    foreach($load_employee_available_leave_with_sum  as $index => $h_value) {

                    if ($h_value->leave_type_id == 4 || $h_value->leave_type_id == 5 )
                         {
                            $table.='<td style="font: 5px;">' .''. '</td>
                                    <td style="font: 5px;">' . ''. '</td>
                                    <td style="font: 5px;font-weight:bold">' . $h_value->no_of_leaves_sum. '</td>
                                    <td style="font: 5px;">' .''. '</td>';


                    } elseif($h_value->leave_type_id == 2) {

                                $table.='<td style="font: 5px;font-weight:bold">'.$h_value->no_of_leaves_sum. '</td>';


                    } elseif($h_value->leave_type_id == 15) {

                                $table.='<td style="font: 5px;font-weight:bold">'.$h_value->no_of_leaves_sum. '</td>';

                    }else{

                                $table.='<td style="font: 5px;">' .''. '</td>
                                <td style="font: 5px;">' . ''. '</td>
                                <td style="font: 5px;font-weight:bold">' . $h_value->no_of_leaves_sum. '</td>';
                                }



                        }
                        $table.='<td style="font: 5px;">' .''. '</td>';

                        $table.=  ' </tr>';

    $table .= '</tbody></table>';


                        } else {

                                $table .='No Leave Available';

                        }

                return response()->json($table);

}
//End get leave ledger details

//Start temporary attachment documents
public function temp_attachement_documents(Request $request){
    $get_profile = tblemployee::where('user_id', Auth::user()->id)->first();

    $last_name = $get_profile->lastname;


    if ($request->hasFile('leave_attachments_id')) {

        foreach ($request->file('leave_attachments_id')as $file )
        {


            $get_file_type = $file->getClientMimeType();
            $explode_file_type = explode("/", $get_file_type);
            $file_type = $explode_file_type[1];

            $fileName = $last_name.'-'.date("YmdHis").'.'.$file_type;
            $folder = $last_name.'-'.uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/tmp/' . $folder,$fileName);

            $destinationPath = 'uploads/documents/leave/temporary/';
            $file->move(public_path($destinationPath), $fileName);

            applicants_tempfiles::create([
                'folder' => $folder,
                'filename' => $fileName]);

            return $folder;
        }
    }
    return '';
}
//End temporary attachment documents

//Start remove attachment documents
public function remove_attachement_documents(Request $request){

    $get_doc_path = request()->getContent();

    $splitDocFilePath = explode("<", $get_doc_path);

    $filePath = $splitDocFilePath[0];

    $tmp_file = applicants_tempfiles::where('folder', $filePath)->first();
    if($tmp_file)
    {
        //Remove picture from public/uploads
        $fp = public_path("uploads/documents/leave/temporary") . "\\" . $tmp_file->filename;
        if(file_exists($fp)) {
            unlink($fp);
        }

        Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
        $tmp_file->delete();

        return response('');
    }
}
//End remove attachment documents

//Start store leave application
public function store_apply_leave_application(Request $request){

    $data = $request->all();
    $Year =date("Y");
    $current_userid= Auth::user()->employee;


    $store_apply_leave_submitted=[

        'employeeid'=> $current_userid,
        'type'=> $request->type,
        'swhere'=> $request->swhere,
        'appliedno'=> $request->appliedno,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date ,
        'commutation' => $request->commutation,
        'active'=> 1,
        'leavetype'=> "Applied",
        'supervisor_id'=> $request->supervisor_id,


    ];
   $leavesubmittedid =  leave_submitted::create($store_apply_leave_submitted)->id;


   $store_leave_approved= [

    'employeeid' => $current_userid,
    'leavesubmittedid' =>$request->type,
    'no_of_leaves' =>  $request->appliedno,
    'active' => 1,


   ];
   leave_approved::create($store_leave_approved);



    $temfiles = applicants_tempfiles::all();

    foreach ($temfiles as $temp ) {

        $pathname = $temp->filename;
        $folder =$temp-> folder;

    }

    $leave_employee_attachments= [

            'leavesubmittedid'=>$leavesubmittedid,
            'employeeid'=> $current_userid,
            'attachment_type'=> $request->attachment_type,
            'filename'=> $pathname,
            'path'=> $folder,
            'active'=> 1 ,
    ];
    //dd($leave_employee_attachments);

    Storage::copy('public/tmp/'. $folder. '/' .$pathname, 'public/leave/' . $folder.'/'.$pathname);

    Storage::deleteDirectory('public/tmp/' . $folder);

    applicants_tempfiles::where('folder', $folder)->delete();

    leave_employee_attachments::create($leave_employee_attachments);



    __notification_set(1,'Success','Leave is successfully Applied!');

    return json_encode(array(
        "data"=>$store_apply_leave_submitted,
    ));


}
//End store leave application

//Start get approval value recommendation
public function get_approval_value_recommendation(Request $request){
    $load_employee_hr_details= leave_recommendation::join('profile','profile.agencyid', '=', 'leave_recommendation.employeeid')
                                                    ->select(['leave_recommendation.*','profile.agencyid','leave_recommendation.id as r_id','leave_recommendation.status','profile.firstname','profile.lastname','profile.mi','profile.extension'])
                                                    ->where('leave_recommendation.leavesubmittedid', $request->id)
                                                    ->first($request->id);

    return response()->json($load_employee_hr_details);

}
//End get approval value recommendation

//Start recommendation approve action leave application
public function recommendation_approve_action_leave_application(Request $request){
    $data = $request->all();
    $current_userid= Auth::user()->employee;

    $leavesubmittedid =  $request->input('leavesubmittedid');
    $status =  $request->input('status');
    $dueto =  $request->input('dueto');

    $id_exist = leave_recommendation::where('leavesubmittedid', $leavesubmittedid );

    if($id_exist){

        $id_exist->update([

            'status' => $status ,
            'dueto' => $dueto,
            'notedby'=> Auth::user()->employee,

        ]);


        $leave_president_approval = [

            'leavesubmittedid' => $request-> leavesubmittedid ,
            'employeeid' => $request->employeeid,
            'active' => 1,

        ];

        leave_president_approval::updateOrCreate($leave_president_approval);

        __notification_set(1,'success','success!');


    }else{

        __notification_set(-2,'Error','Contact ICTC !');
    }




}
//End recommendation approve action leave application

//Start leave summary
public function leave_summary(){

    return view('leave.leave_summary_transaction');

}
//End leave summary

//Start get leave summary transaction
public function get_leave_summery_transaction(Request $request){

    $get_leave_summary_transaction = [];

    if($request->ajax()) {

        if($request->date_from != '' && $request->date_to != '') {

            $load_leave_summary = DB::table('leave_submitted')
                    ->join('profile','profile.agencyid', '=', 'leave_submitted.employeeid')
                    ->join('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                    ->Select(['leave_submitted.*','leave_submitted.employeeid','profile.firstname','profile.mi','profile.lastname',
                    'profile.extension','leave_type.typename','leave_submitted.entrydate',
                    DB::raw('DATE_FORMAT(leave_submitted.entrydate, "%d-%b-%Y") as date_of_filing')])
                    ->whereBetween('leave_submitted.entrydate',array($request->date_from, $request->date_to))->get();


                    foreach ($load_leave_summary  as $index => $dt ) {


                        $td = [
                            "id" => $dt->id,
                            "agency_id" => $dt->employeeid,
                            "firstname" =>$dt ->firstname,
                            "mi" => mb_substr($dt->mi, 0, 1). '.',
                            "lastname" => $dt->lastname,
                            "extension"=> $dt->extension,
                            "date_of_filing" => $dt->date_of_filing,
                            "typename"=> $dt->typename,



                        ];

                        $get_leave_summary_transaction[count($get_leave_summary_transaction)] = $td;

                    }

                    echo json_encode($get_leave_summary_transaction);


        }else{

            $load_leave_summary = DB::table('leave_submitted')
                    ->join('profile','profile.agencyid', '=', 'leave_submitted.employeeid')
                    ->join('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
                    ->Select(['leave_submitted.*','leave_submitted.employeeid','profile.firstname','profile.mi','profile.lastname',
                    'profile.extension','leave_type.typename','leave_submitted.entrydate',
                    DB::raw('DATE_FORMAT(leave_submitted.entrydate, "%d-%b-%Y") as date_of_filing')])
                    ->get();


                    foreach ($load_leave_summary  as $index => $dt ) {

                        $td = [
                            "id" => $dt->id,
                            "agency_id" => $dt->employeeid,
                            "firstname" =>$dt ->firstname,
                            "mi" => mb_substr($dt->mi, 0, 1). '.',
                            "lastname" => $dt->lastname,
                            "extension"=> $dt->extension,
                            "date_of_filing" => $dt->date_of_filing,
                            "typename"=> $dt->typename,

                        ];

                        $get_leave_summary_transaction[count($get_leave_summary_transaction)] = $td;


                }

                echo json_encode($get_leave_summary_transaction);

            }
        }



}
//End get leave summary transaction

//Start print leave summary
public function print_leave_summary(Request $request){

         $print_leave_summary = DB::table('leave_submitted')
            ->join('profile','profile.agencyid', '=', 'leave_submitted.employeeid')
            ->join('leave_type', 'leave_type.id', '=', 'leave_submitted.type')
            ->Select(['leave_submitted.*','leave_submitted.employeeid','profile.firstname','profile.mi','profile.lastname',
            'profile.extension','leave_type.typename','leave_submitted.entrydate',
            DB::raw('DATE_FORMAT(leave_submitted.entrydate, "%d-%b-%Y") as date_of_filing')])
            ->whereBetween('leave_submitted.entrydate', [$request->date_from, $request->date_to])
            ->get();


   $date_from = $request->input('date_from');
   $date_to = $request->input('date_to');

    if(system_settings())
    {
        $system_image_header = system_settings()->where('key','image_header')->first();
        $system_image_footer = system_settings()->where('key','image_footer')->first();
        $system_agency_name = system_settings()->where('key','agency_name')->first();

    }else
    {
        $system_image_header = '';
        $system_image_footer = '';
        $system_agency_name = '';
    }


    $pdf = PDF::loadView('leave.print.print_leave_summary',compact('print_leave_summary',
    'system_image_header',
    'system_image_footer',
    'system_agency_name',
    'date_from',
    'date_to'
    ))->setPaper('A4', 'portrait');

     return $pdf->stream($print_leave_summary . '.pdf');
}
//End print leave summary

}


