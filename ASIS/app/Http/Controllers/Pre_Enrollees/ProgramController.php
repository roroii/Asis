<?php

namespace App\Http\Controllers\Pre_Enrollees;

use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\posgres\portal\srgb\department;
use App\Models\ASIS_Models\posgres\portal\srgb\program;
use App\Models\ASIS_Models\pre_enrollees\enrollees_appointment;
use App\Models\ASIS_Models\pre_enrollees\entrance_examinees;
use App\Models\ASIS_Models\Program\program_mySQL;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function programOverview(){

        /** BEGIN:: COPY PROGRAMS FROM POSTGRE TO MYSQL */
        GLOBAL_COPY_DATA_FROM_PGADMIN_TO_MYSQL();
        /** END:: COPY PROGRAMS FROM POSTGRE TO MYSQL */


        return view('pre_enrollees.Program.overview');

    }

    /** ADMIN LOAD EXAMINEES */
    public function loadPrograms(Request $request)
    {

        /** STATUS CODES:
         *
         *  7   -    COMPLETED
         *  11  -    APPROVED
         *
         */

        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');
        $search_value  = '';
        $limit_page  = '';

        if (isset($filters['active_year'])) {
            $active_year = trim($filters['active_year']);
        }
        else
        {
            $active_year = '';
        }

        if (isset($filters['active_sem'])) {
            $active_sem = trim($filters['active_sem']);
        }
        else
        {
            $active_sem = '';
        }


        $currentDate = Carbon::now();
        $date_today = $currentDate->format('Y-m-d');

        // Search filter
        if (isset($filters['search'])) {

            $searchKeyword = trim($filters['search']);
            $page_limit = trim($filters['page_number']);

            $transactions_search = program_mySQL::where('active', 1)
                ->where(function ($query) use ($searchKeyword) {
                    $query->whereRaw('LOWER(program_code) LIKE ?', ["%".strtolower($searchKeyword)."%"])
                        ->orWhereRaw('LOWER(program_desc) LIKE ?', ["%".strtolower($searchKeyword)."%"]);
                })
                ->orderBy('program_desc', 'asc')
                ->paginate(999999);


            $search_value = $this->iterator($transactions_search);
        }


        // FILTER DATA BASED ON PAGE
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];

            if ($limit_page === '999999') {

                $limit_page = 999999;
                $transactions = program_mySQL::where('active', 1)
                    ->orderBy('program_desc', 'asc')
                    ->paginate($limit_page);

                $results = $this->iterator($transactions);

            } else {

                $transactions = $this->queryProgram($perPage, $active_year, $active_sem);
                $results = $this->iterator($transactions);

            }
        }
        else {

            $transactions = $this->queryProgram($perPage, $active_year, $active_sem);
            $results = $this->iterator($transactions);
        }


        // FILTER DATA BASED ON ACTIVE SCHOOL YEAR
        if (isset($filters['limitYear'])) {
            // Perform pagination on the query
            $limit_year = $filters['limitYear'];
            $limit_sem = $filters['sem'];

            $my_transactions = program_mySQL::where('active', 1)
                ->where(function ($query) use ($limit_year) {
                    $query->whereRaw('LOWER(year) LIKE ?', ["%".strtolower($limit_year)."%"]);
                })
                ->where('sem', $limit_sem)
                ->orderBy('program_desc', 'asc')
                ->paginate(999999);

            $results = $this->iterator($my_transactions);
        }

        // FILTER DATA BASED ON ACTIVE SEMESTER
        if (isset($filters['limitSem'])) {
            // Perform pagination on the query
            $limit_sem = $filters['limitSem'];
            $limit_year = $filters['year'];

            $my_transactions = program_mySQL::where('active', 1)
                ->where(function ($query) use ($limit_sem) {
                    $query->whereRaw('LOWER(sem) LIKE ?', ["%".strtolower($limit_sem)."%"]);
                })
                ->where('year', $limit_year)
                ->orderBy('program_desc', 'asc')
                ->paginate(999999);

            $results = $this->iterator($my_transactions);
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
    public function queryProgram($perPage, $limit_year, $limit_sem){

        return program_mySQL::where('active', 1)
            ->where(function ($query) use ($limit_year) {
                $query->whereRaw('LOWER(year) LIKE ?', ["%".strtolower($limit_year)."%"]);
            })
            ->where(function ($query) use ($limit_sem) {
                $query->whereRaw('LOWER(sem) LIKE ?', ["%".strtolower($limit_sem)."%"]);
            })
            ->with('getDepartment')
            ->orderBy('program_desc', 'asc')
            ->paginate($perPage);

    }
    public function iterator($transactions): array
    {

        $tres = [];


        foreach ($transactions as $data)
        {

            $program_id = $data->id;
            $program_code = $data->program_code;
            $program_desc = $data->program_desc;
            $program_dept = $data->program_dept;
            $program_slots = $data->slots;

            if($program_slots)
            {
                $class = 'primary';
                $slots = $program_slots;
            }else
            {
                $class = 'danger';
                $slots = 0;
            }
            if($program_dept)
            {
                $department = department::where('deptcode', $program_dept)->first();
                $program_department = $department->deptname;
                $program_college = $department->deptcoll;

            } else
            {
                $program_department = 'No Data';
                $program_college = 'No Data';
            }



            $td = [

                "program_id"         => $program_id,
                "program_code"         => $program_code,
                "program_desc"         => $program_desc,
                "program_department"   => $program_department,
                "program_college"      => $program_college,
                "class"                => $class,
                "slots"                => $slots,

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
    public function updateProgramSlots(Request $request)
    {

        $program_id = trim($request->program_id);
        $program_slots = trim($request->program_slots);

        program_mySQL::where('id', $program_id)->update([

            'slots' => $program_slots,

        ]);


        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => -1,
            'message' => 'Program Slots Updated Successfully!',
        ), JSON_THROW_ON_ERROR);
    }
}
