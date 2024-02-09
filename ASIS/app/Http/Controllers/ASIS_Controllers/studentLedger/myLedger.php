<?php

namespace App\Http\Controllers\ASIS_Controllers\studentLedger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

//services controller
use App\Services\my_ledger\my_ledger_services;

class myLedger extends Controller
{
    //return the view

    public function index()
    {
        return view('Student_Ledger.my_ledger');
    }

    public function getUserInfo()
    {
        try
        {
            $ledger = new my_ledger_services();
            $userInfo = $ledger->getStudInfo();
            $programDesc = $ledger->getStudentProgram();
            $section = $ledger->getCourseYear();
            $year = $ledger->getYear();
            $logo = $ledger->getStudentPic();

            if(!empty($userInfo))
            {
                return response()->json([
                    'fullname' => Str::title($userInfo->fullname),
                    'studid' => $userInfo->studid,
                    'program_desc' => $programDesc,
                    'section' => $section,
                    'year' => $year,
                    'logo' => $logo,
                ]);
            }

        }catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*get the ledger of the students*/
    public function displayStudentLedger(Request $request)
    {
        try
        {
            $filterSize = $request->filterSize;
            $search = $request->search;

            $ledger = new my_ledger_services();
            $displayLedger = $ledger->getFees($filterSize,$search);

            echo json_encode($displayLedger);

        }catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*get the student assessment details*/
    public function getStudentAssessmentDetails(Request $request)
    {
        try
        {
            $sy = $request->sy;
            $sem = $request->sem;

            $ledger = new my_ledger_services();
            $assessment = $ledger->getStudentAssessment($sy,$sem);

            echo json_encode($assessment);
        }
        catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*get the student payment details*/
    public function getStudentpaymentDetails(Request $request)
    {
        try
        {
            $sy = $request->sy;
            $sem = $request->sem;

            $ledger = new my_ledger_services();
            $studentPayment = $ledger->getStudentPayment($sy,$sem);

            echo json_encode($studentPayment);

        }catch(\Exception $e)
        {
            dd($e);
        }
    }

}
