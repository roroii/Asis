<?php

namespace App\Http\Controllers\Enroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ASIS_Models\enroll\institute;
use App\Models\ASIS_Models\enroll\tmp_logoFile;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;
use Illuminate\Support\Str;
use Validator;

class enrolledController extends Controller
{
    public function enrolledList()
    {
        $institute = institute::whereNotNull('oid')->select('oid', 'collcode', 'collname')->get();
        $studid = '';
        return view('Enroll.enrolledList', compact('institute','studid'));
    }

    public function tmp_IinstituteLogo_upload(Request $request)
    {
        // dd($request->file());
        foreach ($request->file() as $files) {
            // dd($files);

            $fileName = $files->getClientOriginalName();

            // $get_profile = tblemployee::where('user_id', Auth::user()->id)->first();

            // $last_name = $get_profile->lastname;

            $folder = 'LOGO' . '-' . uniqid() . '-' . now()->timestamp;
            $files->storeAs('public/tmp/' . $folder, $fileName);

            // dd($file);
            tmp_logoFile::create([
                'folder' => $folder,
                'filename' => $fileName
            ]);

            return $folder;
        }
        return '';
    }

    public function tmp_InstituteLogo_delete()
    {

        // $get_path = request()->getContent();

        // $split_File_Path = explode("<", $get_path);

        // $filePath = $split_File_Path[0];

        // $tmp_file = applicants_tempfiles::where('folder', $filePath)->first();
        // if ($tmp_file) {
        //     Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
        //     $tmp_file->delete();

        //     return response('');
        // }
    }
 
    public function loadEnrollmentList(Request $request)
    {
        $perPage = $request->query('limit', 10); // Use 'per_page' instead of 'limit'
        $filters = $request->except('page', 'limit');

        // Apply filters to the query based on the received parameters
        $query = enrollment_list::query();

        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = $filters['search'];
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('studid', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('fullname', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('studmajor', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('number', 'LIKE', '%' . $searchKeyword . '%');
            });
        }

        // Additional filters
        if (isset($filters['school_year'])) {
            $query->where('year', $filters['school_year']);
        }

        if (isset($filters['semester'])) {
            $query->where('sem', $filters['semester']);
        }

        if (isset($filters['year_level'])) {
            $query->where('year_level', $filters['year_level']);
        }

        if (isset($filters['course_program'])) {
            $query->where('studmajor', $filters['course_program']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Perform pagination on the query
        $enrollments = $query->paginate($perPage);

        // Calculate the summary message
        $startEntry = ($enrollments->currentPage() - 1) * $enrollments->perPage() + 1;
        $endEntry = min($startEntry + $enrollments->count() - 1, $enrollments->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$enrollments->total()} entries";

        return response()->json([
            'data' => $enrollments->items(),
            'current_page' => $enrollments->currentPage(),
            'last_page' => $enrollments->lastPage(),
            'per_page' => $enrollments->perPage(),
            'total' => $enrollments->total(),
            'summary' => $summaryMessage,
            'perPage' => $perPage,
        ]); // Return the enrollments as a JSON response
    }


    public function sync_data_recorrect(Request $request)
    {
        $applicants = enrollment_list::whereNull('fullname')->get();


        foreach ($applicants as $applicant) {
            // Query the latest data from the registration model based on student ID
            $latestRegistration = registration::where('studid', $applicant->studid)
                ->latest('oid')
                ->first();

            if ($latestRegistration) {
                // Update the section in the enrollment_list table
                $applicant->update([
                    'section' => $latestRegistration->section,
                    // You can update other columns here if needed
                ]);
            }

            $blankName = enrollment_list::where('studid', $applicant->studid)
                ->whereNull('fullname')
                ->first();

            if ($blankName) {
                $blankName->update([
                    'fullname' => Str::title(convertPGAdminName($applicant->studid)),
                ]);
            }
        }

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function changeStudentStatus(Request $request)
    {

        // Update the status in the database
        enrollment_list::where('id', $request->appId)
            ->update(['status' => $request->new_status]);

        // Retrieve the updated student data
        $updatedStudent = enrollment_list::where('id', $request->appId)->first();

        return response()->json(['message' => 'Status updated successfully', 'data' => $request->all()]);
    }
}
