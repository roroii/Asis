<?php

namespace App\Services\my_ledger;
use App\Models\User;
use App\Models\ASIS_Models\system\default_setting;
use App\Models\ASIS_Models\SemSched\tbl_program;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\studentFees\fees;
use App\Models\ASIS_Models\studentFees\assesment_details;
use App\Models\ASIS_Models\studentFees\semcoding;
use App\Models\ASIS_Models\studentFees\collection_details;
use App\Models\ASIS_Models\studentFees\collection_header;

use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use NumberFormatter;
use Carbon\Carbon;


Class my_ledger_services {

    /*get the student information*/
    public  function getStudInfo()
    {
        $userInfo = '';
        $userInfo = User::select('fullname','studid')
                    ->where('studid',Auth::user()->studid)
                    ->Where('active',true)
                    ->first();

        if(!empty($userInfo))
        {
            return $userInfo;
        }
    }

    /*Get the profile pic of the student*/
    public function getStudentPic()
    {
        $logo = default_setting::Where('key','agency_logo')
                                ->Where('active',true)
                                ->first();
        $image = $logo->image;

        $image_path = url(''). "/uploads/settings/" . $image;

        return $image_path;
    }

    /*get proram desc*/
    private function getProgramDesc($code)
    {
        $desc = tbl_program::select('progdesc')
                ->Where('progcode',$code)
                ->first();

        return $desc->progdesc;
    }

    /*get the program of the student base on the program code*/
    public function getStudentProgram()
    {
        $progdesc = '';
        $programs = enrollment_list::Where('studid',Auth::user()->studid)
                    ->Where('active',true)
                    ->first();

                    if(!empty($programs))
                    {
                        return $progdesc = $this->getProgramDesc($programs->studmajor);

                    } else
                    {
                        return "No progam description is found";
                    }
    }

    /*get the course year*/
    public function getCourseYear()
    {
        $section = '';
        $course = enrollment_list::select('studmajor','year_level','section')
                  ->Where('studid',Auth::user()->studid)
                  ->Where('active',true)
                  ->first();

        if(!empty($course))
        {
            $section = $course->studmajor.' '. $course->year_level.''.$course->section;
        }

        return $section;
    }

    public function getYear()
    {
        $year = '';
        $studInfo = enrollment_list::select('year')
                  ->Where('studid',Auth::user()->studid)
                  ->Where('active',true)
                  ->first();

        if(!empty($studInfo))
        {
            $year= $studInfo->year;
        }

        return $year;
    }

    /*Get the student image*/

    /*Get all the student fee*/
    public function getFees($paginate,$keyword)
    {
        $td = '';


        if(empty($paginate))
        {
            $paginate = 20;
        }

        $ass_details = assesment_details::with('getSemcoding')
                        ->select('sy', DB::raw('MAX(sem) as sem'))
                        ->Where('studid',Auth::user()->studid)
                        ->When($keyword!==null, function($query) use ($keyword){
                            return $query->Where(function($query) use ($keyword){
                                        $query->orWhere('sy','ILIKE',"%$keyword%");
                                $query->orWhereHas('getSemcoding', function ($query) use ($keyword){
                                    $query->Where('semdesc','ILIKE',"%$keyword%");
                                });
                            });
                        })
                        ->orderBy('sy','asc')
                        ->orderBy('sem','asc')
                        ->groupBY(['sy','sem'])
                        ->paginate($paginate);

               $td = $ass_details->map(function($details) {

                $semester = $details->getSemcoding;
                $amount = $this->totalFee($details->sy,$details->sem);

                return [
                        'schYear' => $details->sy,
                        'sem' => $semester->semdesc,
                        'orig_sem' => $details->sem,
                        'total_amt' => $amount,
                    ];

               });

        return $td;
    }

    /*get the total amount of the student fee*/
    private function totalFee($sy,$sem)
    {
        $total = assesment_details::Where('studid',Auth::user()->studid)
                    ->Where('sy',$sy)
                    ->Where('sem',$sem)
                    ->sum('amt');

        return $total;
    }

    /*Change the date format from y-month-day*/
    private function changeDateFormat($originalDate)
    {
        $dateFormat = Carbon::createFromFormat('Y-m-d',$originalDate);

        //format the date
        $convertDate = $dateFormat->format('d/m/Y');

        return $convertDate;
    }

    /*===============*/
    // Get all the fee details of the student based on the sy and sem
    /*===============*/

    public function getStudentAssessment($sy,$sem)
    {
        $td = '';

        if((!empty($sy) && !empty($sem)))
        {
            $assessment = assesment_details::with('getFeecodeDesc')
                        ->Where('studid',Auth::user()->studid)
                        ->Where('sy',$sy)
                        ->Where('sem',$sem)
                        ->get();

                $td = $assessment->map(function($ass) use ($sy,$sem){
                        $desc = $ass->getFeecodeDesc;
                        $total_amount = $this->totalFee($sy,$sem);

                        $student_payment = $this->studentPayment($sy,$sem);

                        $balance = $total_amount - $student_payment;
                        $balance = number_format($balance,2,'.',',');

                    return [
                        'feecode' => $ass->feecode,
                        'particuliars' =>$desc->feedesc,
                        'amount' => $ass->amt,
                        'total' => $total_amount,
                        'balance' => $balance,
                    ];
                });

            return $td;
        }

    }


     /*===============*/
    // Get the payment of the student based on the school year and sem
    /*===============*/

    /*Get the specific or of the student transaction*/
    private function getOrnum($schlYr,$sem)
    {
        $getOr = collection_header::select('orno')
                                ->Where('sy',$schlYr)
                                ->Where('sem',$sem)
                                ->Where('studid',Auth::user()->studid)
                                ->chunk(100, function($query) use (&$val){
                                        foreach($query as $or)
                                        {
                                            $val[] = $or->orno;
                                        }
                                });

        return $val;
    }

    /*get the student total pay*/
    private function studentPayment($schlYr,$sem)
    {
        $ornum = $this->getOrnum($schlYr,$sem);
        $amount = 0;
        if(!empty($ornum))
        {
            $payment = collection_details::select('amt')
            ->WhereIn('orno',$ornum)
            ->sum('amt');

            return $payment;
        }

        return $amount;
    }

    /*display the total payment of the student*/
    public function getStudentPayment($schlYr,$sem)
    {
        $td = '';
        $ornum = $this->getOrnum($schlYr,$sem);

        if(!empty($ornum))
        {
            $getPayment = collection_details::with('getCollectionDetails','getFeeCodeDesc')
            ->select('orno','feecode','amt')
            ->WhereIn('orno',$ornum)
            ->get();

                $td = $getPayment->map(function($payment) use ($schlYr,$sem){

                $date = $payment->getCollectionDetails;
                $feecode_desc = $payment->getFeeCodeDesc;
                $total_pay = $this->studentPayment($schlYr,$sem);

                return [
                    'orno' => '#'.$payment->orno,
                    'feecode' =>$feecode_desc->feedesc,
                    'date' => $this->changeDateFormat($date->paydate),
                    'amt' => $payment->amt,
                    'total_pay' => $total_pay
                     ];
            });
                return $td;
        }
    }
}
