<?php

namespace App\Http\Controllers\ASIS_Controllers\curriculum;

use App\Http\Controllers\Controller;
use App\Models\e_hris_models\posgres_db\srgb\srgb_semsubject;
use Illuminate\Http\Request;
use App\Models\ASIS_Models\academic_records\curriculum;
use App\Models\ASIS_Models\academic_records\curriculum_prereqs;
use App\Models\ASIS_Models\academic_records\curriculum_year;
use App\Models\ASIS_Models\academic_records\curriculum_year_sem;
use App\Models\ASIS_Models\academic_records\curriculum_year_sem_subject;
use App\Models\ASIS_Models\posgres\enrollment\srgb\semstudent;
use App\Models\ASIS_Models\posgres\portal\srgb\college;
use App\Models\ASIS_Models\posgres\portal\srgb\department;
use App\Models\ASIS_Models\posgres\portal\srgb\program;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;
use App\Models\ASIS_Models\posgres\portal\srgb\student;
use App\Models\ASIS_Models\posgres\portal\srgb\subject;
use Illuminate\Support\Facades\View;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class curriculumController extends Controller
{
    public function curriculum()
    {
        $semsubject = srgb_semsubject::select('sy', 'sem', 'forcoll', 'fordept')
            ->groupBy('sy', 'sem', 'forcoll', 'fordept')
            ->orderBy('sy', 'desc') // Sort by 'sy' column in descending order
            ->get();

        // Use the pluck method to extract unique values for each column
        $uniqueSy = $semsubject->pluck('sy')->unique();
        $uniqueSem = $semsubject->pluck('sem')->unique();
        $uniqueForcoll = $semsubject->pluck('forcoll')->unique()->reject(function ($value) {
            return preg_match('/[,;.]/', $value); // Exclude values with commas or semicolons
        });
        $uniqueFordept = $semsubject->whereNotNull()->pluck('fordept')->unique()->reject(function ($value) {
            return preg_match('/[,;.]/', $value); // Exclude values with commas or semicolons
        });

        $collcode = college::pluck('collcode')->unique()->reject(function ($value) {
            return preg_match('/[,;.]/', $value); // Exclude values with commas or semicolons
        });
        $deptcode = department::pluck('deptcode')->unique()->reject(function ($value) {
            return preg_match('/[,;.]/', $value); // Exclude values with commas or semicolons
        });

         $studmajor = semstudent::pluck('studmajor')->unique()->reject(function ($value) {
            return preg_match('/[,;.]/', $value); // Exclude values with commas or semicolons
        });

        //  dd($deptcode);

        return view('curriculum.curriculum', [
            'uniqueSy' => $uniqueSy,
            'uniqueSem' => $uniqueSem,
            'uniqueForcoll' => $uniqueForcoll,
            'uniqueFordept' => $uniqueFordept,
            'collcode' => $collcode,
            'deptcode' => $deptcode,
            'studmajor' => $studmajor,
        ]);
    }

    public function my_curriculum()
    {
        $studmajor = '';

        if (Auth::user()) {
            $studmajor = trim(semstudent::where('studid', Auth::user()->studid)->latest('studlevel')->value('studmajor'));
            // $studmajor = trim(semstudent::where('studid', '2018-00330')->latest('studlevel')->value('studmajor'));

            $curriculum = Curriculum::with('schoolYears.semesters.subjects.registration_data')
                ->where('major', $studmajor)
                ->where('active', '1')
                ->first();
            if ($curriculum) {
                // Assuming $curriculum is not null
                $curriculum->schoolYears->each(function ($schoolYear) {
                    $schoolYear->semesters->each(function ($semester) {
                        $semester->subjects->each(function ($subject) {
                            // Assuming there is a relationship named 'registrations' in the Subject model
                            $registration = registration::where('subjcode', $subject->subject_code)->where('studid', Auth::user()->studid)->first();
                            $subjectDescription = subject::where('subjcode', $subject->subject_code)->value('subjdesc');
                            if($subjectDescription){
                                $subject->subject_description = $subjectDescription;
                            }
                            if ($registration) {
                                // Add the grade to the subject collection
                                $subject->grade = $registration->grade;
                                $subject->remarks = $registration->remarks;
                                $subject->gcompl = $registration->gcompl;
                            }
                        });
                    });
                });
            }
        }

        $get_year = curriculum::pluck('sy')->unique()->reject(function ($value) {
            return preg_match('/[,;.]/', $value); // Exclude values with commas or semicolons
        });

        $get_major = curriculum::pluck('major')->unique()->reject(function ($value) {
            return preg_match('/[,;.]/', $value); // Exclude values with commas or semicolons
        });

        return view('curriculum.my_curriculum', compact('curriculum', 'get_year', 'get_major'));
    }

    public function load_subjects(Request $request)
    {
        $selectedSchoolYear = $request->input('selectedSchoolYear');
        $selectedSemester = $request->input('selectedSemester');
        $selectedCollege = $request->input('selectedCollege');
        $selectedDepartment = $request->input('selectedDepartment');

        $query = srgb_semsubject::query();

        // Apply filters
        if ($selectedSchoolYear) {
            $query->where('sy', $selectedSchoolYear);
        }
        if ($selectedSemester) {
            $query->where('sem', $selectedSemester);
        }

        // Filter by College and Department
        if ($selectedCollege) {
            $query->where('forcoll', $selectedCollege);
        }
        if ($selectedDepartment) {
            $query->where('fordept', $selectedDepartment);
        }

        // Select the necessary columns
        $query->select('subjcode'); // Add other columns you need

        // Use the groupBy method to group the results by 'subjcode'
        $query->groupBy('subjcode');

        // Eager load the 'subject' relationship
        $query->with('subject');

        $subjects = $query->get();

        return response()->json($subjects);
    }

    public function save_curriculum(Request $request)
    {
        $curriculumData = $request->only(['name', 'degree', 'description', 'sy', 'college', 'major']);

        // Use updateOrCreate to create or update the curriculum
        $curriculum = curriculum::updateOrCreate(
            ['id' => $request->input('curriculum_id')], // Assuming you have a curriculum_id in your request
            array_merge($curriculumData, ['created_by' => Auth::user()->id])
        );

        $curriculum_id = $curriculum->id;

        $yearsData = $request->input('years');
        // dd($yearsData);
        foreach ($yearsData as $yearData) {
            $yearData['curriculum_id'] = $curriculum_id;

            $year_id_input = isset($yearData['id']) ? $yearData['id'] : null;

            $year = curriculum_year::updateOrCreate(
                ['id' => $year_id_input], // Assuming you have a year_id in your request
                $yearData
            );

            $year_id = $year->id;

            $semestersData = $yearData['semesters'];

            foreach ($semestersData as $semesterData) {
                $semesterData['curriculum_year_id'] = $year_id;
                $semesterData['curriculum_id'] = $curriculum_id;

                $semester_id_input = isset($semesterData['id']) ? $semesterData['id'] : null;

                $semester = curriculum_year_sem::updateOrCreate(
                    ['id' => $semester_id_input], // Assuming you have a semester_id in your request
                    $semesterData
                );

                $semester_id = $semester->id;

                $subjectsData = $semesterData['subjects'];

                foreach ($subjectsData as $subjectData) {
                    $subjectData['curriculum_year_sem_id'] = $semester_id;
                    $subjectData['curriculum_id'] = $curriculum_id;
                    $subjectData['curriculum_year_id'] = $year_id;

                    $subject_id_input = isset($subjectData['subjectId']) ? $subjectData['subjectId'] : null;

                    // Update or create the subject
                    $subject = curriculum_year_sem_subject::updateOrCreate(
                        ['id' => $subject_id_input], // Assuming you have a subject_id in your request
                        [
                            'curriculum_year_sem_id' => $subjectData['curriculum_year_sem_id'],
                            'curriculum_id' => $subjectData['curriculum_id'],
                            'curriculum_year_id' => $subjectData['curriculum_year_id'],
                            'subject_code' => str_replace('null', '', $subjectData['code'] ?? ''),
                            'subject_description' => str_replace('null', '', $subjectData['name'] ?? ''),
                            'subject_credits' => str_replace('null', '', $subjectData['credits'] ?? ''),
                            'subject_lec' => str_replace('null', '', $subjectData['lec'] ?? ''),
                            'subject_lab' => str_replace('null', '', $subjectData['lab'] ?? ''),
                            'subject_prereq' => str_replace('null', '', $subjectData['prereq'] ?? ''),
                            'subject_remarks' => str_replace('null', '', $subjectData['remarks'] ?? ''),
                        ]
                    );
                    $subject_id = $subject->id;

                    // Separate prerequisites and loop through them
                    $separatedPrereqs = $this->separatePrereqs($subjectData['prereq'], ',');

                    $existingPrereqs = curriculum_prereqs::where('subject_id', $subject_id)->pluck('prereq_code')->toArray();

                    if (!empty($separatedPrereqs)) {
                        // Compare with the separated prerequisites
                        foreach ($existingPrereqs as $existingPrereq) {
                            if (!in_array($existingPrereq, $separatedPrereqs)) {
                                // Set active to 0 for prerequisites not in the separated list
                                curriculum_prereqs::updateOrCreate(
                                    ['subject_id' => $subject_id, 'prereq_code' => $existingPrereq],
                                    ['active' => 0] // Assuming 'active' is the field to be set
                                );
                            }
                        }

                        // Now, create or update records for the separated prerequisites
                        foreach ($separatedPrereqs as $prereq) {
                            // Check if $prereq is not empty before processing
                            if (!empty($prereq)) {
                                // Create or update records in the new table
                                curriculum_prereqs::updateOrCreate(
                                    ['subject_id' => $subject_id, 'prereq_code' => trim($prereq)],
                                    ['active' => 1,'curriculum_id' => $curriculum_id] // Assuming 'active' is the field to be set
                                );
                            }
                        }
                    }
                }
            }
        }

        return response()->json(['message' => 'Curriculum saved successfully']);
    }

    public function curriculum_data() {
        // Fetch data
        return curriculum::all();
    }

    public function loadCurriculumList(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $filters = $request->except('page', 'per_page');

        // Apply filters to the query based on the received parameters
        $query = curriculum::query();

        // Search filter
        if (isset($filters['search'])) {
            $searchKeyword = $filters['search'];
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('program', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('department', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('college', 'LIKE', '%' . $searchKeyword . '%');
            });
        }

        // You can add more filter conditions based on your requirements
        if (isset($filters['limit'])) {
            // Perform pagination on the query
            $limit_page = $filters['limit'];
            if ($limit_page == 'All') {
                $curriculum = $query->get();
            } else {
                $curriculum = $query->paginate($limit_page);
            }
        } else {
            $curriculum = $query->paginate($perPage);
        }


        // Calculate the summary message
        $startEntry = ($curriculum->currentPage() - 1) * $curriculum->perPage() + 1;
        $endEntry = min($startEntry + $curriculum->count() - 1, $curriculum->total());

        $summaryMessage = "Showing $startEntry to $endEntry of {$curriculum->total()} entries";

        return response()->json([
            'data' => $curriculum->items(),
            'current_page' => $curriculum->currentPage(),
            'last_page' => $curriculum->lastPage(),
            'per_page' => $curriculum->perPage(),
            'total' => $curriculum->total(),
            'summary' => $summaryMessage,
        ]); // Return the curriculum as a JSON response
    }

    public function remove_sy_endpoint(Request $request)
    {
        return response()->json(['message' => 'SY removed successfully']);
    }

    public function remove_semester_endpoint(Request $request)
    {
        return response()->json(['message' => 'Semester removed successfully']);
    }

    public function remove_subject_endpoint(Request $request)
    {

        return response()->json(['message' => 'Subject removed successfully']);
    }

    public function load_curriculum_update(Request $request)
    {
        $data = $request->all();

        // Get the curriculum_id from the request
        $curriculumId = $request->input('curriculum_id');

        $curriculum = Curriculum::with('schoolYears.semesters.subjects')
            ->where('id', $curriculumId)
            ->where('active', '1')
            ->first();

            return response()->json([
                'message' => 'Curriculum loaded successfully',
                'curriculum' => $curriculum,
                'data' => $data,
            ]);

    }
    function separatePrereqs($prereqsString, $delimiter = ',', $filter = null) {
        $prereqs = explode($delimiter, $prereqsString);

        return $prereqs;
    }

    public function printCurriculum($type){
        $now = date('m/d/Y g:ia');

        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');

        if (Auth::user()) {
            $studmajor = trim(semstudent::where('studid', Auth::user()->studid)->latest('studlevel')->value('studmajor'));

            $curriculum = curriculum::with('schoolYears.semesters.subjects.registration_data')
                ->where('active', '1')
                ->first();

            if ($curriculum) {
                // Assuming $curriculum is not null
                $curriculum->schoolYears->each(function ($schoolYear) {
                    $schoolYear->semesters->each(function ($semester) {
                        $semester->subjects->each(function ($subject) {
                            $registration = registration::where('subjcode', $subject->subject_code)->where('studid', Auth::user()->studid)->first();
                            $subjectDescription = subject::where('subjcode', $subject->subject_code)->value('subjdesc');
                            if ($subjectDescription) {
                                $subject->subject_description = $subjectDescription;
                            }
                            if ($registration) {
                                $subject->grade = $registration->grade;
                                $subject->remarks = $registration->remarks;
                                $subject->gcompl = $registration->gcompl;
                            }
                        });
                    });
                });
            }
        }

        $filename = 'pdf';

        $pdf = PDF::loadView('curriculum.print.print_curruculum',compact(['curriculum']))->setPaper('a4', 'portrait');

        if ($type == 'vw') {
            return $pdf->stream($filename . '.pdf');
        } elseif ($type == 'dl') {
            return $pdf->download($filename . '.pdf');
        }

    }

    public function loadFetchData(Request $request)
    {
        $major = $request->input('major');
        $sy = $request->input('year');

        if (Auth::user()) {
            $studmajor = trim(semstudent::where('studid', Auth::user()->studid)->latest('studlevel')->value('studmajor'));

            $curriculum = curriculum::with('schoolYears.semesters.subjects.registration_data')
                ->where('major', $major)
                ->where('sy', $sy)
                ->where('active', '1')
                ->first();

            if ($curriculum) {
                // Assuming $curriculum is not null
                $curriculum->schoolYears->each(function ($schoolYear) {
                    $schoolYear->semesters->each(function ($semester) {
                        $semester->subjects->each(function ($subject) {
                            $registration = registration::where('subjcode', $subject->subject_code)->where('studid', Auth::user()->studid)->first();
                            $subjectDescription = subject::where('subjcode', $subject->subject_code)->value('subjdesc');
                            if ($subjectDescription) {
                                $subject->subject_description = $subjectDescription;
                            }
                            if ($registration) {
                                $subject->grade = $registration->grade;
                                $subject->remarks = $registration->remarks;
                                $subject->gcompl = $registration->gcompl;
                            }
                        });
                    });
                });
            }

            // Return the HTML content in the response
            return response()->json([
                'curriculum' => $curriculum,
                'message' => 'Curriculum loaded successfully',
            ]);
        }
    }
}