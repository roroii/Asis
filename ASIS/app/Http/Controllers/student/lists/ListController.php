<?php

namespace App\Http\Controllers\student\lists;

use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\posgres\portal\srgb\sem_student;
use App\Models\ASIS_Models\posgres\portal\srgb\student;
use App\Models\ASIS_Models\pre_enrollees\enrollees_appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware(['auth', 'is_admin']);
//    }


    public function student_list()
    {

//        $studentsArray = [];
//
//        student::has('check_sem_student')->orderBy('studid', 'desc')->chunk(500, function ($students) use (&$studentsArray) {
//
//            foreach ($students as $student) {
//
//                $studentsArray[] = [
//                    'studid'            => $student->studid,
//                    'studfullname2'     => $student->studfullname2,
//                    'studemail'         => $student->studemail,
//                    'studcontactno'     => $student->studcontactno,
//                    'studpaddr'         => $student->studpaddr,
//                ];
//
//            }
//
//        });
//
//        return view('student.list.list', compact('studentsArray'));

        return view('student.list.list');

    }


    public function loadStudents(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');

        // Apply filters to the query based on the received parameters
        $query = student::query();

        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = $filters['search'];
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('studid', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('studlastname', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('studfirstname', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('studemail', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('studfullname2', 'LIKE', '%' . $searchKeyword . '%');
            });
        }

        $tres = [];


        // You can add more filter conditions based on your requirements
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];
            if ($limit_page == 'All') {
                $enrollments = $query->has('check_sem_student')->orderBy('studid', 'desc')->get();

                foreach ($enrollments as $data)
                {
                    $td = [

                        "student_id" => $data->studid,
                        "firstname" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studfirstname),
                        "lastname" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studlastname),
                        "middlename" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studmidname),
                        "email" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studemail),
                        "address" => $data->studpermaddr,
                        "contact" => $data->studcontactno,

                    ];

                    $tres[count($tres)] = $td;
                }


            } else {
                $enrollments = $query->has('check_sem_student')->orderBy('studid', 'desc')->paginate($limit_page);
                foreach ($enrollments as $data)
                {
                    $td = [

                        "student_id" => $data->studid,
                        "firstname" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studfirstname),
                        "lastname" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studlastname),
                        "middlename" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studmidname),
                        "email" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studemail),
                        "address" => $data->studpermaddr,
                        "contact" => $data->studcontactno,

                    ];

                    $tres[count($tres)] = $td;
                }
            }
        } else {
            $enrollments = $query->has('check_sem_student')->orderBy('studid', 'desc')->paginate($perPage);
            foreach ($enrollments as $data)
            {
                $td = [

                    "student_id" => $data->studid,
                    "firstname" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studfirstname),
                    "lastname" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studlastname),
                    "middlename" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studmidname),
                    "email" => GLOBAL_PostGressSQL_HEX_CONVERTER($data->studemail),
                    "address" => $data->studpermaddr,
                    "contact" => $data->studcontactno,

                ];

                $tres[count($tres)] = $td;
            }
        }


        // Calculate the summary message
        $startEntry = ($enrollments->currentPage() - 1) * $enrollments->perPage() + 1;
        $endEntry = min($startEntry + $enrollments->count() - 1, $enrollments->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$enrollments->total()} entries";

        return response()->json([
            'data' => $tres,
            'current_page' => $enrollments->currentPage(),
            'last_page' => $enrollments->lastPage(),
            'per_page' => $enrollments->perPage(),
            'total' => $enrollments->total(),
            'summary' => $summaryMessage,
        ]); // Return the enrollments as a JSON response
    }

    /**
     * @throws \JsonException
     */
    public function loadESMS_Students(Request $request)
    {

        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';


        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = trim($filters['search']);


            $transactions_search = student::has('check_sem_student')
                ->where(function ($query) use ($searchKeyword) {
                    $query->whereRaw('LOWER(studid) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(studlastname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(studfirstname) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(studemail) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(studfullname2) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                })
                ->orderBy('studid', 'desc')
                ->get();

            $search_value = $this->iterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];
            if ($limit_page == '999999') {

                $transactions = student::get();

                $results = $this->iterator($transactions);

            }
            else {


                $transactions = $this->queryESMS_Students($limit_page);
                $results = $this->iterator($transactions);

            }
        }
        else {

            $transactions = $this->queryESMS_Students($perPage);
            $results = $this->iterator($transactions);
        }



        // Calculate the summary message
        $startEntry = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
        $endEntry = min($startEntry + $transactions->count() - 1, $transactions->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$transactions->total()} entries";


        $responseData = [
            'students_data' => $results,
            'search_query' => $search_value,
            'data' => $transactions->items(),
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total(),
            'summary' => $summaryMessage,
        ];

        return json_encode($responseData, JSON_THROW_ON_ERROR);


    }

    public function queryESMS_Students($perPage){

        return student::has('check_sem_student')->orderBy('studid', 'desc')
            ->select('studid', 'studpermaddr', 'studfirstname', 'studlastname', 'studemail', 'studcontactno')
            ->paginate($perPage);

    }

    public function iterator($transactions){

        $tres = [];

        foreach ($transactions as $data)
        {

            if($data->studpermaddr)
            {
                $address    =  mb_convert_encoding($data->studpermaddr, 'UTF-8', 'ISO-8859-1');
            }
            else
            {
                $address = 'No Address Found';
            }


            if($data->studcontactno)
            {
                $contact    =  mb_convert_encoding($data->studcontactno, 'UTF-8', 'ISO-8859-1');
            }
            else
            {
                $contact = 'No Contact Number Found';
            }


            if($data->studemail)
            {
                $email    =  mb_convert_encoding($data->studemail, 'UTF-8', 'ISO-8859-1');
                $email_class = 'secondary';
            }
            else
            {
                $email = 'No Email Found';
                $email_class = 'danger';
            }

//            if($data->studmidname)
//            {
//                $middle_name    =  mb_convert_encoding($data->studmidname, 'UTF-8', 'ISO-8859-1');
//            }
//            else
//            {
//                $middle_name = '';
//            }


            $first_name     =  mb_convert_encoding($data->studfirstname, 'UTF-8', 'ISO-8859-1');
            $last_name      =  mb_convert_encoding($data->studlastname, 'UTF-8', 'ISO-8859-1');

            $middle_name = '';


            $td = [

                "student_id" => $data->studid,
                "firstname" => $first_name,
                "lastname" => $last_name,
                "middlename" => $middle_name,
                "email" => $email,
                "address" => $address,
                "contact" => $contact,
                "email_class" => $email_class,

            ];

            $tres[count($tres)] = $td;
        }
        return $tres;

    }

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);
            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);
            return $dat;
        } else {
            return $dat;
        }
    }

    public function convertArrayToUTF8($array) {

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->convertArrayToUTF8($value);
            } else {
                $array[$key] = mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
            }
        }
        return $array;
    }
}
