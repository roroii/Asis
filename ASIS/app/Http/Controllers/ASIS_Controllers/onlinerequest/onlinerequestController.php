<?php

namespace App\Http\Controllers\ASIS_Controllers\onlinerequest;

use App\Models\ASIS_Models\OnlineRequest\admin_User;
use App\Models\ASIS_Models\OnlineRequest\student_request;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\OnlineRequest\temp_files;
use App\Models\ASIS_Models\OnlineRequest\attachment_files;
use App\Models\User;
use App\Models\Admin;
use App\Models\ASIS_Models\posgres\portal\srgb\student;
use App\Models\ASIS_Models\OnlineRequest\offices;
use App\Models\ASIS_Models\OnlineRequest\office_services;
use App\Models\ASIS_Models\posgres\enrollment\srgb\semstudent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use PDF;
use Session;


class onlinerequestController extends Controller
{
    //

public function dashboard() {


    $student_requested_count = student_request::count();
    $pending_student_request = student_request::where('status', 'Pending')->count();
    $approved_student_request = student_request::where('status', 'Approed')->count();
    $disapproved_student_request = student_request::where('status', 'Disapproved')->count();

    $get_StudentCourse = student_request::join('enrollment_list', 'enrollment_list.studid', '=', 'student_request.studid')
    ->select('enrollment_list.studmajor')
    ->groupBy('studmajor')
    ->orderBy('studmajor', 'asc')
    ->get();


    $courseProgram = student_request::join('enrollment_list', 'enrollment_list.studid', '=', 'student_request.studid')->select('studmajor', DB::raw('COUNT(studmajor) AS countProgram, concat(studmajor) as Program'))
        ->groupBy('studmajor')
        ->orderBy('studmajor', 'asc')
        ->get();

    $chartData="";
    foreach($courseProgram as $list){
    $chartData.="['".$list->studmajor."',".$list->countProgram."],";
                }
    $arr['chartData']=rtrim($chartData,",");



        return view("layouts.onlinerequest.dashboard", compact('student_requested_count','pending_student_request','approved_student_request','disapproved_student_request','get_StudentCourse','chartData'));


}

// public function load_requested_data(Request $request){

//   $data = $request->all();
//         $get_requested_data = [];

//         if (Auth::user()->role == 'Admin'){

//         $load_requested_data = student_request::with('get_student_fullname')->orderBy('student_request.created_at', 'desc')->get();


//             $recieved_date_status="No Yet";
//             $approved_date_status = "No Yet";
//             $tae = "&nbsp &nbsp &nbsp *---*";


//             foreach ($load_requested_data as $dt) {

//                 if ( $dt->recieved_date){

//                     $recieved_date_status= $dt->recieved_date;
//                 }


//                 //
//             $td = [

//                 "id" => $dt->id,//tae
//                 "fullname" =>$dt->get_student_fullname->fullname,
//                 "studmajor"=> $dt->get_student_fullname->studmajor,
//                 "claim_date" => $dt->claim_date ? \Carbon\Carbon::parse($dt->claim_date)->format('m/d/Y') : "&nbsp &nbsp &nbsp*---*",
//                 "updated_at" =>\Carbon\Carbon::parse($dt->updated_at)->format('m/d/Y'),
//                 "recieved_date"=> $recieved_date_status,
//                 "purpose" => $dt->purpose,
//                 "request_type" => $dt->request_type,
//                 "no_of_copies" => $dt->no_of_copies,
//                 "status" => $dt->status,
//                 "approvedate"=> $dt->approvedate ? $dt->approvedate: "Not Yet",
//                 "created_at"=> \Carbon\Carbon::parse($dt->created_at)->format('m/d/Y')

//             ];

//             $get_requested_data[count($get_requested_data)] = $td;


//         }

//         echo json_encode($get_requested_data);


//         }else{

//         $load_requested_data = student_request::with('get_student_fullname')->where('office', Auth::user()->office )->orderBy('student_request.created_at', 'desc')->get();

//             $recieved_date_status="No Yet";
//             $approved_date_status = "No Yet";
//             $tae = "&nbsp &nbsp &nbsp *---*";


//             foreach ($load_requested_data as $dt) {

//                 if ( $dt->recieved_date){

//                     $recieved_date_status= $dt->recieved_date;
//                 }



//             $td = [

//                 "id" => $dt->id,//tae
//                 "fullname" =>$dt->get_student_fullname->fullname,
//                 "studmajor"=> $dt->get_student_fullname->studmajor,
//                 "claim_date" => $dt->claim_date ? \Carbon\Carbon::parse($dt->claim_date)->format('m/d/Y') : "&nbsp &nbsp &nbsp*---*",
//                 "updated_at" =>\Carbon\Carbon::parse($dt->updated_at)->format('m/d/Y'),
//                 "recieved_date"=> $recieved_date_status,
//                 "purpose" => $dt->purpose,
//                 "no_of_copies" => $dt->no_of_copies,
//                 "status" => $dt->status,
//                 "approvedate"=> $dt->approvedate ? $dt->approvedate: "Not Yet",
//                 "created_at"=> \Carbon\Carbon::parse($dt->created_at)->format('m/d/Y')

//             ];

//             $get_requested_data[count($get_requested_data)] = $td;


//         }

//         echo json_encode($get_requested_data);
//       }


//     }


