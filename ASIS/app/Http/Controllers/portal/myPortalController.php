<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;
use Illuminate\Http\Request;

class myPortalController extends Controller
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

    public function my_portal()
    {
        return view('my_portal.my_portal');
    }

    public function load_student_data(Request $request)
    {
        $studid = auth()->user()->studid;
        $perPage = $request->input('per_page', 20);

        // Check if the 'size' filter is set to 'All'
        if ($request->has('size') && $request->input('size') === 'All') {
            $perPage = 999999; // Set a high number for "All" size
        }

        $query = Registration::where('studid', $studid)->select('oid', 'midterm', 'finalterm', 'grade', 'remarks', 'registered', 'grade_enc', 'sy', 'sem', 'subjcode', 'gcompl');

        // Filter by year
        $year = $request->input('year');
        if ($year) {
            $query->where('sy', $year);
        }

        // Filter by semester
        $sem = $request->input('sem');
        if ($sem) {
            $query->where('sem', $sem);
        }

        // Filter by subject code
        $subjectCode = $request->input('subject_code');
        if ($subjectCode) {
            $subjectCode = strtoupper($subjectCode);
            $query->where('subjcode', 'like', '%' . $subjectCode . '%');
        }

        // Filter by "Has the" keyword
        $hasThe = $request->input('has_the');
        if ($hasThe) {
            $hasThe = strtoupper($hasThe);
            $query->where(function ($query) use ($hasThe) {
                $query->where('midterm', 'like', '%' . $hasThe . '%')
                    ->orWhere('subjcode', 'like', '%' . $hasThe . '%')
                    ->orWhere('finalterm', 'like', '%' . $hasThe . '%')
                    ->orWhere('grade', 'like', '%' . $hasThe . '%')
                    ->orWhere('remarks', 'like', '%' . $hasThe . '%');
            });
        }

        // Filter by "Doesn't Have" keyword
        $doesntHave = $request->input('doesnt_have');
        if ($doesntHave) {
            $doesntHave = strtoupper($doesntHave);
            $query->where(function ($query) use ($doesntHave) {
                $query->where('midterm', 'not like', '%' . $doesntHave . '%')
                    ->orWhere('finalterm', 'not like', '%' . $doesntHave . '%')
                    ->orWhere('subjcode', 'not like', '%' . $doesntHave . '%')
                    ->orWhere('grade', 'not like', '%' . $doesntHave . '%')
                    ->orWhere('remarks', 'not like', '%' . $doesntHave . '%')
                    ->orWhere('registered', 'not like', '%' . $doesntHave . '%');
            });
        }

        // Filter by the "search-input" value
        $searchInput = $request->input('searchinput');
        if ($searchInput) {
            $searchInput = strtoupper($searchInput);
            $query->where(function ($query) use ($searchInput) {
                $lowerSearchInput = strtolower($searchInput);
                $query->whereRaw('LOWER(subjcode) LIKE ?', ['%' . $lowerSearchInput . '%'])
                    ->orWhereRaw('LOWER(grade) LIKE ?', ['%' . $lowerSearchInput . '%'])
                    ->orWhereRaw('LOWER(sy) LIKE ?', ['%' . $lowerSearchInput . '%'])
                    ->orWhereRaw('LOWER(remarks) LIKE ?', ['%' . $lowerSearchInput . '%']);
            });
        }

        // Filter by "Min Grade" value
        $minGrade = $request->input('minGrade');
        if ($minGrade) {
            $query->where('grade', '>=', $minGrade);
        }

        // Filter by "Max Grade" value
        $maxGrade = $request->input('maxGrade');
        if ($maxGrade) {
            $query->where('grade', '<=', $maxGrade);
        }

        $data = $query->paginate($perPage);

        // Extract the relevant information from the paginated data to build the summary
        $totalRecords = $data->total();
        $currentPage = $data->currentPage();
        $from = ($currentPage - 1) * $perPage + 1;
        $to = min($from + $perPage - 1, $totalRecords);
        $summary = "{$from} - {$to} of {$totalRecords}";

        // Return the data and summary in JSON format, along with additional information required for pagination
        return response()->json([
            'data' => $data->items(),
            'summary' => $summary,
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'links' => [
                'prev_page_url' => $data->previousPageUrl(),
                'next_page_url' => $data->nextPageUrl()
            ]
        ]);
    }
}
