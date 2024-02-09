<?php

namespace App\Http\Controllers\Pre_Enrollees;

use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\academic_records\curriculum;
use App\Models\ASIS_Models\enrollment\enrollment_settings;
use App\Models\ASIS_Models\pre_enrollees\enrollees_appointment;
use App\Models\ASIS_Models\system\default_setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

//        $this->middleware('enrollees_auth');

    }

    public function transactionList()
    {
        return view('pre_enrollees.Transaction.transaction');
    }

    public function myTransaction()
    {
        return view('pre_enrollees.Transaction.my_transaction');
    }

    public function transactionListDetails($transactionId)
    {
        if(auth()->guard('employee_guard')->check() || auth()->guard('enrollees_guard')->check())
        {
            $encrypted_transactionId = $transactionId;
            $decrypted_transactionId = \Crypt::decrypt($encrypted_transactionId);
            $transaction_details = enrollees_appointment::find($decrypted_transactionId);
            $other_details = enrollees_appointment::where('id', $decrypted_transactionId)->where('active', 1)->with(['getEnrolleesInfo', 'getEmployeeInfo', 'getScheduleData', 'getAddress', 'getStatusCodes'])->first();

            $agency_name = default_setting::where('active', 1)->where('key', 'agency_name')->first();
            $agency_header = default_setting::where('active', 1)->where('key', 'image_header')->first();
            $agency_footer = default_setting::where('active', 1)->where('key', 'image_footer')->first();

            $header = url('') . "/uploads/settings/" . $agency_header->image;
            $footer = url('') . "/uploads/settings/" . $agency_footer->image;

            $fullName = 'No Data';
            $email = 'No Data';
            $address = 'No Data';
            $transactions_ID = 'No Data';
            $transactions_Date = 'No Data';
            $client_name = 'No Data';
            $message = '';
            $province = '';
            $city_mun = '';
            $barangay = '';
            $status = '';
            $status_class = '';
            $scheduled_date = '';
            $date_desc = '';
            $approved_by = 'No Data';
            $emps_first_name = 'No Data';
            $emps_last_name = 'No Data';
            $position_designation = 'No Data';
            $active_schoolYear = 'No Data';
            $active_sem = 'No Data';


            /**
             *  CLIENT DETAILS
             */

            if($other_details->getEnrolleesInfo)
            {
                $enrollees_id = $other_details->getEnrolleesInfo->pre_enrollee_id;
                $first_name = strtoupper($other_details->getEnrolleesInfo->firstname);
                $last_name = strtoupper($other_details->getEnrolleesInfo->lastname);

                if($other_details->getEnrolleesInfo->midname)
                {
                    $my_mid_name   = $other_details->getEnrolleesInfo->midname;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }else
                {
                    $mi = '';
                }

                $fullName = $first_name.' '.$mi.' '.$last_name;
                $email = $other_details->getEnrolleesInfo->email;
            }

            $client_name = $fullName;

            if($other_details->getAddress)
            {
                if($other_details->getAddress->get_province)
                {
                    $province = ucfirst(strtolower($other_details->getAddress->get_province->provDesc));
                }
                if($other_details->getAddress->get_city_mun)
                {
                    $city_mun = ucfirst(strtolower($other_details->getAddress->get_city_mun->citymunDesc));
                }
                if($other_details->getAddress->get_brgy)
                {
                    $barangay = ucfirst(strtolower($other_details->getAddress->get_brgy->brgyDesc));
                }

            }

            $address = $province.', '.$city_mun.', '.$barangay;

            $transactions_ID = $other_details->transaction_id;
            $transactions_Date = Carbon::create($other_details->created_at)->format('F j, Y');

            if($other_details->getStatusCodes)
            {
                $status = $other_details->getStatusCodes->name;
                $status_class = $other_details->getStatusCodes->class;
            }

            if($other_details->getSchedule)
            {
                $scheduled_date = Carbon::parse($other_details->getSchedule->date)->format('F d, Y');
                $date_desc = $other_details->getSchedule->description;
            }


            if($other_details->status == 11 || $other_details->status == 7)
            {
                $can_print = true;
                $is_approved = true;

                $message = 'Certificate can be printed!';


            }
            else
            {
                $can_print = false;
                $is_approved = false;
            }

            if($other_details->getEmployeeInfo)
            {
                $emps_first_name = $other_details->getEmployeeInfo->firstname;
                $emps_last_name = $other_details->getEmployeeInfo->lastname;
                if($other_details->getEmployeeInfo->middlename)
                {
                    $my_mid_name   = $other_details->getEmployeeInfo->middlename;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }
                else
                {
                    $mi = '';
                }


                if($other_details->getEmployeeInfo->getAgencyEmployee->get_designation)
                {
                    $position_designation = $other_details->getEmployeeInfo->getAgencyEmployee->get_designation->userauthority;

                }elseif($other_details->getEmployeeInfo->getAgencyEmployee->get_position)
                {
                    $position_designation = $other_details->getEmployeeInfo->getAgencyEmployee->get_position->emp_position;
                }

                $approved_by = $emps_first_name.' '.$mi.' '.$emps_last_name;

            }

            $active_schoolYear = enrollment_settings::where('active', 1)->where('description', 'year')->first();
            $Semester = enrollment_settings::where('active', 1)->where('description', 'sem')->first();


            if ($Semester->key_value === '1')
            {
                $active_sem = '1st Semester';
            }
            else
            {
                $active_sem = '2nd Semester';
            }

            return view('pre_enrollees.Transaction.details',
                compact(
                    'decrypted_transactionId',
                    'agency_name',
                    'client_name',
                    'email',
                    'address',
                    'transactions_ID', 'encrypted_transactionId',
                    'transactions_Date',
                    'status', 'status_class',
                    'scheduled_date', 'date_desc',
                    'can_print', 'is_approved',
                    'approved_by', 'position_designation',
                    'active_schoolYear', 'active_sem',
                    'header', 'footer',
                ))->with('message', $message);
        }else
        {
            return redirect('/');
        }
    }

    /** ADMIN LOAD ALL TRANSACTIONS */
    public function loadAllTransactions(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $results = '';
        $search_result = '';
        $search_value  = '';
        $filtered_value  = '';
        $test  = '';
        $searchKeyword  = '';


        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = trim($filters['search']);


            $transactions_search = enrollees_appointment::where('active', 1)
                ->whereHas('getEnrolleesInfo', function ($query) use ($searchKeyword) {
                    $query->where(function ($query) use ($searchKeyword) {
                        $query->whereRaw('LOWER(pre_enrollee_id) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                            ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                            ->orWhereRaw('LOWER(midname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                            ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                    });
                })
                ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress'])
                ->orderBy('created_at', 'desc')
                ->get();

            $search_value = $this->iterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];
            if ($limit_page == 'All') {

                $transactions = enrollees_appointment::where('active', 1)
                    ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress'])
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->get();

                $results = $this->iterator($transactions);

            } else {

                $transactions = $this->Query($limit_page);
                $results = $this->iterator($transactions);

            }
        }
        else {

            $transactions = $this->Query($perPage);
            $results = $this->iterator($transactions);
        }


        // FILTER DATA BASED ON STATUS
        if (isset($filters['limitStatus'])) {
            // Perform pagination on the query
            $limit_status = $filters['limitStatus'];

            if ($limit_status == '999999') {

                $my_transactions = enrollees_appointment::where('active', 1)
                    ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress'])
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->get();

                $results = $this->iterator($my_transactions);

            } else {

                $my_transactions = enrollees_appointment::where('active', 1)->where('status', $limit_status)
                    ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress', 'getStatusCodes'])
                    ->get();
                $results = $this->iterator($my_transactions);

            }
        }
        else {

            $my_transactions = enrollees_appointment::where('active', 1)
                ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress', 'getStatusCodes'])
                ->get();
            $results = $this->iterator($my_transactions);
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
    public function Query($perPage){

     return enrollees_appointment::where('active', 1)
            ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress', 'getStatusCodes'])
//            ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
            ->paginate($perPage);

    }




    /** PRE-ENROLLEES LOAD MY TRANSACTIONS */
    public function loadMyTransactions(Request $request)
    {
        $pre_enrollees_id = auth()->guard('enrollees_guard')->user()->pre_enrollee_id;
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';


        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = trim($filters['search']);


            $transactions_search = enrollees_appointment::where('active', 1)
                ->whereHas('getEnrolleesInfo', function ($query) use ($searchKeyword) {
                    $query->where('pre_enrollee_id', 'LIKE', "%$searchKeyword%")
                        ->orWhere('firstname', 'LIKE', "%$searchKeyword%")
                        ->orWhere('midname', 'LIKE', "%$searchKeyword%")
                        ->orWhere('lastname', 'LIKE', "%$searchKeyword%");
                })
                ->orWhere('transaction_id', 'LIKE', "%$searchKeyword%")
                ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress'])
                ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                ->get();

            $search_value = $this->iterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];
            if ($limit_page == 'All') {

                $transactions = enrollees_appointment::where('enrollees_id', $pre_enrollees_id)->where('active', 1)
                    ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress'])
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->get();

                $results = $this->iterator($transactions);

            } else {

                $transactions = $this->queryMyTransactions($limit_page, $pre_enrollees_id);
                $results = $this->iterator($transactions);

            }
        }
        else {

            $transactions = $this->queryMyTransactions($perPage, $pre_enrollees_id);
            $results = $this->iterator($transactions);
        }




        // FILTER DATA BASED ON STATUS
        if (isset($filters['limitStatus'])) {
            // Perform pagination on the query
            $limit_status = $filters['limitStatus'];

            if ($limit_status == '999999') {

                $my_transactions = enrollees_appointment::where('enrollees_id', $pre_enrollees_id)->where('active', 1)
                    ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress'])
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->get();

                $results = $this->iterator($my_transactions);

            } else {

                $my_transactions = enrollees_appointment::where('enrollees_id', $pre_enrollees_id)->where('active', 1)->where('status', $limit_status)
                    ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress', 'getStatusCodes'])
                    ->get();
                $results = $this->iterator($my_transactions);

            }
        }
        else {

            $my_transactions = enrollees_appointment::where('enrollees_id', $pre_enrollees_id)->where('active', 1)
                ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress', 'getStatusCodes'])
                ->get();
            $results = $this->iterator($my_transactions);
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
    public function queryMyTransactions($perPage, $pre_enrollees_id){

        return enrollees_appointment::where('enrollees_id', $pre_enrollees_id)->where('active', 1)
            ->with(['getEnrolleesInfo', 'getScheduleData', 'getAddress', 'getStatusCodes'])
            ->paginate($perPage);

    }




    public function iterator($transactions){

        $tres = [];
        $transaction_id = '';
        $enrollees_id = '';
        $fullName = '';
        $first_name = '';
        $last_name = '';
        $mi = '';
        $address = '';
        $province = '';
        $city_mun = '';
        $barangay = '';
        $status = '';
        $status_class = '';
        $date = '';
        $date_desc = '';
        $school = 'Davao del Sur State College - Main Campus';

        foreach ($transactions as $data)
        {

            $appointment_id = $data->id;
            $schedule_id = $data->schedule_id;
            $encrypted_appointment_id = \Crypt::encrypt($data->id);
            $transaction_id = $data->transaction_id;

            if($data->getEnrolleesInfo)
            {
                $enrollees_id = $data->getEnrolleesInfo->pre_enrollee_id;
                $first_name = strtoupper($data->getEnrolleesInfo->firstname);
                $last_name = strtoupper($data->getEnrolleesInfo->lastname);

                if($data->getEnrolleesInfo->midname)
                {
                    $my_mid_name   = $data->getEnrolleesInfo->midname;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }else
                {
                    $mi = '';
                }

                $fullName = $first_name.' '.$mi.' '.$last_name;

            }

            if($data->getAddress)
            {
                if($data->getAddress->get_province)
                {
                    $province = ucfirst(strtolower($data->getAddress->get_province->provDesc));
                }else
                {
                    $province = '';
                }
                if($data->getAddress->get_city_mun)
                {
                    $city_mun = ucfirst(strtolower($data->getAddress->get_city_mun->citymunDesc));
                }else
                {
                    $city_mun = '';
                }
                if($data->getAddress->get_brgy)
                {
                    $barangay = ucfirst(strtolower($data->getAddress->get_brgy->brgyDesc));
                }else
                {
                    $barangay = '';
                }

            }
            else
            {
                $province = 'N/A';
                $city_mun = 'N/A';
                $barangay = 'N/A';
            }

            if($data->getStatusCodes)
            {
                $status = $data->getStatusCodes->name;
                $status_class = $data->getStatusCodes->class;
            }

            if($data->getSchedule)
            {
                $date = Carbon::parse($data->getSchedule->date)->format('F d, Y');
                $date_desc = $data->getSchedule->description;
                $slots = $data->getSchedule->slots;
            }


            $td = [

                "encrypted_appointment_id" => $encrypted_appointment_id,
                "appointment_id" => $appointment_id,
                "transaction_id" => $transaction_id,
                "enrollees_id" => $enrollees_id,
                "schedule_id" => $schedule_id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "mi" => $mi,
                "fullName" => $fullName,
                "province" => $province,
                "city_mun" => $city_mun,
                "barangay" => $barangay,
                "status" => $status,
                "status_class" => $status_class,
                "date" => $date,
                "date_desc" => $date_desc,
                "school" => $school,

            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }



    public function transactionPrintDetails($transactionId)
    {
        $encrypted_transactionId = $transactionId;
        $decrypted_transactionId = \Crypt::decrypt($encrypted_transactionId);

        $transaction_details = enrollees_appointment::find($decrypted_transactionId);
        $other_details = enrollees_appointment::where('id', $decrypted_transactionId)->where('active', 1)->with(['getEnrolleesInfo', 'getEmployeeInfo', 'getScheduleData', 'getAddress', 'getStatusCodes'])->first();

        $agency_name = default_setting::where('active', 1)->where('key', 'agency_name')->first();
        $agency_header = default_setting::where('active', 1)->where('key', 'image_header')->first();
        $agency_footer = default_setting::where('active', 1)->where('key', 'image_footer')->first();

        $header = url('') . "/uploads/settings/" . $agency_header->image;
        $footer = url('') . "/uploads/settings/" . $agency_footer->image;

        $fullName = 'No Data';
        $email = 'No Data';
        $address = 'No Data';
        $transactions_ID = 'No Data';
        $transactions_Date = 'No Data';
        $client_name = 'No Data';
        $province = '';
        $city_mun = '';
        $barangay = '';
        $status = '';
        $status_class = '';
        $scheduled_date = '';
        $date_desc = '';
        $approved_by = 'No Data';
        $emps_first_name = 'No Data';
        $emps_last_name = 'No Data';
        $position_designation = 'No Data';
        $active_schoolYear = 'No Data';
        $active_sem = 'No Data';


        $now = date('m/d/Y g:ia');

        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('F j, Y - g:i A');

        /**
         *  CLIENT DETAILS
         */

        if($other_details->getEnrolleesInfo)
        {
            $enrollees_id = $other_details->getEnrolleesInfo->pre_enrollee_id;
            $first_name = strtoupper($other_details->getEnrolleesInfo->firstname);
            $last_name = strtoupper($other_details->getEnrolleesInfo->lastname);

            if($other_details->getEnrolleesInfo->midname)
            {
                $my_mid_name   = $other_details->getEnrolleesInfo->midname;
                $my_mid_name_new = substr($my_mid_name, 0, 1);

                $mi = $my_mid_name_new.'.';

            }else
            {
                $mi = '';
            }

            $fullName = $first_name.' '.$mi.' '.$last_name;
            $email = $other_details->getEnrolleesInfo->email;
        }

        $client_name = $fullName;

        if($other_details->getAddress)
        {
            if($other_details->getAddress->get_province)
            {
                $province = ucfirst(strtolower($other_details->getAddress->get_province->provDesc));
            }
            if($other_details->getAddress->get_city_mun)
            {
                $city_mun = ucfirst(strtolower($other_details->getAddress->get_city_mun->citymunDesc));
            }
            if($other_details->getAddress->get_brgy)
            {
                $barangay = ucfirst(strtolower($other_details->getAddress->get_brgy->brgyDesc));
            }

        }

        $address = $province.', '.$city_mun.', '.$barangay;

        $transactions_ID = $other_details->transaction_id;
        $transactions_Date = Carbon::create($other_details->created_at)->format('F j, Y');

        if($other_details->getStatusCodes)
        {
            $status = $other_details->getStatusCodes->name;
            $status_class = $other_details->getStatusCodes->class;
        }

        if($other_details->getSchedule)
        {
            $scheduled_date = Carbon::parse($other_details->getSchedule->date)->format('F d, Y');
            $date_desc = $other_details->getSchedule->description;
        }


        if($other_details->status == 11 || $other_details->status == 7)
        {
            $can_print = true;
            $is_approved = true;

        }
        else
        {
            $can_print = false;
            $is_approved = false;
        }

        if($other_details->getEmployeeInfo)
        {
            $emps_first_name = $other_details->getEmployeeInfo->firstname;
            $emps_last_name = $other_details->getEmployeeInfo->lastname;
            if($other_details->getEmployeeInfo->middlename)
            {
                $my_mid_name   = $other_details->getEmployeeInfo->middlename;
                $my_mid_name_new = substr($my_mid_name, 0, 1);

                $mi = $my_mid_name_new.'.';

            }
            else
            {
                $mi = '';
            }


            if($other_details->getEmployeeInfo->getAgencyEmployee->get_designation)
            {
                $position_designation = $other_details->getEmployeeInfo->getAgencyEmployee->get_designation->userauthority;

            }elseif($other_details->getEmployeeInfo->getAgencyEmployee->get_position)
            {
                $position_designation = $other_details->getEmployeeInfo->getAgencyEmployee->get_position->emp_position;
            }

            $approved_by = $emps_first_name.' '.$mi.' '.$emps_last_name;

            $approving_email = 'admission@dssc.edu.ph';
        }else
        {
            $approving_email = 'No Data';
        }

        $active_schoolYear = enrollment_settings::where('active', 1)->where('description', 'year')->first();
        $Semester = enrollment_settings::where('active', 1)->where('description', 'sem')->first();


        if ($Semester->key_value === '1')
        {
            $active_sem = '1st Semester';
        }
        else
        {
            $active_sem = '2nd Semester';
        }


        if($other_details->status == '1')
        {
            $status_class = 'color: #d75a00';
        }
        else
        {
//            $status_class = 'color: #0a58ca'; //PRIMARY
            $status_class = 'color: #00a216'; //SUCCESS
        }

        $filename = 'Admission Receipt';



        $pdf = PDF::loadView('pre_enrollees.Transaction.Print.Print_Details',
            compact(
                'filename',
                'agency_footer', 'agency_header',
                'agency_name',
                'client_name',
                'email',
                'address',
                'transactions_ID',
                'transactions_Date',
                'status', 'status_class',
                'scheduled_date', 'date_desc',
                'can_print', 'is_approved',
                'approved_by', 'position_designation', 'approving_email',
                'active_schoolYear', 'active_sem',
                'header', 'footer', 'current_date',
            ))->setPaper('A4', 'portrait');


        return $pdf->stream($filename . '.pdf');
    }
}