 public function load_requested_data(Request $request){

    $data = $request->all();
    $get_requested_data = [];

   if (Auth::guard('employee_guard')->user()->role_name == 'Admin'){


    $get_admin_userData = student_request::with('get_student_fullname')->where('office', Auth::guard('employee_guard')->user()->office_id)->get();


        $recieved_date_status="No Yet";
        $approved_date_status = "No Yet";
        $tae = "&nbsp &nbsp &nbsp *---*";

          foreach ($get_admin_userData as $dt) {

            if ( $dt->recieved_date){

                    $recieved_date_status= $dt->recieved_date;

                }

        //
            $td = [

                "id" => $dt->id,//tae
                "fullname" =>$dt->get_student_fullname->fullname,
                "studmajor"=> $dt->get_student_fullname->studmajor,
                "claim_date" => $dt->claim_date ? \Carbon\Carbon::parse($dt->claim_date)->format('m/d/Y') : "&nbsp &nbsp &nbsp*---*",
                "updated_at" =>\Carbon\Carbon::parse($dt->updated_at)->format('m/d/Y'),
                "recieved_date"=> $recieved_date_status,
                "purpose" => $dt->purpose,
                "request_type" => $dt->request_type,
                "no_of_copies" => $dt->no_of_copies,
                "status" => $dt->status,
                "approvedate"=> $dt->approvedate ? $dt->approvedate: "Not Yet",
                "created_at"=> \Carbon\Carbon::parse($dt->created_at)->format('m/d/Y')

            ];

            $get_requested_data[count($get_requested_data)] = $td;


        }

        echo json_encode($get_requested_data);



    }else{


    $get_admin_userData = student_request::with('get_student_fullname')->where('office', Auth::guard('employee_guard')->user()->office_id)->get();


        $recieved_date_status="No Yet";
        $approved_date_status = "No Yet";
        $tae = "&nbsp &nbsp &nbsp *---*";


            foreach ($get_admin_userData as $dt) {

                if ( $dt->recieved_date){

                    $recieved_date_status= $dt->recieved_date;
                }


            $td = [

                "id" => $dt->id,//tae
                "fullname" =>$dt->get_student_fullname->fullname,
                "studmajor"=> $dt->get_student_fullname->studmajor,
                "claim_date" => $dt->claim_date ? \Carbon\Carbon::parse($dt->claim_date)->format('m/d/Y') : "&nbsp &nbsp &nbsp*---*",
                "updated_at" =>\Carbon\Carbon::parse($dt->updated_at)->format('m/d/Y'),
                "recieved_date"=> $recieved_date_status,
                "purpose" => $dt->purpose,
                "request_type" => $dt->request_type,
                "no_of_copies" => $dt->no_of_copies,
                "status" => $dt->status,
                "approvedate"=> $dt->approvedate ? $dt->approvedate: "Not Yet",
                "created_at"=> \Carbon\Carbon::parse($dt->created_at)->format('m/d/Y')

            ];

            $get_requested_data[count($get_requested_data)] = $td;


        }

        echo json_encode($get_requested_data);


    }



 }



