<?php

namespace App\Http\Controllers\academic_records;

use App\Http\Controllers\Controller;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;
use App\Models\ASIS_Models\posgres\portal\srgb\subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class academicRecords extends Controller
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

    public function academic_transcript()
    {
        // Retrieve all records for the current student ID
        $records = registration::where('studid', auth()->user()->studid)->get();

        // Group the records by school year (year) and semester (sem)
        $groupedData = $records->groupBy(['sy', 'sem']);

        // Iterate through the grouped data and update records with subject descriptions
        foreach ($groupedData as $year => $yearData) {
            foreach ($yearData as $sem => $semData) {
                foreach ($semData as $record) {
                    // Fetch subject description based on $record->subjcode from your subject model
                    $subjectDescription = subject::where('subjcode', $record->subjcode)->value('subjdesc');

                    // Add the subject description to the record
                    // $record->subject_description = Str::title($subjectDescription);
                    $record->subject_description = $subjectDescription;
                }
            }
        }

        return view('academic_records.acdemic_transcript.at', compact('groupedData'));
    }
}