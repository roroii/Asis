<?php
namespace App\Services\sem_sched_service;
use App\Models\ASIS_Models\SemSched\tbl_department;
use App\Models\ASIS_Models\SemSched\tbl_program;
use App\Models\ASIS_Models\SemSched\tbl_semencoding;
use App\Models\ASIS_Models\tbl_schYr;

class SetSem_sched {

    //get the department
    public function getDepartment()
    {
        try
        {
            $dept = '';
            $dept = tbl_department::select('oid','deptcode','deptname')->wherenotNull('oid')->latest('oid')->get();

            if(!$dept)
            {
                $dept = 'no data';
            }

            return $dept;

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    //get the different program base on the department
    public function get_program($dept)
    {
        try
        {
            $program = '';

            if($dept != '')
            {
                $program = tbl_program::select('oid','progcode','progdesc','active')->where('progdept',$dept)->where('active',true)
                ->chunk(50,function($q) use (&$val,&$td){

                    foreach($q as $prog)
                    {
                        $val[] = [
                            'oid' => $prog->oid,
                            'desc' => $prog->progdesc
                        ];

                        $td[count((array)$td)] = $val;
                    }
                });

                 if(!$program)
                 {
                    $td = 0;
                 }

                return $td;
            }

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    //get the sem
    public function get_sem()
    {
        try
        {
            $sem = '';

            $sem = tbl_semencoding::select('oid','semcode','semdesc')->wherenotNull('oid')->oldest('oid')->get();

            if(!$sem)
            {
                $sem = 'no data';
            }

            return $sem;

        }catch(Exception $e)
        {
            dd($e);
        }
    }

}