 public function search_Requested_List(Request $request){

    $student_RequestApplication = student_request::with()->where()->get();


 }



 public function printRequestList_byProgram(Request $request){


    $date_from_req = $request->input('date_from_req');
    $date_to_req = $request->input('date_to_req');
    $programCourse = $request->input('programCourse');


    $RequestList_byProgram = student_request::join('enrollment_list', 'enrollment_list.studid', '=', 'student_request.studid')->whereBetween('student_request.created_at', [$date_from_req, $date_to_req])->where('student_request.office', Auth::user()->office)->where('enrollment_list.studmajor', $programCourse)->get();

  dd($RequestList_byProgram) ;

    $system_image_header = '';
    $system_image_footer = '';
    $system_agency_name = '';

    if (system_settings()) {
        $system_image_header = system_settings()->where('key', 'image_header')->first();
        $system_image_footer = system_settings()->where('key', 'image_footer')->first();
        $system_agency_name = system_settings()->where('key', 'agency_name')->first();
    }

    $pdf = PDF::loadView('layouts.onlinerequest.print.print_program_list', compact(
        'RequestList_byProgram',
        'system_image_header',
        'system_image_footer',
        'system_agency_name',
        'date_from_req',
        'date_to_req'
    ))->setPaper('A4', 'portrait');

    $fileName = 'RequestList_byProgram.pdf'; // Set a valid file name here

    if ($this->shouldDownloadPDF($pdf)) {
        return $pdf->download($fileName);
    } else {
        return $pdf->stream($fileName);


    }
}

public function get_offices_services(Request $request){


    $get_offices_services=  offices::join('office_services', 'office_services.office_id', '=', 'offices.id')->select('services','office_id','office_services.id as serv_id')->where('office_id', $request->id)->get();



   return response()->json($get_offices_services);

}


public function student_dashboard(){

    $get_offices = offices::join('office_services', 'offices.id', '=', 'office_services.office_id')
        ->select('offices.id as office_id', 'offices.office_name', DB::raw('GROUP_CONCAT(office_services.services) AS concatenated_services'))
        ->groupBy('offices.id', 'offices.office_name')
        ->orderBy('offices.office_name', 'asc')
        ->get();


        $get_student_fullname = student::where('studid', Auth::user()->studid ) ->get();

             foreach($get_student_fullname as $index => $row){

                        $student_fullname = $row->studfullname;

                    }


        $get_student_course = semstudent::with('get_StudentRequest')->where('studid', Auth::user()->studid )->get();

            $student_course ="";
             foreach($get_student_course as $index => $row)
             {

                $student_course = trim($row->studmajor) ;
                $student_level = trim($row->studlevel);

             }


        $count_my_request = student_request::where('studid', Auth::user()->studid)->count();



        return view('layouts.onlinerequest.my_dashboard', compact('get_offices','student_fullname','student_course','student_level','count_my_request'));
}


public function load_student_request(Request $request){

       $data = $request->all();
        $get_student_request = [];

      $load_student_request =student_request::with('get_offices', 'get_attachment_files')->where('studid', Auth::user()->studid)->get();


    foreach ($load_student_request as $dt) {

    $approved_date_status = $dt->approvedate ? $dt->approvedate : "Not Yet";

     $status = $dt->status ? $dt->status : "Pending";

    $printR = $dt->recieved_date ? '<div><button id="' . $dt->id . '"href="javascript:;" class= "print_btn" ><i class="fa fa-print text-success"></i></button></div>' : '';

    if ($dt->request_id){

        $checkReqeuest = $dt->request_id;

    }else{

        $checkReqeuest = "No File";

    }

    $td = [
        "id" =>$dt->id,
        "sched_date" => $dt->sched_date,
        "approved_date" => $approved_date_status,
        "recieved_date" => $dt->recieved_date ?: "Not Yet",
        "printR" => $printR,
        "office_name" => $dt->get_offices->office_name,
        "purpose" => $dt->purpose,
        "request_type" => $dt->request_type,
        "no_of_copies" => $dt->no_of_copies,
        "checkfile"=> $checkReqeuest,
        "status" => $status,
        "created_at" => Carbon::parse($dt->created_at)->format('m/d/Y'),
    ];

    $get_student_request[] = $td;
}

echo json_encode($get_student_request);



}


public function load_set_account_office(){

    $get_studentAccount = [];

    $get_user_account = admin_User::join('portal.offices', 'offices.id', '=' , 'admin_User.office_id')->get();


    foreach($get_user_account as $i => $row){

        if ($row->email){

            $get_email = $row->email;

        }else{

            $get_email = "No Email";

        }

       if ($row->role_name){

            $get_role_name = $row->role_name;

        }else{

            $get_role_name = "User";

        }


          $td = [

                "id" => $row->id,
                "fullname" => $row->firstname .' '. mb_substr($row->middlename, 0, 1).'.'. ' '. $row->lastname,
                "email" => $get_email,
                "role" => $get_role_name,
                "office_name"=> $row->office_name,


            ];

            $get_studentAccount[count($get_studentAccount)] = $td;


        }

        echo json_encode($get_studentAccount);




}

public function  printR_request(Request $request, $id)
{

   $printR =  student_request::with('get_student_fullname')->where('id', $request->id)->get();



    $system_image_header = '';
    $system_image_footer = '';
    $system_agency_name = '';

    if (system_settings()) {
        $system_image_header = system_settings()->where('key', 'image_header')->first();
        $system_image_footer = system_settings()->where('key', 'image_footer')->first();
        $system_agency_name = system_settings()->where('key', 'agency_name')->first();
    }

    $pdf = PDF::loadView('layouts.onlinerequest.print.print_my_request', compact(
        'printR',
        'system_image_header',
        'system_image_footer',
        'system_agency_name'

    ))->setPaper('A4', 'portrait');

    $fileName = 'printR.pdf'; // Set a valid file name here

    if ($this->shouldDownloadPDF($pdf)) {
        return $pdf->download($fileName);
    } else {
        return $pdf->stream($fileName);


    }


}


public function student_request_application(Request $request){

    $data = $request->all();

    $student_req_application = [

        'studid' => auth::user()->studid,
        'course' => trim($request->course),
        'office' => trim($request->office),
        'request_type'=> trim($request->request_type),
        'purpose' => trim($request->purpose),
        'no_of_copies' => trim($request->no_of_copies),
        'message'=> trim($request->message),
        'status' => 'Pending',
        'approvedate' => 0 ,
        'active'=> 1,


    ];


    student_request::create($student_req_application);

    __notification_set(1,'Success','Online Application Successfuly Done!');

    return json_encode(array(
        "student_req_application"=>$student_req_application,
    ));


}


public function get_receive_function_request(Request $request , $id){

    $s_id = student_request::find($id);

    return response()->json($s_id);

}

public function receive_date_function(Request $request)
{

    $r_id =  $request->input('r_id');

    $get_status=student_request::where('id', $r_id)->get();

    foreach( $get_status as $row){

        $get_approve = $row->status;
    }


    if ($get_approve == "Approved"){

    student_request::where('id', $r_id)->update([

        'recieved_date'=> date("m/d/y"),

    ]);


        return json_encode(array(
            'approval_status' => 200,
        ));

    }else{


        return json_encode(array(
            'error' => 200,
        ));

    }

}

