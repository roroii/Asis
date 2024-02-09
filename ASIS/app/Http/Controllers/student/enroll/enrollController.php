<?php

namespace App\Http\Controllers\student\enroll;

use App\Exports\exportEnrollmentList;
use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\enrollment\enrollment_settings;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;
use App\Models\ASIS_Models\posgres\portal\srgb\student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class enrollController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function student_enroll()
    {
        $studid = auth()->user()->studid;

        $enrollmentDetails = enrollment_settings::where('active', 1)
            ->whereIn('description', ['status', 'sem', 'year', 'warning_message', 'notification_header', 'link'])
            ->pluck('key_value', 'description');

        $enrollmentSettings = [
            'enrollmentStatus' => $enrollmentDetails['status'] ?? 0,
            'studid' => auth()->user()->studid,
            'semester' => $enrollmentDetails['sem'] ?? '',
            'academicYear' => $enrollmentDetails['year'] ?? '',
            'enrollmentWarningMessage' => $enrollmentDetails['warning_message'] ?? '',
            'notificationHeader' => $enrollmentDetails['notification_header'] ?? '',
            'link' => $enrollmentDetails['link'] ?? '',
        ];


        $student = student::with('sem_student', 'load_registration')->where('studid', $studid)->first();
        $latestSemStudent = $student->sem_student->isEmpty() ? null : $student->sem_student->first();

        $mySQL_student = User::where('studid', $studid)->first();

        if ($mySQL_student->contact)
        {
            $contact_number = $mySQL_student->contact;
        }else
        {
            $contact_number = $student->studcontactno;
        }



        return view('student.enroll.enroll', compact('enrollmentSettings', 'latestSemStudent', 'student', 'contact_number', 'studid'));
    }

    public function enroll(Request $request)
    {

        // Query the latest data from the registration model based on student ID
        $latestRegistration = registration::where('studid', auth()->user()->studid)
            ->latest('oid')
            ->first();
        $section = '';
        if ($latestRegistration) {
            $section = $latestRegistration->section;
        }

        $studentData = [
            'studid' => auth()->user()->studid,
            'sem' => $request->semester,
            'year' => $request->academicYear,
            'fullname' => $request->fullName,
            'studmajor' => $request->courseProgram,
            'email' => $request->emailAddress,
            'number' => $request->phoneNumber,
            'section' => $section,
            'status' => 0,
            'year_level' => $request->studentLevel,
            'address' => $request->address,
            'enrollment_listcol' => $request->enrollment_listcol,
            'created_by' => auth()->user()->studid,
        ];


        try {
            // Use updateOrCreate to insert or update the enrollment_list record based on studid, sem, and year
            enrollment_list::updateOrCreate(
                [
                    'studid' => auth()->user()->studid,
                    'sem' => $request->semester,
                    'year' => $request->academicYear,
                ],
                $studentData
            );

            $enrollmentStatus = true;
            return response()->json(['success' => $enrollmentStatus, 'data' => $studentData]);
        } catch (\Exception $e) {
            // Log the error or handle it accordingly
            $enrollmentStatus = false;
            return response()->json(['success' => $enrollmentStatus, 'error' => $e->getMessage()]);
        }
    }

    public function checkEnrollment(Request $request)
    {
        // Retrieve the user ID, semester, and academic year from the request
        $studid = $request->input('studid');
        $semester = $request->input('semester');
        $academicYear = $request->input('academicYear');

        // Implement your logic to check if the user is already enrolled
        // You can query your database or use any other method to check the enrollment status
        // Return a JSON response indicating whether the user is enrolled or not
        // For example:
        $enrolled = enrollment_list::where('studid', $studid)
            ->where('sem', $semester)
            ->where('year', $academicYear)
            ->exists();

        return response()->json(['enrolled' => $enrolled, 'data' => $request->all()]);
    }

    public function printEnrollmentList(Request $request)
    {
        $now = Carbon::now('Asia/Manila');
        $current_date = $now->format('m-d-Y g:iA');

        $filterYear = $request->input('filter_year');
        $filterSem = $request->input('filter_sem');
        $filterYearLevel = $request->input('filter_year_level');
        $filterProgram = $request->input('filter_program');
        $filterStatus = $request->input('filter_status');

        $enrollListData  = enrollment_list::query()
            ->whereDoesntHave('isAdmin')

            ->when($filterYear, function ($query) use ($filterYear) {
                $query->where('year', $filterYear);
            })
            ->when($filterSem, function ($query) use ($filterSem) {
                $query->where('sem', $filterSem);
            })
            ->when($filterYearLevel, function ($query) use ($filterYearLevel) {
                $query->where('year_level', $filterYearLevel);
            })
            ->when($filterProgram, function ($query) use ($filterProgram) {
                $query->where('studmajor', $filterProgram);
            })
            ->when($filterStatus, function ($query) use ($filterStatus) {
                $query->where('status', $filterStatus);
            })
            ->get();

        $system_settings = system_settings();
        $system_image_header = $system_settings->where('key', 'image_header')->first();
        $system_image_footer = $system_settings->where('key', 'image_footer')->first();

        $filename = 'enrollment_list';
        $filename .= $this->appendFilterToFilename($filterYear, 'year');
        $filename .= $this->appendFilterToFilename($filterSem, 'sem');
        $filename .= $this->appendFilterToFilename($filterYearLevel, 'year_level');
        $filename .= $this->appendFilterToFilename($filterProgram, 'program');
        $filename .= $this->appendFilterToFilename($filterStatus, 'status');

        $pdf = PDF::loadView('student.enroll.print.print_enroll_list', compact('current_date', 'filename', 'system_image_header', 'system_image_footer', 'filterYear', 'filterSem', 'filterYearLevel', 'filterProgram', 'enrollListData'))
            ->setPaper('a4', 'landscape');

        // $type = 'dl';
        if ($this->shouldDownloadPDF($pdf)) {
            return $pdf->download($filename . '.pdf');
        } else {
            return $pdf->stream($filename . '.pdf');
        }
    }

    protected function appendFilterToFilename($filter, $key)
    {
        return $filter ? '_' . $key . '-' . $filter : '';
    }

    protected function shouldDownloadPDF($pdf)
    {
        // Set a threshold size in kilobytes above which the PDF will be downloaded instead of streamed
        $downloadThresholdKB = 512; // Half of 1 MB in KB

        $pdfContent = $pdf->output();
        $pdfSizeKB = strlen($pdfContent) / 1024; // Convert bytes to kilobytes

        return $pdfSizeKB > $downloadThresholdKB;
    }

    public function exportEnrollmentList(Request $request)
    {
        $year = $request->input('filter_year');
        $sem = $request->input('filter_sem');
        $yearLevel = $request->input('filter_year_level');
        $program = $request->input('filter_program');
        $status = $request->input('filter_status');

        // dd($request->all());

        return Excel::download(new ExportEnrollmentList($year, $sem, $yearLevel, $program, $status), 'enrollment_list.xlsx');
    }

    public function updatePhoneNumber(Request $request)
    {
        $student_id = trim($request->student_id);
        $student_phoneNumber = trim($request->student_phoneNumber);

        User::where('studid', $student_id)->update([

            'contact' => $student_phoneNumber,

        ]);

        return json_encode(array(

            'status' => 'success',
            'title' => 'Success!',
            'status_code' => -1,
            'message' => 'Rated Successfully!',
        ), JSON_THROW_ON_ERROR);

    }

}
