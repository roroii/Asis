<?php

namespace App\Http\Controllers\ASIS_COntrollers\SemSched;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\sem_sched_service\SetSem_sched;

class Sem_Sched_Controller extends Controller
{
    //
    public function index()
    {
        $sched = new SetSem_sched();
        $department = $sched->getDepartment();
        $sem = $sched->get_sem();

        return view("Set_semestral_sched.set_sched",compact('department','sem'));
    }

    public function retrieved_program(Request $request)
    {
        $sched = new SetSem_sched();
        $program = $sched->get_program($request->progdept);

        echo json_encode($program);
    }
}