 public function manage_or(){

     $get_offfice= offices::where('active' , 1)->get();
     $get_user_account = Auth::guard('employee_guard')->user()::where('active' , 1)->get();

      //return response()->json($get_user_account);

    return view('layouts.onlinerequest.manage', compact('get_offfice', 'get_user_account'));

 }

public function get_office_departmentlist(Request $request)
{

        $data = $request->all();

        $get_offices_data = [];

        $load_offices_data = offices::where('active' ,1)
                            ->orderBy('office_name', 'asc')
                            ->get();


        foreach ($load_offices_data as $dt) {

            $td = [

                "id" => $dt->id,
                "office_name" => $dt->office_name,

            ];

            $get_offices_data[count($get_offices_data)] = $td;


        }

        echo json_encode($get_offices_data);
}


public function set_user_account_update(Request $request){

    $user_id_exist = $request->input('id');

    $id_user_account_exist = admin_User::where('id' , $user_id_exist)->first();


       if ($id_user_account_exist){

        $id_user_account_exist->update([

            'office_id' => $request->office,

        ]);

       return json_encode(array(
                'approval_status' => 200,
            ));


       }else{

       return json_encode(array(
                'error' => 200,
            ));


       }

}


public function remove_user_account(Request $request, $id){



    $id_user_account_exist = User::where('id' , $id)->first();
dd($id_user_account_exist);

       if ($id_user_account_exist){

        $id_user_account_exist->update([

            'office' => "",

        ]);

       return json_encode(array(
                'approval_status' => 200,
            ));


       }else{

       return json_encode(array(
                'error' => 200,
            ));


       }

}



