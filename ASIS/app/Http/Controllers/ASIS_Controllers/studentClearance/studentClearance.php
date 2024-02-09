<?php

namespace App\Http\Controllers\ASIS_Controllers\studentClearance;

use App\Http\Controllers\Clearance\ClearanceController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ASIS_Models\Clearance\clearance;
use App\Models\ASIS_Models\Clearance\clearance_activities;
use App\Models\ASIS_Models\Clearance\clearance_notes;
use App\Models\ASIS_Models\Clearance\clearance_signatories;
use App\Models\ASIS_Models\Clearance\clearance_students;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\enrollment\enrollment_settings;
use App\Models\ASIS_Models\system\default_setting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class studentClearance extends Controller
{

    /**  STATUS CODES:
     *
     *  1 - PENDING
     *  13 - OPEN
     *
     */
    public function myClearance(){

        if(auth()->guard('web')->check())
        {
            $student_id = auth()->guard('web')->user()->studid;
        }

        $check_Signatory = clearance_signatories::where('signatory_id', $student_id)->where('active', 1)->first();

        if($check_Signatory)
        {
            $is_Signatory = true;
        }
        else
        {
            $is_Signatory = false;
        }


        $clearance_is_cleared = clearance_students::where('student_id', $student_id)->where('status', 7)->exists();

        $clearance_students = clearance_students::where('student_id', $student_id)->where('status', 1)->first();

        if($clearance_is_cleared)
        {
            $clearance_id = clearance_students::where('student_id', $student_id)->where('status', 7)->first()->clearance_id;
            $encrypted_clearance_id = encrypt($clearance_id);
        }else
        {
            $encrypted_clearance_id = '';
        }

        if($clearance_students)
        {
            $tracking_id = $clearance_students->tracking_id;
            $clearance_id = $clearance_students->clearance_id;

            $clearanceActivities = clearance_activities::where('tracking_id', $tracking_id)
                                                        ->where('clearance_id', $clearance_id)
                                                        ->where('student_id', $student_id)
                                                        ->get();

            $allStatusEqual11 = $clearanceActivities->every(function ($activity) {
                return $activity->status == 11;
            });

            if ($allStatusEqual11) {
                // All status values are equal to 11

                $clearance_students->status = 7; // Change 2 to the desired status value
                $clearance_students->save();

            }

        }


        $school_year = enrollment_settings::where('description', 'year')->first();
        $school_sem = enrollment_settings::where('description', 'sem')->first();

        return view('student.clearance.my_clearance', compact('is_Signatory', 'school_year', 'school_sem', 'clearance_is_cleared', 'encrypted_clearance_id'));

    }
    public function overview(){

        $employee_id = null;
        if(auth()->guard('web')->check())
        {
            $employee_id = auth()->guard('employee_guard')->user()->employee;
        }

        $check_Signatory = clearance_signatories::where('signatory_id', $employee_id)->where('active', 1)->first();

        if($check_Signatory)
        {
            $is_Signatory = true;
        }else
        {
            $is_Signatory = false;
        }

        $school_year = enrollment_settings::where('description', 'year')->first();
        $school_sem = enrollment_settings::where('description', 'sem')->first();
        return view('admin.ASIS.clearance.overview', compact('school_year', 'school_sem', 'is_Signatory'));

    }


    public function createClearance(Request $request)
    {
        if($request->clearance_id)
        {
            $clearance_id = \Crypt::decrypt(trim($request->clearance_id));
        }else
        {
            $clearance_id = null;
        }

        $clearance_name = trim($request->clearance_name);
        $clearance_type = trim($request->clearance_type);
        $clearance_schoolYear = trim($request->clearance_schoolYear);
        $clearance_schoolSem = trim($request->clearance_schoolSem);
        $clearance_program = $request->clearance_program;
        $clearance_created_by = auth()->guard('employee_guard')->user()->employee;

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $tracking_number = uniqid($year.'-'.$month.'-', false);

        if($clearance_id)
        {
            foreach ($clearance_program as $program)
            {
                clearance::where('id', $clearance_id)->update([

                    'name'  => $clearance_name,
                    'course'  => $program,
                    'type'  => $clearance_type,
                    'sem'   => $clearance_schoolSem,
                    'year'  => $clearance_schoolYear,

                ]);
            }



            return json_encode(array(

                'status' => 'success',
                'title' => 'Success!',
                'status_code' => 1,
                'message' => 'Clearance Updated successfully!',
            ), JSON_THROW_ON_ERROR);

        }
        else
        {
            $tres = [];
            foreach ($clearance_program as $program)
            {
                $create_new_clearance = [

                    'name'  => $clearance_name,
                    'course'  => $program,
                    'type'  => $clearance_type,
                    'sem'   => $clearance_schoolSem,
                    'year'  => $clearance_schoolYear,
                    'created_by' =>$clearance_created_by,
                    'status' => 13, //OPEN
                    'active' => 1,  //ACTIVE

                ];
                clearance::create($create_new_clearance);
            }

            return json_encode(array(

                'status' => 'success',
                'title' => 'Success!',
                'status_code' => 1,
                'message' => 'Clearance created successfully!',
            ), JSON_THROW_ON_ERROR);
        }

    }
    public function deleteClearance(Request $request)
    {
        $clearance_id = \Crypt::decrypt(trim($request->clearance_id));

        clearance::where('id', $clearance_id)->update([

            'active' => 0,

        ]);
        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Clearance deleted successfully!',
        ), JSON_THROW_ON_ERROR);
    }
    public function updateClearanceStatus(Request $request)
    {
        $clearance_id = \Crypt::decrypt(trim($request->clearance_id));
        $status_value = trim($request->clearance_status_checkbox);

        clearance::where('id', $clearance_id)->update([

            'status'  => $status_value,

        ]);

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Status Updated successfully!',
        ), JSON_THROW_ON_ERROR);
    }
    public function useClearanceTemplate(Request $request)
    {
        $template_clearance_id = \Crypt::decrypt(trim($request->created_clearance_template_id));
        $target_clearance_id = \Crypt::decrypt(trim($request->to_update_clearance_id));

        $get_signatories = clearance_signatories::where('clearance_id', $template_clearance_id)->where('active', 1)->get();


//        dd('TEMPLATE ID: '.$template_clearance_id.',    '.'TARGET CLEARANCE ID: '.$target_clearance_id);

        foreach ($get_signatories as $data)
        {
            $signatory_id = $data->signatory_id;
            $designation = $data->designation;
            $type = $data->type;


            clearance_signatories::updateOrCreate(
                [
                    'clearance_id'  => $target_clearance_id,
                    'signatory_id'  => $signatory_id,
                    'designation'   => $designation,
                    'type'  => $type,
                ],

                [
                    'clearance_id'  => $target_clearance_id,
                    'signatory_id'  => $signatory_id,
                    'designation'   => $designation,
                    'type'          => $type,
                    'active'        => 1,
                ]
            );

        }

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Clearance Updated successfully!',
        ), JSON_THROW_ON_ERROR);
    }



    public function load_All_StudentClearance(Request $request)
    {
        $student_id = null;
        $student_course = null;
        $is_requested_from_template = false;
        if(auth()->guard('web')->check())
        {
            $student_id = auth()->guard('web')->user()->studid;
            if(enrollment_list::where('studid', $student_id)->first())
            {
                $student_course = enrollment_list::where('studid', $student_id)->first()->studmajor;
            }
        }

        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';

        if (isset($filters['request_from_template'])) {

            $is_requested_from_template = $filters['request_from_template'];

            if($is_requested_from_template)
            {
                $this->queryCreatedClearance($perPage, $student_id, $student_course, $is_requested_from_template);
            }
        }

        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];
            $searchKeyword = trim($filters['search']);

            if ($limit_page === 999999) {

                if($student_id)
                {
                    $query_clearance = clearance::with(['getStatusCodes', 'getSignatories'])
                        ->where('status', 13)   //STATUS CODE:  13 - OPEN
                        ->where('active', 1)
                        ->whereRaw('LOWER(name) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(type) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(year) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(sem) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->paginate($limit_page);
                }else
                {
                    $query_clearance = clearance::with(['getStatusCodes', 'getSignatories'])
                        ->where('active', 1)
                        ->whereRaw('LOWER(name) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(type) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(year) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(sem) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->paginate($limit_page);
                }


                $results = $this->clearanceIterator($query_clearance);

            }
            else {

                $transactions = $this->queryCreatedClearance($perPage, $student_id, $student_course, $is_requested_from_template);
                $results = $this->clearanceIterator($transactions);

            }
        }
        else {

            $transactions = $this->queryCreatedClearance($perPage, $student_id, $student_course, $is_requested_from_template);
            $results = $this->clearanceIterator($transactions);
        }


        // Calculate the summary message
        $startEntry = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
        $endEntry = min($startEntry + $transactions->count() - 1, $transactions->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$transactions->total()} entries";


        return response()->json([
            'transactions' => $results,
            'search_query' => $search_value,
            'data' => $transactions->items(),
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total(),
            'summary' => $summaryMessage,
        ]); // Return the Transactions as a JSON response
    }
    public function queryCreatedClearance($perPage, $student_id, $student_course, $is_requested_from_template){

        if($student_id)
        {
            $query_clearance = clearance::with(['getStatusCodes', 'getSignatories', 'isRequested'])
                ->where('course', $student_course)
                ->where('status', 13)   //STATUS CODE:  13 - OPEN
                ->where('active', 1)
                ->paginate($perPage);

        }else
        {
            $query_clearance = clearance::with(['getStatusCodes', 'getSignatories'])
                ->where('active', 1)
                ->paginate($perPage);
        }

        if($is_requested_from_template)
        {
            $query_clearance = clearance::has('getSignatories')->with(['getStatusCodes', 'getSignatories'])
                ->where('active', 1)
                ->paginate($perPage);
        }

        return $query_clearance;

    }
    public function clearanceIterator($transactions){

        $tres = [];

        $is_student = false;
        if(auth()->guard('web')->check())
        {
            $is_student = true;
        }

        foreach ($transactions as $data)
        {

            $clearance_id = $data->id ?? 'No Data';
            $clearance_name = $data->name ?? 'No Data';
            $sem = $data->sem ?? 'No Data';
            $year = $data->year ?? 'No Data';
            $status = $data->status ?? 'No Data';
            $active = $data->active ?? 'No Data';
            $raw_clearance_type = $data->type;
            $course = $data->course ?? 'No Data';

            if($data->type == 'NON_GRADUATING')
            {
                $clearance_type = 'NON GRADUATING';
            }
            else
            {
                $clearance_type = 'GRADUATING';
            }

            if($active === '1')
            {
                $active_class = 'primary';
                $active_status = 'Active';
            }
            else
            {
                $active_class = 'danger';
                $active_status = 'In-Active';
            }

            if($data->getStatusCodes)
            {
                $status = $data->getStatusCodes->name;
                $status_class = $data->getStatusCodes->class;
            }
            else
            {
                $status = 'N/A';
                $status_class = 'secondary';
            }

            if($data->getSignatories)
            {
                $counted_signatories = count($data->getSignatories);
                $counter_class = 'text-slate-500';

            }
            else
            {
                $counted_signatories = 0;
                $counter_class = 'danger';
            }

            if($is_student)
            {
                $signatory_class = 'flex justify-center items-center';

            }
            else
            {
                $signatory_class = 'flex justify-center items-center fa-beat';
            }


            if($data->isRequested)
            {
                $has_requested = true;
            }
            else
            {
                $has_requested = false;
            }

            $td = [

                "clearance_id" => \Crypt::encrypt($clearance_id),
                "clearance_name" => $clearance_name,
                "clearance_type" => $clearance_type,
                "sem" => $sem,
                "year" => $year,
                "active_class" => $active_class,
                "active_status" => $active_status,
                "status" => $status,
                "status_class" => $status_class,
                "counted_signatories" => $counted_signatories,
                "counter_class" => $counter_class,
                "raw_clearance_type" => $raw_clearance_type,
                "course" => $course,
                "is_student" => $is_student,
                "signatory_class" => $signatory_class,
                "has_requested" => $has_requested,


            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }


    public function load_myStudentClearance(Request $request)
    {
        $student_id = null;
        $student_course = null;
        $is_requested_from_template = false;
        if(auth()->guard('web')->check())
        {
            $student_id = auth()->guard('web')->user()->studid;
            if(enrollment_list::where('studid', $student_id)->first())
            {
                $student_course = enrollment_list::where('studid', $student_id)->first()->studmajor;
            }
        }

        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];
            $searchKeyword = trim($filters['search']);

            if ($limit_page === 999999) {

                $query_clearance = clearance::with(['getStatusCodes', 'getSignatories'])
                    ->where('status', 13)   //STATUS CODE:  13 - OPEN
                    ->where('active', 1)
                    ->whereRaw('LOWER(name) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(type) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(year) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(sem) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->paginate($limit_page);


                $results = $this->myStudentclearanceIterator($query_clearance, $student_id);

            }
            else {

                $transactions = $this->queryMyClearance($perPage, $student_course, $student_id);
                $results = $this->myStudentclearanceIterator($transactions, $student_id);

            }
        }
        else
        {

            $transactions = $this->queryMyClearance($perPage, $student_course, $student_id);

            $results = $this->myStudentclearanceIterator($transactions, $student_id);
        }


        // Calculate the summary message
        $startEntry = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
        $endEntry = min($startEntry + $transactions->count() - 1, $transactions->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$transactions->total()} entries";


        return response()->json([
            'transactions' => $results,
            'search_query' => $search_value,
            'data' => $transactions->items(),
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total(),
            'summary' => $summaryMessage,
        ]); // Return the Transactions as a JSON response
    }
    public function queryMyClearance($perPage, $student_course, $student_id){

        return clearance::with(['getStatusCodes', 'getSignatories', 'isRequested', 'get_clearance_students'])
            ->where('course', $student_course)
            ->where('status', 13)   //STATUS CODE:  13 - OPEN
            ->where('active', 1)
            ->paginate($perPage);

//        return clearance::where('course', $student_course)
//            ->where('status', 13) // STATUS CODE: 13 - OPEN
//            ->where('active', 1)
//            ->orwhereHas('get_clearance_students', function ($query) use ($student_id) {
//                $query->where('student_id', $student_id);
//            })
//            ->paginate($perPage);

    }
    public function myStudentclearanceIterator($transactions, $student_id){

        $tres = [];
        $clearance_count = new clearance_activities();
        $clearance_students = new clearance_students();

        foreach ($transactions as $data)
        {

            $clearance_id = $data->id ?? 'No Data';
            $clearance_name = $data->name ?? 'No Data';
            $sem = $data->sem ?? 'No Data';
            $year = $data->year ?? 'No Data';
            $status = $data->status ?? 'No Data';
            $active = $data->active ?? 'No Data';
            $raw_clearance_type = $data->type;
            $course = $data->course ?? 'No Data';


            if($data->type == 'NON_GRADUATING')
            {
                $clearance_type = 'NON GRADUATING';
            }
            else
            {
                $clearance_type = 'GRADUATING';
            }

            if($active === '1')
            {
                $active_class = 'primary';
                $active_status = 'Active';
            }
            else
            {
                $active_class = 'danger';
                $active_status = 'In-Active';
            }

            if($data->getStatusCodes)
            {
                $status = $data->getStatusCodes->name;
                $status_class = $data->getStatusCodes->class;
            }
            else
            {
                $status = 'N/A';
                $status_class = 'secondary';
            }

            if($data->getSignatories)
            {
                $counted_signatories = count($data->getSignatories);
                $counter_class = 'text-slate-500';

            }
            else
            {
                $counted_signatories = 0;
                $counter_class = 'danger';
            }

            $hasRequestedClearance = $clearance_students->hasRequested($clearance_id, $student_id);

           if($hasRequestedClearance)
           {
               $tracking_id     = $hasRequestedClearance->tracking_id;
               $student_id      = $hasRequestedClearance->student_id;
               $counter         = $clearance_count->countSignedClearance($tracking_id, $clearance_id, $student_id);

           }else
           {
               $counter = 0;
               $tracking_id     = '';
               $student_id      = '';
           }

            $checked_request = clearance_students::where('clearance_id', $clearance_id)->where('student_id', $student_id)->first();


            if($checked_request)
            {
                $has_requested = true;
            }
            else
            {
                $has_requested = false;
            }

            $td = [

                "clearance_id" => \Crypt::encrypt($clearance_id),
                "clearance_name" => $clearance_name,
                "clearance_type" => $clearance_type,
                "sem" => $sem,
                "year" => $year,
                "active_class" => $active_class,
                "active_status" => $active_status,
                "status" => $status,
                "status_class" => $status_class,
                "counted_signatories" => $counted_signatories,
                "counter_class" => $counter_class,
                "raw_clearance_type" => $raw_clearance_type,
                "course" => $course,
                "has_requested" => $has_requested,
                "clearance_students_count" => $counter,
                "tracking_id" => $tracking_id,
                "student_id" => $student_id,
            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }









    public function load_All_Employees(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';

        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = trim($filters['search']);

            $studentsSearch = Admin::whereNotNull('employee')->
            whereRaw('LOWER(employee) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(middlename) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(username) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orderBy('employee', 'desc')
                ->paginate($perPage);

            $search_value = $this->employeeIterator($studentsSearch);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === 999999) {

                $studentsSearch = Admin::whereNotNull('employee')->
                whereRaw('LOWER(employee) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(middlename) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(username) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orderBy('employee', 'desc')
                    ->paginate($limit_page);

                $results = $this->employeeIterator($studentsSearch);

            }
            else {

                $transactions = $this->queryEmployees($limit_page);
                $results = $this->employeeIterator($transactions);

            }
        }
        else {

            $transactions = $this->queryEmployees($perPage);
            $results = $this->employeeIterator($transactions);
        }


        // Calculate the summary message
        $startEntry = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
        $endEntry = min($startEntry + $transactions->count() - 1, $transactions->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$transactions->total()} entries";


        return response()->json([
            'transactions' => $results,
            'search_query' => $search_value,
            'data' => $transactions->items(),
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total(),
            'summary' => $summaryMessage,
        ]); // Return the Transactions as a JSON response
    }
    public function queryEmployees($perPage){

        return Admin::whereNotNull('employee')
            ->where('active', 1)
            ->paginate($perPage);

    }
    public function employeeIterator($transactions){

        $tres = [];

        foreach ($transactions as $data)
        {

            $primary_id = $data->id ?? 'No Data';
            $employee_id = $data->employee ?? 'No Data';

            $active = $data->active ?? 'No Data';
            $created_at = $data->created_at ? Carbon::parse($data->created_at)->format('F d, Y') : 'No Data';

            $fullName = '';

            $first_name = $data->firstname;
            $last_name  = $data->lastname;

            $mi = GLOBAL_MIDDLE_NAME_GENERATOR($data->middlename);

            $fullName = $first_name.' '.$mi.' '.$last_name;


            if($data->email)
            {
                $email = $data->email ?? 'No Data';
                $class = 'text-slate-500 text-xs whitespace-nowrap mt-0.5';
            }
            else
            {
                $email = 'No Email Found';
                $class = 'text-danger text-xs whitespace-nowrap mt-0.5';
            }

            if($active === '1')
            {
                $active_class = 'primary';
                $active_status = 'Active';
            }
            else
            {
                $active_class = 'danger';
                $active_status = 'In-Active';
            }


            $td = [

                "primary_id" => $primary_id,
                "employee_id" => $employee_id,
                "email" => $email,
                "fullName" => $fullName,
                "active" => $active,
                "created_at" => $created_at,
                "active_class" => $active_class,
                "active_status" => $active_status,
                "class" => $class,


            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }







    public function load_All_Signatories(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_result = '';
        $search_value  = '';

        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = trim($filters['search']);

            $studentsSearch = User::whereNotNull('studid')
                ->where('active', 1)
                ->whereRaw('LOWER(studid) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(email) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orWhereRaw('LOWER(fullname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                ->orderBy('studid', 'desc')
                ->paginate($perPage);

            $search_value = $this->signatoryIterator($studentsSearch);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === 999999) {

                $studentsSearch = User::whereNotNull('studid')
                    ->where('active', 1)
                    ->whereRaw('LOWER(studid) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orWhereRaw('LOWER(fullname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit_page);

                $results = $this->signatoryIterator($studentsSearch);

            } else {

                $transactions = $this->querySignatories($limit_page);
                $results = $this->signatoryIterator($transactions);

            }
        }
        else {

            $transactions = $this->querySignatories($perPage);
            $results = $this->signatoryIterator($transactions);
        }

        if (isset($filters['clearanceId'])) {

            $clearanceId = \Crypt::decrypt($filters['clearanceId']);

            $transactions = clearance_signatories::with(['get_Employee_Data', 'get_Student_Data'])
                    ->where('clearance_id', $clearanceId)
                    ->where('active', 1)
                    ->paginate($perPage);

            $results = $this->signatoryIterator($transactions);

        }
        else {

            $transactions = $this->querySignatories($perPage);
            $results = $this->signatoryIterator($transactions);
        }


        // Calculate the summary message
        $startEntry = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
        $endEntry = min($startEntry + $transactions->count() - 1, $transactions->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$transactions->total()} entries";


        return response()->json([
            'transactions' => $results,
            'search_query' => $search_value,
            'data' => $transactions->items(),
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total(),
            'summary' => $summaryMessage,
        ]); // Return the Transactions as a JSON response
    }
    public function querySignatories($perPage){

        return clearance_signatories::where('active', 1)
                ->with(['get_Employee_Data', 'get_Student_Data'])
                ->paginate($perPage);

    }
    public function signatoryIterator($transactions){

        $tres = [];

        foreach ($transactions as $data)
        {

            $primary_id = $data->id ?? 'No Data';
            $signatory_id = $data->signatory_id ?? 'No Data';
            $type = $data->type ?? 'No Data';
            $designation = $data->designation ?? 'N/A';

            $active = $data->active ?? 'No Data';
            $created_at = $data->created_at ? Carbon::parse($data->created_at)->format('F d, Y') : 'No Data';

            $fullName = '';

            if($data->get_Employee_Data)
            {
                $first_name = $data->get_Employee_Data->firstname;
                $last_name  = $data->get_Employee_Data->lastname;

                $mi = GLOBAL_MIDDLE_NAME_GENERATOR($data->get_Employee_Data->mi);

                $fullName = $first_name.' '.$mi.' '.$last_name;

            }

            if($data->get_Student_Data)
            {
                $fullName = $data->get_Student_Data->fullname;
            }


            if($data->email)
            {
                $email = $data->email ?? 'No Data';
                $class = 'text-slate-500 text-xs whitespace-nowrap mt-0.5';
            }
            else
            {
                $email = 'No Email Found';
                $class = 'text-danger text-xs whitespace-nowrap mt-0.5';
            }

            if($active === '1')
            {
                $active_class = 'primary';
                $active_status = 'Active';
            }
            else
            {
                $active_class = 'danger';
                $active_status = 'In-Active';
            }


            $td = [

                "primary_id" => $primary_id,
                "signatory_id" => $signatory_id,
                "email" => $email,
                "fullName" => $fullName,
                "active" => $active,
                "created_at" => $created_at,
                "active_class" => $active_class,
                "active_status" => $active_status,
                "type" => $type,
                "class" => $class,
                "designation" => $designation,


            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }







    public function load_All_Students(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_result = '';
        $search_value  = '';

        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = trim($filters['search']);

            $studentsSearch = User::has('isEnrolled')
                ->whereNotNull('studid')
                ->where(function($query) use ($searchKeyword) {
                    $query->whereRaw('LOWER(studid) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(email) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(fullname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereHas('isEnrolled', function($subquery) use ($searchKeyword) {
                            $subquery->whereRaw('LOWER(studmajor) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                        });
                })
                ->orderBy('studid', 'desc')
                ->paginate($perPage);

            $search_value = $this->iterator($studentsSearch);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === 999999) {

                $studentsSearch = User::has('isEnrolled')
                    ->whereNotNull('studid')
                    ->where(function($query) use ($searchKeyword) {
                        $query->whereRaw('LOWER(studid) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                            ->orWhereRaw('LOWER(email) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                            ->orWhereRaw('LOWER(fullname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                            ->orWhereHas('isEnrolled', function($subquery) use ($searchKeyword) {
                                $subquery->whereRaw('LOWER(studmajor) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                            });
                    })
                    ->orderBy('studid', 'desc')
                    ->paginate($perPage);

                $results = $this->iterator($studentsSearch);

            } else {

                $transactions = $this->queryStudents($limit_page);
                $results = $this->iterator($transactions);

            }
        }
        else {

            $transactions = $this->queryStudents($perPage);
            $results = $this->iterator($transactions);

        }


        // Calculate the summary message
        $startEntry = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
        $endEntry = min($startEntry + $transactions->count() - 1, $transactions->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$transactions->total()} entries";


        return response()->json([
            'transactions' => $results,
            'search_query' => $search_value,
            'data' => $transactions->items(),
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total(),
            'summary' => $summaryMessage,
        ]); // Return the Transactions as a JSON response
    }
    public function queryStudents($perPage){

        return User::has('isEnrolled')
            ->orderBy('studid', 'desc')->paginate($perPage);

    }
    public function iterator($transactions){

        $tres = [];

        foreach ($transactions as $data)
        {

            $user_id = $data->id ?? 'No Data';
            $student_id = $data->studid ?? 'No Data';

            $password = $data->password ?? 'No Data';
            $fullName = $data->fullname ?? 'No Data';
            $email_verified = $data->email_verified ?? 'No Data';
            $email_verified_at = $data->email_verified_at ? Carbon::parse($data->email_verified_at)->format('F d, Y') : 'No Data';
            $active = $data->active ?? 'No Data';
            $created_at = $data->created_at ? Carbon::parse($data->created_at)->format('F d, Y') : 'No Data';

            if($data->email)
            {
                $email = $data->email ?? 'No Data';
                $class = 'text-slate-500 text-xs whitespace-nowrap mt-0.5';
            }
            else
            {
                $email = 'No Email Found';
                $class = 'text-danger text-xs whitespace-nowrap mt-0.5';
            }

            if($active === '1')
            {
                $active_class = 'primary';
                $active_status = 'Active';
            }
            else
            {
                $active_class = 'danger';
                $active_status = 'In-Active';
            }

            if($email_verified === '1')
            {
                $email_class = 'primary';
                $email_status = 'Verified';
            }
            else
            {
                $email_class = 'danger';
                $email_status = 'Un-Verified';
            }

            if($data->isEnrolled)
            {
                $course = $data->isEnrolled->studmajor;
            }
            else
            {
                $course = 'No Data';
            }

            $td = [

                "user_id" => $user_id,
                "student_id" => $student_id,
                "email" => $email,
                "password" => $password,
                "fullName" => $fullName,
                "email_verified" => $email_verified,
                "email_verified_at" => $email_verified_at,
                "active" => $active,
                "created_at" => $created_at,
                "email_class" => $email_class,
                "email_status" => $email_status,
                "active_class" => $active_class,
                "active_status" => $active_status,
                "class" => $class,
                "course" => $course,


            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }




    /** FUNCTION FOR SIGNATORY LIST IN SIDE-BAR */
    public function load_All_MySignatories(Request $request)
    {
        $search_clearance_data = null;
        $student_id = null;
        $student_fullName = 'N/A';
        $date_requested = 'N/A';
        $count_my_signatory = 'N/A';
        $signatory_type = '';
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');

        if(auth()->guard('web')->check())
        {
            $student_id = auth()->guard('web')->user()->studid;

            if (isset($filters['is_ViewingMore'])) {

                if(isset($filters['page_limit']))
                {
                    $limit_page = (int)$filters['page_limit'];

                    $get_my_signatories = clearance_activities::with(['getStatusCodes'])
                        ->where('signatory_id', $student_id)
                        ->where('active', 1)
                        ->whereHas('has_active_clearance', function ($query) {
                            $query->where('status', 13);
                        })
                        ->where('status', '!=', 11)   //STATUS CODES: 11 - APPROVED
                        ->paginate($limit_page);

                    $clearance_data = $this->mySignatoriesIterator($get_my_signatories);
                }
                else
                {
                    $get_my_signatories = clearance_activities::with(['getStatusCodes'])
                        ->where('signatory_id', $student_id)
                        ->where('active', 1)
                        ->whereHas('has_active_clearance', function ($query) {
                            $query->where('status', 13);
                        })
                        ->where('status', '!=', 11)   //STATUS CODES: 11 - APPROVED
                        ->paginate($perPage);

                    $clearance_data = $this->mySignatoriesIterator($get_my_signatories);
                }


                if(isset($filters['search']))
                {
                    $searchKeyword = $filters['search'];
                    $limit_page = $filters['page_limit'];

                    $get_my_signatories = clearance_activities::with(['getStatusCodes'])
                        ->whereHas('get_enrollees_Data', function ($query) use ($searchKeyword) {
                            $query->where(function ($query) use ($searchKeyword) {
                                $query->whereRaw('fullname LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                      ->orWhereRaw('studid LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                      ->orWhereRaw('email LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                            });
                        })
                        ->where('signatory_id', $student_id)
                        ->where('active', 1)
                        ->whereHas('has_active_clearance', function ($query) {
                            $query->where('status', 13);
                        })
                        ->where('status', '!=', 11)   //STATUS CODES: 11 - APPROVED
                        ->paginate($limit_page);

                    $search_clearance_data = $this->mySignatoriesIterator($get_my_signatories);

                }



                // Calculate the summary message
                $startEntry = ($get_my_signatories->currentPage() - 1) * $get_my_signatories->perPage() + 1;
                $endEntry = min($startEntry + $get_my_signatories->count() - 1, $get_my_signatories->total());

                $summaryMessage = "Showing $startEntry to $endEntry of {$get_my_signatories->total()} entries";

                return response()->json([
                    'search_query' => $search_clearance_data,
                    'result' => $clearance_data,
                    'data' => $get_my_signatories->items(),
                    'current_page' => $get_my_signatories->currentPage(),
                    'last_page' => $get_my_signatories->lastPage(),
                    'per_page' => $get_my_signatories->perPage(),
                    'total' => $get_my_signatories->total(),
                    'summary' => $summaryMessage,
                ]); // Return the Transactions as a JSON response

            }
            else
            {
                $get_my_signatories = clearance_activities::with(['getStatusCodes'])
                    ->where('signatory_id', $student_id)
                    ->where('active', 1)
                    ->whereHas('has_active_clearance', function ($query) {
                        $query->where('status', 13);
                    })
                    ->where('status', '!=', 11)   //STATUS CODES: 11 - APPROVED
                    ->orderby('updated_at', 'desc')
                    ->get();

                $clearance_data = $this->mySignatoriesIterator($get_my_signatories);

                return response()->json([
                    'result' => $clearance_data,
                ]); // Return the Transactions as a JSON response
            }
        }
        elseif(auth()->guard('employee_guard')->check())
        {
            $employee_id = auth()->guard('employee_guard')->user()->employee;


            if (isset($filters['is_ViewingMore'])) {

                if(isset($filters['page_limit']))
                {
                    $limit_page = (int)$filters['page_limit'];

                    $get_my_signatories = clearance_activities::with(['getStatusCodes'])
                        ->where('signatory_id', $employee_id)
                        ->where('active', 1)
                        ->whereHas('has_active_clearance', function ($query) {
                            $query->where('status', 13);
                        })
                        ->where('status', '!=', 11)   //STATUS CODES: 11 - APPROVED
                        ->orderby('updated_at', 'desc')
                        ->paginate($limit_page);

                    $clearance_data = $this->mySignatoriesIterator($get_my_signatories);

                }
                else
                {
                    $get_my_signatories = clearance_activities::with(['getStatusCodes'])
                        ->where('signatory_id', $employee_id)
                        ->where('active', 1)
                        ->whereHas('has_active_clearance', function ($query) {
                            $query->where('status', 13);
                        })
                        ->where('status', '!=', 11)   //STATUS CODES: 11 - APPROVED
                        ->orderby('updated_at', 'desc')
                        ->paginate($perPage);

                    $clearance_data = $this->mySignatoriesIterator($get_my_signatories);
                }

                if(isset($filters['search']))
                {
                    $searchKeyword = $filters['search'];
                    $limit_page = $filters['page_limit'];

                    $get_my_signatories = clearance_activities::with(['getStatusCodes'])
                        ->whereHas('get_enrollees_Data', function ($query) use ($searchKeyword) {
                            $query->where(function ($query) use ($searchKeyword) {
                                $query->whereRaw('fullname LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                    ->orWhereRaw('studid LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                    ->orWhereRaw('email LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                            });
                        })
                        ->where('signatory_id', $employee_id)
                        ->where('active', 1)
                        ->whereHas('has_active_clearance', function ($query) {
                            $query->where('status', 13);
                        })
                        ->where('status', '!=', 11)   //STATUS CODES: 11 - APPROVED
                        ->orderby('updated_at', 'desc')
                        ->paginate($limit_page);

                    $search_clearance_data = $this->mySignatoriesIterator($get_my_signatories);

                }


                // Calculate the summary message
                $startEntry = ($get_my_signatories->currentPage() - 1) * $get_my_signatories->perPage() + 1;
                $endEntry = min($startEntry + $get_my_signatories->count() - 1, $get_my_signatories->total());

                $summaryMessage = "Showing $startEntry to $endEntry of {$get_my_signatories->total()} entries";

                return response()->json([
                    'search_query' => $search_clearance_data,
                    'result' => $clearance_data,
                    'data' => $get_my_signatories->items(),
                    'current_page' => $get_my_signatories->currentPage(),
                    'last_page' => $get_my_signatories->lastPage(),
                    'per_page' => $get_my_signatories->perPage(),
                    'total' => $get_my_signatories->total(),
                    'summary' => $summaryMessage,
                ]); // Return the Transactions as a JSON response

            }else
            {
                $get_my_signatories = clearance_activities::with(['getStatusCodes'])
                    ->where('signatory_id', $employee_id)
                    ->where('active', 1)
                    ->whereHas('has_active_clearance', function ($query) {
                        $query->where('status', 13);
                    })
                    ->where('status', '!=', 11)   //STATUS CODES: 11 - APPROVED
                    ->orderby('updated_at', 'desc')
                    ->get();

                $clearance_data = $this->mySignatoriesIterator($get_my_signatories);

                return response()->json([
                    'result' => $clearance_data,
                ]); // Return the Transactions as a JSON response
            }
        }
    }
    public function mySignatoriesIterator($get_my_signatories){

        $tres = [];

        foreach ($get_my_signatories as $student)
        {

            $student_id = $student->get_enrollees_Data->studid;
            $student_fullName = $student->get_enrollees_Data->fullname;
            $student_course = $student->get_enrollees_Data->studmajor;

            $clearance_tracking_id = $student->tracking_id;
            $clearance_id = $student->clearance_id;

            $date_requested = Carbon::parse($student->created_at)->format('d F Y');

            $clearance_status = $student->get_StatusCode->name;
            $status_class = $student->get_StatusCode->class;

            $td = [

                "student_id" => $student_id,
                "student_fullName" => $student_fullName,
                "student_course" => $student_course,
                "date_requested"   => $date_requested,
                "clearance_tracking_id"   => $clearance_tracking_id,
                "clearance_id"   => $clearance_id,

                "clearance_status"   => $clearance_status,
                "status_class"   => $status_class,
                "activity_status"   => $clearance_status,
                "activity_status_class"   => $status_class,

            ];

            $tres[count($tres)] = $td;

        }

        return $tres;
    }
    /** FUNCTION FOR SIGNATORY LIST IN SIDE-BAR */




    public function addStudentToSignatories(Request $request)
    {
        $clearance_id = \Crypt::decrypt(trim($request->clearance_id));
        $student_id = trim($request->student_id);
        $type = 'STUDENT AFFAIRS';

        clearance_signatories::updateOrCreate(
            [
                'signatory_id'=> $student_id,
                'clearance_id'=> $clearance_id,
            ],

            [
                'signatory_id'  => $student_id,
                'clearance_id'=> $clearance_id,
                'type'          => $type,
                'active'        => 1,
            ]
        );

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Student Added Successfully!',
        ), JSON_THROW_ON_ERROR);

    }
    public function addEmployeeToSignatories(Request $request)
    {
        $clearance_id = \Crypt::decrypt(trim($request->clearance_id));
        $employee_id = trim($request->employee_id);
        $type = 'ACADEMIC AFFAIRS';

        clearance_signatories::updateOrCreate(
            [
                'signatory_id'=> $employee_id,
                'clearance_id'=> $clearance_id,
            ],

            [
                'signatory_id'  => $employee_id,
                'clearance_id'=> $clearance_id,
                'type'          => $type,
                'active'        => 1,
            ]
        );

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Employee Added Successfully!',
        ), JSON_THROW_ON_ERROR);

    }
    public function addSignatoryDesignation(Request $request)
    {
        $signatory_id = trim($request->signatory_id);
        $designation = trim($request->designation);

        clearance_signatories::where('signatory_id', $signatory_id)->update([

            'designation' => $designation,

        ]);

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Added Successfully!',
        ), JSON_THROW_ON_ERROR);

    }
    public function removeFromSignatory(Request $request)
    {
        $signatory_id = trim($request->signatory_id);
        $clearanceId = \Crypt::decrypt($request->clearance_id);

        clearance_signatories::where('clearance_id', $clearanceId)->where('signatory_id', $signatory_id)->update([

            'active' => 0,

        ]);

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Removed Successfully!',
        ), JSON_THROW_ON_ERROR);

    }






    public function loadMyClearanceRecentActivities(Request $request)
    {
        $student_id = null;
        if(auth()->guard('web')->check()) {

            $student_id = auth()->guard('web')->user()->studid;
        }

       $get_clearance_activities = clearance_activities::has('has_active_clearance')
                            ->with(['get_employeeSignatory_Data', 'get_studentSignatory_Data',  'get_StatusCode'])
                            ->where('student_id', $student_id)
                            ->where('status', '!=', 1) //STATUS CODES: 1 - PENDING
                            ->orderby('updated_at', 'desc')
                            ->get();

        $tres = [];
        $clearance_tracking_id = 'N/A';
        $clearance_id = 'N/A';
        $student_course = 'N/A';
        $activity_status = 'Pending';
        $activity_status_class = 'pending';

        foreach ($get_clearance_activities as $data)
        {
            $clearance_activity_id = $data->id;
            $clearance_tracking_id = $data->tracking_id;
            $clearance_id = $data->clearance_id;

            $date_requested = Carbon::parse($data->updated_at)->format('d F Y');

            if($data->remarks)
            {
                $remarks = $data->remarks;
            }else
            {
                $remarks = 'N/A';
            }


            $clearance_status = $data->get_StatusCode->name;
            $status_class = $data->get_StatusCode->class;
            $signatory_id = $data->signatory_id;

            if($data->get_employeeSignatory_Data)
            {

                $first_name = $data->get_employeeSignatory_Data->firstname;
                $last_name  = $data->get_employeeSignatory_Data->lastname;

                $mi = GLOBAL_MIDDLE_NAME_GENERATOR($data->get_employeeSignatory_Data->middlename);

                $signatory_fullName = $first_name.' '.$mi.' '.$last_name;

            }
            elseif($data->get_studentSignatory_Data)
            {
                $signatory_fullName = $data->get_studentSignatory_Data->fullname;
                $student_course = $data->get_studentSignatory_Data->studmajor;

            }
            else
            {
                $signatory_fullName = 'N/A';
            }

            if($data->getStatusCodes)
            {
                $activity_status = $data->getStatusCodes->name;
                $activity_status_class = $data->getStatusCodes->class;

            }else
            {
                $activity_status = 'Pending';
                $activity_status_class = 'pending';
            }


            $td = [

                "clearance_activity_id" => $clearance_activity_id,
                "signatory_id" => $signatory_id,
                "signatory_fullName" => $signatory_fullName,
                "student_course" => $student_course,
                "date_requested"   => $date_requested,
                "clearance_status"   => $clearance_status,
                "status_class"   => $status_class,
                "clearance_tracking_id"   => $clearance_tracking_id,
                "clearance_id"   => $clearance_id,
                "activity_status"   => $activity_status,
                "activity_status_class"   => $activity_status_class,
                "remarks"   => $remarks,

            ];

            $tres[count($tres)] = $td;

        }

        return response()->json([
            'result' => $tres,
        ]); // Return the Transactions as a JSON response

    }




    public function dismissImportantNotes(Request $request)
    {
        $important_note_id = trim($request->note_id);

        clearance_notes::where('id', $important_note_id)->update([

            'dismiss' => 1,

        ]);


        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Note dismiss successfully!',

        ), JSON_THROW_ON_ERROR);

    }
    public function createImportantNotes(Request $request)
    {
        $employee_id        = null;
        $note_for_program    = $request->note_for_program;
        $admin_note_title    = trim($request->admin_note_title);
        $admin_notes         = trim($request->admin_notes);
        $type               = 'Clearance Important Note';
        $is_note_for_all = $request->is_note_for_all;

        if(auth()->guard('employee_guard')->check())
        {
            $employee_id = auth()->guard('employee_guard')->user()->employee;
        }

        $programs = enrollment_list::whereNotNull('studmajor')
                                    ->groupBy('studmajor')
                                    ->orderBy('studmajor', 'desc')
                                    ->pluck('studmajor');
        if($is_note_for_all == true)
        {
            foreach ($programs as $program)
            {
                $create_new_note = [

                    'created_by' => $employee_id,
                    'type'       => $type,
                    'title'      => $admin_note_title,
                    'program'    => $program,
                    'note'       => $admin_notes,
                    'dismiss'    => 0,
                    'active'     => 1,  //ACTIVE

                ];
                clearance_notes::create($create_new_note);
            }

            return json_encode(array(

                'status' => 'success',
                'title' => 'Success!',
                'status_code' => 1,
                'message' => 'Note created successfully!',
            ), JSON_THROW_ON_ERROR);
        }else
        {
            foreach ($note_for_program as $program)
            {
                $create_new_note = [

                    'created_by' => $employee_id,
                    'type'       => $type,
                    'title'      => $admin_note_title,
                    'program'    => $program,
                    'note'       => $admin_notes,
                    'dismiss'    => 0,
                    'active'     => 1,  //ACTIVE

                ];
                clearance_notes::create($create_new_note);
            }

            return json_encode(array(

                'status' => 'success',
                'title' => 'Success!',
                'status_code' => 1,
                'message' => 'Note created successfully!',
            ), JSON_THROW_ON_ERROR);
        }
    }










    public function approveClearance(Request $request)
    {
        $tracking_id = trim($request->tracking_id);
        $clearance_id = trim($request->clearance_id);
        $student_id = trim($request->student_id);
        $comments = trim($request->comments);
        $isApproved = trim($request->isApproved);

        if(auth()->guard('web')->check())
        {
            $signatory_id = auth()->guard('web')->user()->studid;
        }
        if(auth()->guard('employee_guard')->check())
        {
            $signatory_id = auth()->guard('employee_guard')->user()->employee;
        }


        clearance_activities::updateOrCreate(
            [
                'tracking_id'  => $tracking_id,
                'clearance_id'    => $clearance_id,
                'student_id'    => $student_id,
                'signatory_id'    => $signatory_id,
            ],

            [
                'tracking_id'   => $tracking_id,
                'clearance_id'  => $clearance_id,
                'student_id'    => $student_id,
                'signatory_id'  => $signatory_id,
                'remarks'       => $comments,
                'status'        => $isApproved,
                'active'        => 1,
            ]
        );

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Success!'
        ), JSON_THROW_ON_ERROR);
    }
    public function resubmitClearance(Request $request)
    {
        $activity_id = trim($request->activity_id);


        if(auth()->guard('web')->check())
        {
            $signatory_id = auth()->guard('web')->user()->studid;
        }
        if(auth()->guard('employee_guard')->check())
        {
            $signatory_id = auth()->guard('employee_guard')->user()->employee;
        }

        clearance_activities::where('id', $activity_id)->update([

            'status' => 28,    //STATUS CODE: 28 - RESUBMIT
            'remarks' => null,

        ]);

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Success!',
        ), JSON_THROW_ON_ERROR);
    }

    public function requestStudentClearance(Request $request)
    {

        $student_id = null;
        if(auth()->guard('web')->check())
        {
            $student_id = auth()->guard('web')->user()->studid;
        }

        $clearance_id = decrypt($request->encrypted_clearance_id);

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $transaction_id = uniqid($year.'-'.$month.'-', false);


        $set_clearance_request = clearance_students::updateOrCreate(
            [
                'clearance_id'  => $clearance_id,
                'student_id'    => $student_id,
            ],

            [
                'tracking_id'   => $transaction_id,
                'clearance_id'  => $clearance_id,
                'student_id'    => $student_id,
                'status'        => 1,   // STATUS CODE: 1 - PENDING
                'active'        => 1,
            ]
        );

        $tracking_id = $set_clearance_request->tracking_id;
        $get_clearance_signatories = clearance_signatories::where('clearance_id', $clearance_id)->where('active', 1)->get();

        foreach ($get_clearance_signatories as $signatory)
        {
            $signatory_id = $signatory->signatory_id;
            clearance_activities::updateOrCreate(
                [
                    'tracking_id'  => $tracking_id,
                    'clearance_id' => $clearance_id,
                    'student_id'   => $student_id,
                    'signatory_id' => $signatory_id,
                ],

                [
                    'tracking_id'  => $tracking_id,
                    'clearance_id' => $clearance_id,
                    'student_id'   => $student_id,
                    'signatory_id' => $signatory_id,
                    'status'       => 1,   // STATUS CODE: 1 - PENDING
                    'active'       => 1,
                ]
            );
        }

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => 1,
            'message' => 'Requested Successfully!',
        ), JSON_THROW_ON_ERROR);

    }
    public function viewMyClearanceSignedData(Request $request)
    {
        $tres = [];

        $decrypted_clearance_id = \Crypt::decrypt(trim($request->clearance_id));
        $tracking_id = trim($request->tracking_id);
        $student_id = trim($request->student_id);

        $get_clearance_activities = clearance_activities::with(['get_employeeSignatory_Data'])
                                ->where('tracking_id', $tracking_id)
                                ->where('clearance_id', $decrypted_clearance_id)
                                ->where('student_id', $student_id)
                                ->whereHas('has_active_clearance', function ($query) {
                                    $query->where('status', 13); //STATUS CODES: 13 - OPEN
                                })
                                ->where('status', 11)  //STATUS CODES: 11 - APPROVED
                                ->where('active', 1)
                                ->get();


        foreach ($get_clearance_activities as $data)
        {

            if($data->get_employeeSignatory_Data)
            {

                $first_name = $data->get_employeeSignatory_Data->firstname;
                $last_name  = $data->get_employeeSignatory_Data->lastname;

                $mi = GLOBAL_MIDDLE_NAME_GENERATOR($data->get_employeeSignatory_Data->middlename);

                $signatory_fullName = $first_name.' '.$mi.' '.$last_name;

            }
            elseif($data->get_studentSignatory_Data)
            {
                $signatory_fullName = $data->get_studentSignatory_Data->fullname;
                $student_course = $data->get_studentSignatory_Data->studmajor;

            }
            else
            {
                $signatory_fullName = 'N/A';
            }

            if($data->get_clearance_signatories)
            {
                $designation = $data->get_clearance_signatories->designation;
            }
            else
            {
                $designation = 'N/A';
            }

            if($data->getStatusCodes)
            {
                $activity_status = $data->getStatusCodes->name;
                $activity_status_class = $data->getStatusCodes->class;

            }else
            {
                $activity_status = 'Pending';
                $activity_status_class = 'pending';
            }


            $td = [


                "signatory_fullName"   => $signatory_fullName,
                "designation"   => $designation,
                "activity_status"   => $activity_status,
                "activity_status_class"   => $activity_status_class,

            ];

            $tres[count($tres)] = $td;

        }

        return response()->json([
            'result' => $tres,
        ]); // Return the Transactions as a JSON response
    }



    public function studentPrintClearance($clearance_id)
    {

        $decrypted_clearance_id = \Crypt::decrypt($clearance_id);
        $student_id = null;
        $student_name = null;
        $student_year = '_______';
        $student_section = null;
        $generated_year = null;
        $clearance_tracking_number = null;
        $qrCode = null;
        $student_course = '_______';

        if(auth()->guard('web')->check())
        {
            $student_id = auth()->guard('web')->user()->studid;
            $student_name = auth()->guard('web')->user()->fullname;
            $student_section = enrollment_list::where('studid', $student_id)->first()->section;
            $student_year = GLOBAL_YEAR_LEVEL_GENERATOR(enrollment_list::where('studid', $student_id)->first()->year_level);

            $generated_year = $student_year['year'];

            $clearance_tracking_number = clearance_students::where('clearance_id', $decrypted_clearance_id)->first()->tracking_id;

            $qrCode = base64_encode(QrCode::format('svg')->size(60)->errorCorrection('M')->generate($clearance_tracking_number));

            $student_course = enrollment_list::where('studid', $student_id)->first()->studmajor;

        }


        $request_type = 'view';

        if(clearance::where('id', $decrypted_clearance_id)->first())
        {
            $type = GLOBAL_CLEARANCE_TYPE_GENERATOR(clearance::where('id', $decrypted_clearance_id)->first()->type);
            $clearance_type = $type['type'];

        }else
        {
            $clearance_type = 'Clearance';
        }


        $filename = $student_course.' '.$clearance_type.' Clearance';

        $clearance_header = default_setting::where('key', 'clearance_header')->where('active', 1)->first();
        $agency_name = default_setting::where('key', 'agency_name')->where('active', 1)->first()->value;
        $agency_header = default_setting::where('key', 'image_header_landscape')->where('active', 1)->first();
        $agency_footer = default_setting::where('key', 'image_footer_landscape')->where('active', 1)->first();
        $agency_logo = default_setting::where('key', 'agency_logo')->where('active', 1)->first();
        $active_school_year = enrollment_settings::where('description', 'year')->where('active', 1)->first();
        $active_school_semester = GLOBAL_SEMESTER_GENERATOR(enrollment_settings::where('description', 'sem')->where('active', 1)->first()->key_value);

        $active_school_semester = $active_school_semester['sem'];


        $studentAffairsSignatory = clearance_activities::with(['get_enrollees_Data', 'get_employeeSignatory_Data'])
            ->where('clearance_id', $decrypted_clearance_id)
            ->where('student_id', $student_id)
            ->where('active', 1)
            ->whereHas('get_clearance_signatories', function ($query) {
                $query->where('type', 'STUDENT AFFAIRS');
            })
            ->get();


        $academicAffairsSignatory = clearance_activities::with(['get_enrollees_Data', 'get_employeeSignatory_Data'])
            ->where('clearance_id', $decrypted_clearance_id)
            ->where('student_id', $student_id)
            ->where('active', 1)
            ->whereHas('get_clearance_signatories', function ($query) {
                $query->where('type', 'ACADEMIC AFFAIRS');
            })
            ->get();


        $studentAffairsSignatoryCombined_table_td = '';
        $academicAffairsSignatoryCombined_table_td = '';


        $i = 0; // Counter for tracking the number of <td> elements
        foreach ($academicAffairsSignatory as $data)
        {


            if($data->get_employeeSignatory_Data)
            {
                $firstname = $data->get_employeeSignatory_Data->firstname;
                $lastname = $data->get_employeeSignatory_Data->lastname;
                $mi = GLOBAL_MIDDLE_NAME_GENERATOR($data->get_employeeSignatory_Data->mi);

                $signatory_name = $firstname.' '.$mi.' '.$lastname;

//                if($data->get_employeeSignatory_Data->e_signature)
//                {
//                    $signature = 'uploads/e_signature/'.$data->get_employeeSignatory_Data->e_signature;
//                }else
//                {
//                    $signature = 'uploads/settings/DSSC/global_logo.png';
//                }
            }else
            {
                $signatory_name = 'N/A';
            }




            if($data->get_clearance_signatories->designation)
            {
                $designation = $data->get_clearance_signatories->designation;
            }
            else
            {
                $designation = 'N/A';
            }

            // Increment the counter
            $i++;

            // Combine name and designation in the same <td> element
            if($data->status == 11)
            {
                $signature_from_DB = '2018-00162-20231016141945.png';
                $signature = 'uploads/e_signature/'.$signature_from_DB;

                $combined_td = '
                <td class="text-center" width="100%">
                    <div style="margin-top: 1rem">
                        <img src="'.$signature.'" width="auto" height="5%">
                   </div>

                    <div style="margin-top: -1.4rem" class="calibri text-11px text-center">' . $signatory_name . '</div>
                    <div class="calibri border-top text-8px text-center">' . $designation . '</div>
                </td>';
            }
            else
            {
                $combined_td = '
                <td class="text-center" width="100%">
                    <div style="margin-top: 2.8rem" class="calibri text-11px text-center">' . $signatory_name . '</div>
                    <div class="calibri border-top text-8px text-center">' . $designation . '</div>
                </td>';
            }

            // Add the combined <td> element to the table data variable
            $academicAffairsSignatoryCombined_table_td .= $combined_td;

            // Check if 3 <td> elements are reached, then start a new <tr>
            if ($i % 3 == 0) {

                $academicAffairsSignatoryCombined_table_td .= '</tr><tr>';
            }

        }

        // If the last row is not complete, add empty <td> elements to fill the row
        if ($i % 3 != 0) {
            $remaining_td = 3 - ($i % 3);

            $academicAffairsSignatoryCombined_table_td .= str_repeat('<td></td>', $remaining_td);
        }

        // Close the last row
        $academicAffairsSignatoryCombined_table_td .= '</tr>';


        $x = 0; // Counter for tracking the number of <td> elements
        foreach ($studentAffairsSignatory as $data)
        {
            if($data->get_studentSignatory_Data)
            {
                $signatory_name = $data->get_studentSignatory_Data->fullname;
            }
            else
            {
                $signatory_name = 'N/A';
            }

            if($data->get_clearance_signatories->designation)
            {
                $designation = $data->get_clearance_signatories->designation;
            }
            else
            {
                $designation = 'N/A';
            }

            // Increment the counter
            $x++;

            // Combine name and designation in the same <td> element
            if($data->status == 11)
            {
                $signature_from_DB = '2018-00162-20231016141945.png';
                $signature = 'uploads/e_signature/'.$signature_from_DB;

                $combined_td = '
                <td class="text-center" width="100%">
                    <div style="margin-top: 1rem">
                        <img src="'.$signature.'" width="auto" height="5%">
                   </div>

                    <div style="margin-top: -1.4rem" class="calibri text-11px-new text-center">' . $signatory_name . '</div>
                    <div class="calibri border-top text-8px text-center">' . $designation . '</div>
                </td>';
            }
            else
            {
                $combined_td = '
                <td class="text-center" width="100%">
                    <div style="margin-top: 2.8rem" class="calibri text-11px-new text-center">' . $signatory_name . '</div>
                    <div class="calibri border-top text-8px text-center">' . $designation . '</div>
                </td>';
            }

            // Add the combined <td> element to the table data variable
            $studentAffairsSignatoryCombined_table_td .= $combined_td;

            // Check if 3 <td> elements are reached, then start a new <tr>
            if ($x % 3 == 0) {

                $studentAffairsSignatoryCombined_table_td .= '</tr><tr>';
            }


        }

        // If the last row is not complete, add empty <td> elements to fill the row
        if ($x % 3 != 0) {
            $student_remaining_td = 3 - ($x % 3);

            $studentAffairsSignatoryCombined_table_td .= str_repeat('<td></td>', $student_remaining_td);
        }

        // Close the last row
        $studentAffairsSignatoryCombined_table_td .= '</tr>';




        $pdf = PDF::loadView('student.clearance.print_clearance',
            compact([

                'agency_header', 'agency_footer', 'active_school_year', 'agency_logo', 'clearance_header',

                'clearance_type',
                'agency_name',
                'student_name',
                'student_course',
                'clearance_tracking_number',
                'qrCode',
                'generated_year',
                'active_school_semester',
                'student_section',
                'academicAffairsSignatoryCombined_table_td',
                'studentAffairsSignatoryCombined_table_td',

                ]))->setPaper('a4', 'portrait');

        if ($request_type == 'view')
        {
            return $pdf->stream($filename . '.pdf');

        } elseif ($request_type == 'download')
        {
            return $pdf->download($filename . '.pdf');
        }
    }




}






