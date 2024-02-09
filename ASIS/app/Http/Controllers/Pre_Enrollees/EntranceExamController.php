<?php

namespace App\Http\Controllers\Pre_Enrollees;

use App\Http\Controllers\Controller;
use App\Mail\NotifyEmail;
use App\Models\ASIS_Models\enrollment\enrollment_schedule;
use App\Models\ASIS_Models\pre_enrollees\enrollees_address;
use App\Models\ASIS_Models\pre_enrollees\enrollees_appointment;
use App\Models\ASIS_Models\pre_enrollees\entrance_exam_rated_list;
use App\Models\ASIS_Models\pre_enrollees\entrance_examinees;
use App\Models\ASIS_Models\pre_enrollees\pre_enrollees;
use App\Models\ASIS_Models\system\default_setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mail;

class EntranceExamController extends Controller
{
    /** STATUS CODES:
     *
     *  7   -    COMPLETED
     *  11  -    APPROVED
     *  18  -    RATED
     *  22  -   FINAL LISTED
     *
     */


    /** ADMIN LOAD EXAMINEES */
    public function entranceExamineesList()
    {
        return view('pre_enrollees.Entrance_Exam.list');
    }
    public function loadExamineesToday(Request $request)
    {

        /** STATUS CODES:
         *
         *  7   -    COMPLETED
         *  11  -    APPROVED
         *  18  -    RATED
         *
         */

        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';
        $limit_page  = '';

        $currentDate = Carbon::now();
        $date_today = $currentDate->format('Y-m-d');

        // Search filter
        if (isset($filters['search'])) {

            $searchKeyword = trim($filters['search']);
            $page_limit = trim($filters['page_number']);

            if(isset($filters['filterDate']))
            {
                $filter_date = $filters['filterDate'];

                $transactions_search = entrance_examinees::where('active', 1)
                    ->whereHas('getEnrolleesInfo', function ($query) use ($searchKeyword) {
                        $query->where(function ($query) use ($searchKeyword) {
                            $query->whereRaw('LOWER(pre_enrollee_id) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(midname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                        });
                    })
                    ->whereHas('getEnrollmentSchedule', function ($query) use ($filter_date) {
                        $query->where(function ($query) use ($filter_date) {
                            $query->whereRaw('date LIKE ?', ["%".strtolower($filter_date)."%"]);
                        });
                    })
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->paginate($page_limit);

            }else
            {
                $transactions_search = entrance_examinees::where('active', 1)
                    ->whereHas('getEnrolleesInfo', function ($query) use ($searchKeyword) {
                        $query->where(function ($query) use ($searchKeyword) {
                            $query->whereRaw('LOWER(pre_enrollee_id) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(midname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                        });
                    })
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->paginate($page_limit);
            }

            $search_value = $this->iterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === '999999') {

                $transactions = entrance_examinees::where('active', 1)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->paginate(999999);

                $results = $this->iterator($transactions);

            } else {

                $transactions = $this->Query($limit_page, $date_today);
                $results = $this->iterator($transactions);

            }
        }
        else {

            $transactions = $this->Query($perPage, $date_today);
            $results = $this->iterator($transactions);
        }


        // FILTER DATA BASED ON STATUS
        if (isset($filters['limitStatus'])) {
            // Perform pagination on the query
            $limit_status = $filters['limitStatus'];

            if ($limit_status == '999999') {

                $my_transactions = enrollees_appointment::where('active', 1)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $results = $this->iterator($my_transactions);

            } else {

                $my_transactions = entrance_examinees::where('active', 1)
                    ->where('status', $limit_status)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $results = $this->iterator($my_transactions);

            }
        }



        // FILTER DATA BASED ON DATE
        if (isset($filters['filterDate'])) {

            // Perform pagination on the query
            $limit_date = $filters['filterDate'];
            $page_limit = trim($filters['page_number']);

            $transactions = entrance_examinees::where('active', 1)
                ->whereHas('getEnrollmentSchedule', function ($query) use ($limit_date) {
                    $query->where(function ($query) use ($limit_date) {
                        $query->whereRaw('date LIKE ?', ["%".strtolower($limit_date)."%"]);
                    });
                })
                ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                ->orderBy('created_at', 'desc')
                ->paginate($page_limit);


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
    public function Query($perPage, $date_today){

        return entrance_examinees::where('active', 1)
                ->whereHas('getEnrollmentSchedule', function ($query) use ($date_today) {
                $query->where(function ($query) use ($date_today) {
                    $query->whereRaw('date LIKE ?', ["%".strtolower($date_today)."%"]);
                });
            })
            ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

    }
    public function iterator($transactions): array
    {

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

            $exam_id = $data->id;
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
                $status_id = $data->getStatusCodes->id;
                $status_class = $data->getStatusCodes->class;
            }

            if($data->getSchedule)
            {
                $date = Carbon::parse($data->getSchedule->date)->format('F d, Y');
                $date_desc = $data->getSchedule->description;
            }

            if($data->exam_result)
            {
                $exam_result = $data->exam_result;
            }else
            {
                $exam_result = 0;
            }

            if($data->stanine)
            {
                $stanine = $data->stanine;
            }else
            {
                $stanine = 0;
            }

            $td = [

                "encrypted_appointment_id" => $encrypted_appointment_id,
                "exam_id" => $exam_id,
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
                "status_id" => $status_id,
                "status" => $status,
                "status_class" => $status_class,
                "date" => $date,
                "date_desc" => $date_desc,
                "school" => $school,
                "stanine" => $stanine,
                "exam_result" => $exam_result,

            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }
    public function updateExaminationStatus(Request $request)
    {
        $exam_id = trim($request->exam_id);
        $status_code = trim($request->status_code);

        entrance_examinees::where('id', $exam_id)->update([

            'status' => $status_code,

        ]);

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => -1,
            'message' => 'Examination Status Updated Successfully!',
        ), JSON_THROW_ON_ERROR);
    }
    public function updateStanineExamScore(Request $request)
    {

        $examinee_id = trim($request->examinee_id);
        $stanine_score = trim($request->stanine_score);
        $exam_result = trim($request->exam_result);

        entrance_examinees::where('id', $examinee_id)->update([

            'status' => 7,  /**     COMPLETED   */
            'stanine' => $stanine_score,
            'exam_result' => $exam_result,
            'action' => 18, /**     RATED   */

        ]);

        $entrance_examinees_data = entrance_examinees::where('id', $examinee_id)->first();

        entrance_exam_rated_list::updateOrCreate(
            [
                'examinees_id'=> $examinee_id,
                'enrollees_id'     => trim($entrance_examinees_data->enrollees_id),
            ],

            [
                'examinees_id'=> $examinee_id,
                'enrollees_id'     => trim($entrance_examinees_data->enrollees_id),
                'status'        => 1,
                'active'        => 1,
            ]
        );

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => -1,
            'message' => 'Stanine Updated Successfully!',
        ), JSON_THROW_ON_ERROR);
    }


    /** ADMIN RATED LIST */
    public function entranceExamineesRatedList()
    {
        return view('pre_enrollees.Entrance_Exam.rated_list');
    }
    public function loadRatedEnrollees(Request $request)
    {

        /** STATUS CODES:
         *
         *  7   -    COMPLETED
         *  11  -    APPROVED
         *  18  -    RATED
         *
         */

        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';
        $limit_page  = '';

        $currentDate = Carbon::now();
        $date_today = $currentDate->format('Y-m-d');

        // Search filter
        if (isset($filters['search'])) {

            $searchKeyword = trim($filters['search']);
            $page_limit = trim($filters['page_number']);

            if(isset($filters['filterDate']))
            {
                $filter_date = $filters['filterDate'];

                $transactions_search = entrance_examinees::where('active', 1)
                    ->whereHas('getEnrolleesInfo', function ($query) use ($searchKeyword) {
                        $query->where(function ($query) use ($searchKeyword) {
                            $query->whereRaw('LOWER(pre_enrollee_id) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(midname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                        });
                    })
                    ->whereHas('getEnrollmentSchedule', function ($query) use ($filter_date) {
                        $query->where(function ($query) use ($filter_date) {
                            $query->whereRaw('date LIKE ?', ["%".strtolower($filter_date)."%"]);
                        });
                    })
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->paginate($page_limit);

            }
            else
            {
                $transactions_search = entrance_examinees::where('active', 1)
                    ->whereHas('getEnrolleesInfo', function ($query) use ($searchKeyword) {
                        $query->where(function ($query) use ($searchKeyword) {
                            $query->whereRaw('LOWER(pre_enrollee_id) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(midname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                        });
                    })
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->paginate($page_limit);
            }

            $search_value = $this->ratedEnrolleesIterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === '999999') {

                $transactions = entrance_examinees::where('active', 1)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->paginate(999999);

                $results = $this->ratedEnrolleesIterator($transactions);

            } else {

                $transactions = $this->queryRatedEnrollees($limit_page, $date_today);
                $results = $this->ratedEnrolleesIterator($transactions);

            }
        }
        else {

            $transactions = $this->queryRatedEnrollees($perPage, $date_today);
            $results = $this->ratedEnrolleesIterator($transactions);
        }


        // FILTER DATA BASED ON STATUS
        if (isset($filters['limitStatus'])) {
            // Perform pagination on the query
            $limit_status = $filters['limitStatus'];

            if ($limit_status == '999999') {

                $my_transactions = enrollees_appointment::where('active', 1)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $results = $this->ratedEnrolleesIterator($my_transactions);

            } else {

                $my_transactions = entrance_examinees::where('active', 1)
                    ->where('status', $limit_status)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $results = $this->ratedEnrolleesIterator($my_transactions);

            }
        }



        // FILTER DATA BASED ON DATE
        if (isset($filters['filterDate'])) {

            // Perform pagination on the query
            $limit_date = $filters['filterDate'];
            $page_limit = trim($filters['page_number']);

            $transactions = entrance_exam_rated_list::where('active', 1)
                ->whereHas('getExamineesData.getEnrollmentSchedule', function ($query) use ($limit_date) {
                    $query->where(function ($query) use ($limit_date) {
                        $query->whereRaw('date LIKE ?', ["%".strtolower($limit_date)."%"]);
                    });
                })
                ->with(['getExamineesData.getEnrolleesInfo', 'getExamineesData.getEnrollmentSchedule', 'getExamineesData.getAddress'])
                ->orderBy('created_at', 'desc')
                ->paginate($page_limit);


            $results = $this->ratedEnrolleesIterator($transactions);
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
    public function queryRatedEnrollees($perPage, $date_today){

        /** STATUS CODES:
         *
         *  7   -    COMPLETED
         *  11  -    APPROVED
         *  18  -    RATED
         *
         */


        return entrance_exam_rated_list::where('active', 1)->where('status', 1)
            ->with(['getExamineesData.getEnrolleesInfo', 'getExamineesData.getEnrollmentSchedule', 'getExamineesData.getAddress'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

    }
    public function ratedEnrolleesIterator($transactions): array
    {

        $tres = [];
        $enrollees_id = '';
        $fullName = '';
        $first_name = '';
        $last_name = '';
        $mi = '';
        $status = '';
        $status_class = '';
        $date = '';
        $date_desc = '';

        $school = 'Davao del Sur State College - Main Campus';

        foreach ($transactions as $data)
        {

            $ratedList_id = $data->id;
            $exam_id = $data->id;
            $schedule_id = $data->schedule_id;
            $encrypted_appointment_id = \Crypt::encrypt($data->id);
            $transaction_id = $data->getExamineesData->transaction_id;

            if($data->getExamineesData->getEnrolleesInfo)
            {
                $enrollees_id = $data->getExamineesData->getEnrolleesInfo->pre_enrollee_id;
                $first_name = strtoupper($data->getExamineesData->getEnrolleesInfo->firstname);
                $last_name = strtoupper($data->getExamineesData->getEnrolleesInfo->lastname);

                if($data->getExamineesData->getEnrolleesInfo->midname)
                {
                    $my_mid_name   = $data->getExamineesData->getEnrolleesInfo->midname;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }else
                {
                    $mi = '';
                }

                $fullName = $first_name.' '.$mi.' '.$last_name;

            }

            if($data->getExamineesData->getAddress)
            {
                if($data->getExamineesData->getAddress->get_province)
                {
                    $province = ucfirst(strtolower($data->getExamineesData->getAddress->get_province->provDesc));
                }else
                {
                    $province = '';
                }
                if($data->getExamineesData->getAddress->get_city_mun)
                {
                    $city_mun = ucfirst(strtolower($data->getExamineesData->getAddress->get_city_mun->citymunDesc));
                }else
                {
                    $city_mun = '';
                }
                if($data->getExamineesData->getAddress->get_brgy)
                {
                    $barangay = ucfirst(strtolower($data->getExamineesData->getAddress->get_brgy->brgyDesc));
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
                $status_id = $data->getStatusCodes->id;
                $status_class = $data->getStatusCodes->class;
            }

            if($data->getExamineesData->getSchedule)
            {
                $date = Carbon::parse($data->getExamineesData->getSchedule->date)->format('F d, Y');
                $date_desc = $data->getExamineesData->getSchedule->description;
            }

            if($data->getExamineesData->exam_result)
            {
                $exam_result = $data->getExamineesData->exam_result;
            }
            else
            {
                $exam_result = 0;
            }

            if($data->getExamineesData->stanine)
            {
                $stanine = $data->getExamineesData->stanine;
            }
            else
            {
                $stanine = 0;
            }


            $result = GLOBAL_REMARKS_GENERATOR($stanine);

            $remarks = $result['remark'];
            $remarks_class = $result['remark_class'];

            $td = [

                "encrypted_appointment_id" => $encrypted_appointment_id,
                "ratedList_id" => $ratedList_id,
                "exam_id" => $exam_id,
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
                "status_id" => $status_id,
                "status" => $status,
                "status_class" => $status_class,
                "date" => $date,
                "date_desc" => $date_desc,
                "school" => $school,
                "stanine" => $stanine,
                "exam_result" => $exam_result,
                "remarks" => $remarks,
                "remarks_class" => $remarks_class,

            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }
    public function updateExamRatedListStatus(Request $request)
    {

        $ratedlist_id = trim($request->ratedlist_id);

        $pre_enrollees_id = entrance_exam_rated_list::where('id', $ratedlist_id)->first()->enrollees_id;
        if($pre_enrollees_id)
        {
            $email_to = pre_enrollees::where('pre_enrollee_id', $pre_enrollees_id)->first()->email;
            $latName = pre_enrollees::where('pre_enrollee_id', $pre_enrollees_id)->first()->lastname;

            $subject = 'Congratulations! You have Passed the Entrance Examination!';
            $content = 'Dear Mr./Ms. '. $latName .'! We are thrilled to share the fantastic news with you – you have successfully passed the entrance exam! On behalf of the entire DSSC community, we extend our heartfelt congratulations on this remarkable achievement. Your dedication, hard work, and intellectual prowess have truly set you apart, and we are confident that you will contribute significantly to our academic community. This accomplishment is a testament to your commitment to excellence, and we are excited about the prospect of having someone of your caliber join our esteemed institution.Best wishes for a successful academic journey ahead!';

            $closing = 'Davao del Sur State College - ASIS';
            $agency_logo = '';
            $path = '';


            /** SEND EMAIL TO THE PRE-ENROLLEES */
            Mail::to($email_to)->queue(new NotifyEmail($subject,$content,$closing,$agency_logo,$path));


            entrance_exam_rated_list::where('id', $ratedlist_id)->update([

                'status' => 22, /** 22  -   FINAL LISTED    */

            ]);
        }


        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => -1,
            'message' => 'Rated Successfully!',
        ), JSON_THROW_ON_ERROR);
    }


    /** ADMIN SHORT LISTED */
    public function entranceExamineesShortList()
    {
        return view('pre_enrollees.Entrance_Exam.short_listed');
    }
    public function loadShortListedEnrollees(Request $request)
    {

        /** STATUS CODES:
         *
         *  7   -    COMPLETED
         *  11  -    APPROVED
         *  18  -    RATED
         *  22  -   FINAL LISTED
         *
         */

        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';
        $limit_page  = '';

        $currentDate = Carbon::now();
        $date_today = $currentDate->format('Y-m-d');

        // Search filter
        if (isset($filters['search'])) {

            $searchKeyword = trim($filters['search']);
            $page_limit = trim($filters['page_number']);

            if(isset($filters['filterDate']))
            {
                $filter_date = $filters['filterDate'];

                $transactions_search = entrance_examinees::where('active', 1)
                    ->whereHas('getEnrolleesInfo', function ($query) use ($searchKeyword) {
                        $query->where(function ($query) use ($searchKeyword) {
                            $query->whereRaw('LOWER(pre_enrollee_id) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(midname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                        });
                    })
                    ->whereHas('getEnrollmentSchedule', function ($query) use ($filter_date) {
                        $query->where(function ($query) use ($filter_date) {
                            $query->whereRaw('date LIKE ?', ["%".strtolower($filter_date)."%"]);
                        });
                    })
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->paginate($page_limit);

            }
            else
            {
                $transactions_search = entrance_examinees::where('active', 1)
                    ->whereHas('getEnrolleesInfo', function ($query) use ($searchKeyword) {
                        $query->where(function ($query) use ($searchKeyword) {
                            $query->whereRaw('LOWER(pre_enrollee_id) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(firstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(midname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                                ->orWhereRaw('LOWER(lastname) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                        });
                    })
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->paginate($page_limit);
            }

            $search_value = $this->ratedEnrolleesIterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === '999999') {

                $transactions = entrance_examinees::where('active', 1)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                    ->paginate(999999);

                $results = $this->ratedEnrolleesIterator($transactions);

            } else {

                $transactions = $this->queryRatedEnrollees($limit_page, $date_today);
                $results = $this->ratedEnrolleesIterator($transactions);

            }
        }
        else {

            $transactions = $this->queryShortListedEnrollees($perPage, $date_today);
            $results = $this->shotListedEnrolleesIterator($transactions);
        }


        // FILTER DATA BASED ON STATUS
        if (isset($filters['limitStatus'])) {
            // Perform pagination on the query
            $limit_status = $filters['limitStatus'];

            if ($limit_status == '999999') {

                $my_transactions = enrollees_appointment::where('active', 1)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $results = $this->ratedEnrolleesIterator($my_transactions);

            } else {

                $my_transactions = entrance_examinees::where('active', 1)
                    ->where('status', $limit_status)
                    ->with(['getEnrolleesInfo', 'getEnrollmentSchedule', 'getAddress'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $results = $this->ratedEnrolleesIterator($my_transactions);

            }
        }



        // FILTER DATA BASED ON DATE
        if (isset($filters['filterDate'])) {

            // Perform pagination on the query
            $limit_date = $filters['filterDate'];
            $page_limit = trim($filters['page_number']);

            $transactions = entrance_exam_rated_list::where('active', 1)->where('status', 22)
                ->whereHas('getExamineesData.getEnrollmentSchedule', function ($query) use ($limit_date) {
                    $query->where(function ($query) use ($limit_date) {
                        $query->whereRaw('date LIKE ?', ["%".strtolower($limit_date)."%"]);
                    });
                })
                ->with(['getExamineesData.getEnrolleesInfo', 'getExamineesData.getEnrollmentSchedule', 'getExamineesData.getAddress'])
                ->orderBy('created_at', 'desc')
                ->paginate($page_limit);


            $results = $this->ratedEnrolleesIterator($transactions);
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
    public function queryShortListedEnrollees($perPage, $date_today){

        /** STATUS CODES:
         *
         *  7   -    COMPLETED
         *  11  -    APPROVED
         *  18  -    RATED
         *
         */


        return entrance_exam_rated_list::where('active', 1)->where('status', 22)
            ->with(['getExamineesData.getEnrolleesInfo', 'getExamineesData.getEnrollmentSchedule', 'getExamineesData.getAddress'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

    }
    public function shotListedEnrolleesIterator($transactions): array
    {

        $tres = [];
        $enrollees_id = '';
        $fullName = '';
        $first_name = '';
        $last_name = '';
        $mi = '';
        $status = '';
        $status_class = '';
        $date = '';
        $date_desc = '';

        $school = 'Davao del Sur State College - Main Campus';

        foreach ($transactions as $data)
        {

            $ratedList_id = $data->id;
            $exam_id = $data->id;
            $schedule_id = $data->schedule_id;
            $encrypted_appointment_id = \Crypt::encrypt($data->id);
            $transaction_id = $data->getExamineesData->transaction_id;

            if($data->getExamineesData->getEnrolleesInfo)
            {
                $enrollees_id = $data->getExamineesData->getEnrolleesInfo->pre_enrollee_id;
                $first_name = strtoupper($data->getExamineesData->getEnrolleesInfo->firstname);
                $last_name = strtoupper($data->getExamineesData->getEnrolleesInfo->lastname);

                if($data->getExamineesData->getEnrolleesInfo->midname)
                {
                    $my_mid_name   = $data->getExamineesData->getEnrolleesInfo->midname;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }else
                {
                    $mi = '';
                }

                $fullName = $first_name.' '.$mi.' '.$last_name;

            }

            if($data->getExamineesData->getAddress)
            {
                if($data->getExamineesData->getAddress->get_province)
                {
                    $province = ucfirst(strtolower($data->getExamineesData->getAddress->get_province->provDesc));
                }else
                {
                    $province = '';
                }
                if($data->getExamineesData->getAddress->get_city_mun)
                {
                    $city_mun = ucfirst(strtolower($data->getExamineesData->getAddress->get_city_mun->citymunDesc));
                }else
                {
                    $city_mun = '';
                }
                if($data->getExamineesData->getAddress->get_brgy)
                {
                    $barangay = ucfirst(strtolower($data->getExamineesData->getAddress->get_brgy->brgyDesc));
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
                $status_id = $data->getStatusCodes->id;
                $status_class = $data->getStatusCodes->class;
            }

            if($data->getExamineesData->getSchedule)
            {
                $date = Carbon::parse($data->getExamineesData->getSchedule->date)->format('F d, Y');
                $date_desc = $data->getExamineesData->getSchedule->description;
            }

            if($data->getExamineesData->exam_result)
            {
                $exam_result = $data->getExamineesData->exam_result;
            }
            else
            {
                $exam_result = 0;
            }

            if($data->getExamineesData->stanine)
            {
                $stanine = $data->getExamineesData->stanine;
            }
            else
            {
                $stanine = 0;
            }


            $result = GLOBAL_REMARKS_GENERATOR($stanine);

            $remarks = $result['remark'];
            $remarks_class = $result['remark_class'];

            $td = [

                "encrypted_appointment_id" => $encrypted_appointment_id,
                "ratedList_id" => $ratedList_id,
                "exam_id" => $exam_id,
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
                "status_id" => $status_id,
                "status" => $status,
                "status_class" => $status_class,
                "date" => $date,
                "date_desc" => $date_desc,
                "school" => $school,
                "stanine" => $stanine,
                "exam_result" => $exam_result,
                "remarks" => $remarks,
                "remarks_class" => $remarks_class,

            ];

            $tres[count($tres)] = $td;

        }
        return $tres;

    }





    public function myEntranceExamResult()
    {

        $enrollees_id = auth()->guard('enrollees_guard')->user()->pre_enrollee_id;

        $agency_name = default_setting::where('active', 1)->where('key', 'agency_name')->first();
        $agency_header = default_setting::where('active', 1)->where('key', 'image_header')->first();
        $agency_footer = default_setting::where('active', 1)->where('key', 'image_footer')->first();

        $header = url('') . "/uploads/settings/" . $agency_header->image;
        $footer = url('') . "/uploads/settings/" . $agency_footer->image;

        $pre_enrollees_data = pre_enrollees::where('pre_enrollee_id', $enrollees_id)->first();
        $pre_enrollees_address = enrollees_address::where('enrollees_id', $enrollees_id)->where('type', 'PERMANENT')->first();
        $entrance_exam = entrance_examinees::where('enrollees_id', $enrollees_id)->first();

        if($pre_enrollees_data)
        {
            $firstName = $pre_enrollees_data->firstname;
            $middleName = $pre_enrollees_data->midname;
            $lastName = $pre_enrollees_data->lastname;
            $extension = $pre_enrollees_data->extension;
            $email = $pre_enrollees_data->email;

        }
        else
        {
            $firstName  = '';
            $middleName = '';
            $lastName   = '';
            $extension  = '';
            $email      = '';
        }


        $province = '';
        $city_mun = '';
        $barangay = '';

        if($pre_enrollees_address)
        {
            if($pre_enrollees_address->get_province)
            {
                $province = ucfirst(strtolower($pre_enrollees_address->get_province->provDesc));
            }
            if($pre_enrollees_address->get_city_mun)
            {
                $city_mun = ucfirst(strtolower($pre_enrollees_address->get_city_mun->citymunDesc));
            }
            if($pre_enrollees_address->get_brgy)
            {
                $barangay = ucfirst(strtolower($pre_enrollees_address->get_brgy->brgyDesc));
            }

        }

        $address = $province.', '.$city_mun.', '.$barangay;

        $transactions_ID = $entrance_exam->transaction_id;
        $transactions_Date = Carbon::create($entrance_exam->created_at)->format('F j, Y');

        $mi = GLOBAL_MIDDLE_NAME_GENERATOR($middleName);
        $client_name = $firstName.' '.$mi.' '.$lastName;

        $active_schoolYear = $entrance_exam->year;
        $active_sem = $entrance_exam->sem;

//        if($other_details->getSchedule)
//        {
//            $scheduled_date = Carbon::parse($other_details->getSchedule->date)->format('F d, Y');
//            $date_desc = $other_details->getSchedule->description;
//        }

        return view('pre_enrollees.Entrance_Exam.my_result',
            compact(
                'agency_name','header',
                'footer', 'agency_header', 'agency_footer',
                'client_name', 'address','transactions_ID',
                'email','transactions_Date', 'active_schoolYear', 'active_sem',
            )
        );
    }
}