 public function edit_offices_manage($id){

    $data = offices::find($id);


    return response()->json($data);

 }

 public function delete_offices(Request $request){

    $data = $request->all();

    $delete_offices = offices::findOrFail($request->id);

    $delete_offices->delete();


    return response()->json([
        'error' => false,
        'data'  => $delete_offices->id,

    ], 200);
 }


public function store_new_office(Request $request){

 $data = $request->all();
    $add_office = [

        'office_name' => $request->office_name,
        'active' => 1,

    ];

    offices::create($add_office);

    __notification_set(1,'Success','Offices Successfuly Added!');

    return json_encode(array(
        "add_office"=>$add_office,
    ));

    }

  public function get_list_of_offices_and_services(Request $request)
    {

    $data = $request->all();

    $get_list_offices_data= [];

    $load_list_offices = office_services::join('offices', 'offices.id', '=', 'office_services.office_id')
                            ->select('office_services.*','office_services.id as id','offices.office_name')
                            ->orderBy('office_name', 'asc')
                            ->where('office_services.active', 1) // table name for 'active' column
                            ->get();


        foreach ($load_list_offices as $dt) {

            $td = [

                "id" => $dt->id,
                "office_name" => $dt->office_name,
                "services" => $dt->services,
                "added_by"=> $dt->added_by,
                "created_at"=> \Carbon\Carbon::parse($dt->created_at)->format('m/d/Y'),

            ];


            $get_list_offices_data[count($get_list_offices_data)] = $td;


        }

        echo json_encode($get_list_offices_data);
        }

 public function store_officeServices(Request $request){


    $data = $request->all();

    $add_office_services = [

        'office_id' => $request->office_id,
        'services'=> $request->services,
        'added_by'=>  Auth()->guard('employee_guard')->user()->username,
        'active' => 1,

    ];

    office_services::create($add_office_services );

    __notification_set(1,'Success','Office Services Added Successfuly!');

    return json_encode(array(

        "add_office_services"=>$add_office_services,
    ));

 }


  public function delete_services(Request $request){

    $data = $request->all();

    $delete_services = office_services::findOrFail($request->id);

    $delete_services->delete();


    return response()->json([
        'error' => false,
          'data'  => $delete_services->id,

    ], 200);
 }//


//*heads approval function*/

public function approval_requested_action($id){

    $get_requested_data = student_request::with('get_student_fullname')->find($id);



    return response()->json($get_requested_data);


}

public function requested_action_approval(Request $request){

    $approval_status = $request->all();

    $std_id =  $request->input('std_id');
    $studid =  $request->input('studid');


    student_request::where('id', $std_id)->update([
        'status' => $request->status,
        'message'=> $request->messages,
        'claim_date' => $request->claim_date,
        'approvedate'=> date("m/d/y"),
    ]);


    //create attachments

    $temp_files = temp_files::all();

    foreach ($temp_files as $temp) {
    $folder = $temp->folder;
    $pathname = $temp->filename;

    // Copy the file to the new location
    Storage::copy('public/tmp/' . $folder . '/' . $pathname, 'public/attachment_request/' . $folder . '/' . $pathname);

    // Delete the file after copying
    Storage::delete('public/tmp/' . $folder . '/' . $pathname);

    }

    // Now, delete the directory after all the files are copied and deleted
    Storage::deleteDirectory('public/tmp/' . $folder);

    // Delete the corresponding database records
    temp_files::where('folder', $folder)->delete();

    // Create the attachment_files record
    $attachment_files = [
    'studid' => $studid,
    'request_id' => $std_id,
    'folder' => $folder,
    'filename' => $pathname,
    ];

    attachment_files::create($attachment_files);



    //end create attachments

        return json_encode(array(
            'approval_status' => 200,
        ));


        }


//start download attachement documents
public function download_attachment_documents(Request $request){

$leave_submitted_documents = student_request::with('get_attachment_files')
    ->where('id', $request->id)->get();

foreach ($leave_submitted_documents as $file) {
    $folder = $file->get_attachment_files->folder;
    $filename = $file->get_attachment_files->filename;
}

$storage = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

$pathfile = $storage . "public/attachment_request/" . $folder . "/" . $filename;

if (file_exists($pathfile)) {
    // Log the file path for debugging
    error_log("File found at: " . $pathfile);

    return response()->download($pathfile);
} else {
    // Log the file path and error message for debugging
    error_log("File not found: " . $pathfile);
    echo('File not found.');
}



}


public function print_request_transactions(Request $request){

    $date_from = $request->input('date_from_req');
    $date_to = $request->input('date_to_req');
    $programCourse = $request->input('programCourse');

    $print_request_summary = student_request::join('enrollment_list', 'enrollment_list.studid', '=', 'student_request.studid')->whereBetween('student_request.created_at', [$date_from, $date_to])->where('enrollment_list.studmajor', '=' , $programCourse)->get();

    $get_CourseMajor = "";

    foreach($print_request_summary as $row)
    {
        $get_CourseMajor = $row->studmajor;
    }


    $system_image_header = '';
    $system_image_footer = '';
    $system_agency_name = '';

    if (system_settings()) {
        $system_image_header = system_settings()->where('key', 'image_header')->first();
        $system_image_footer = system_settings()->where('key', 'image_footer')->first();
        $system_agency_name = system_settings()->where('key', 'agency_name')->first();
    }

    $pdf = PDF::loadView('layouts.onlinerequest.print.print_list_request', compact(
        'print_request_summary',
        'system_image_header',
        'system_image_footer',
        'system_agency_name',
        'date_from',
        'date_to',
        'get_CourseMajor'
    ))->setPaper('A4', 'portrait');

    $fileName = 'print_request_summary.pdf'; // Set a valid file name here

    if ($this->shouldDownloadPDF($pdf)) {
        return $pdf->download($fileName);
    } else {
        return $pdf->stream($fileName);


    }
}

protected function shouldDownloadPDF($pdf)
    {
        // Set a threshold size in kilobytes above which the PDF will be downloaded instead of streamed
        $downloadThresholdKB = 512; // Half of 1 MB in KB

        $pdfContent = $pdf->output();
        $pdfSizeKB = strlen($pdfContent) / 1024; // Convert bytes to kilobytes

        return $pdfSizeKB > $downloadThresholdKB;
    }


public function create_temporaryfiles(Request $request){

   $get_User=  admin_User::where('employee', Auth::guard('employee_guard')->user()->employee )->get();

    foreach($get_User as $getfullname){

        $firstname = $getfullname->firstname;
        $lastname = $getfullname->firstname;

        $fullname= $firstname .'.'. $lastname ;
    }


     if ($request->hasFile('attachments_request_id')) {

        foreach ($request->file('attachments_request_id')as $file )
        {

            $get_file_type = $file->getClientMimeType();

            $explode_file_type = explode("/", $get_file_type);

            $file_type = $explode_file_type[1];

            $fileName = $fullname.'-'.date("YmdHis").'.'.$file_type;
            $folder = $fullname.'-'.uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/tmp/' . $folder,$fileName);

            $destinationPath = 'uploads/documents/temporary/';
            $file->move(public_path($destinationPath), $fileName);

            temp_files::create([
                'folder' => $folder,
                'filename' => $fileName]);

            return $folder;
        }
    }
    return '';


}


//Start remove attachment documents
public function remove_attachement_documents(Request $request){

    $get_doc_path = request()->getContent();

    $splitDocFilePath = explode("<", $get_doc_path);

    $filePath = $splitDocFilePath[0];

    $tmp_file = temp_files::where('folder', $filePath)->first();
    if($tmp_file)
    {
        //Remove picture from public/uploads
        $fp = public_path("uploads/documents/temporary") . "\\" . $tmp_file->filename;
        if(file_exists($fp)) {
            unlink($fp);
        }

        Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
        $tmp_file->delete();

        return response('');
    }
}
//End remove attachment documents



}
