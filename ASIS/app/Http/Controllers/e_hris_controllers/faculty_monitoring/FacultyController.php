<?php

namespace App\Http\Controllers\faculty_monitoring;

use App\Http\Controllers\Controller;
use App\Models\faculty_monitoring\fm_class_schedule;
use App\Models\others\link_classes;
use App\Models\others\link_meeting;
use App\Models\others\linked_faculty_agency_user;
use App\Models\posgres_db\pis\pis_employee;
use App\Models\posgres_db\srgb\srgb_semsubject;
use App\Models\posgres_db\test_db;
use Auth;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
         * Create a new controller instance.
         *
         * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);

    }

    /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Contracts\Support\Renderable
     */

    public function faculty(){

        // // throw new \Exception('User not found!');
        // // $samp = pis_employee::with('get_subjects')->limit(2)->get();
        // // $school_year = srgb_semsubject::groupBy('sy')->pluck('sy');
        // // $school_sem = srgb_semsubject::groupBy('sem')->pluck('sem');

        // $get_semsubject_fid = linked_faculty_agency_user::with('get_semsubject')->where('hris_agency_id',Auth::user()->employee)->pluck('esms_faculty_id');
        // // $get_semsubject = srgb_semsubject::where('sy','2016-2017')->where('sem','1')->whereIn('facultyid',$get_semsubject_fid)->pluck(
        // // 'oid',
        // // );

        // // $oid_sample = srgb_semsubject::with('get_link')->where('oid','2363748')->first();
        // $oid_sample = link_meeting::with('get_link')->get();

        // $get_semsubject = srgb_semsubject::where('sy','2016-2017')->where('sem','1')->whereIn('facultyid',$get_semsubject_fid)->select("*")->get();

        //  dd($oid_sample);

        return view('faculty_monitoring.faculty');
    }

    public function load_subject(Request $request){
        $data = $request->all();
        $tres = [];

        $get_semsubject_fid = linked_faculty_agency_user::where('hris_agency_id',Auth::user()->employee)->where('active',1)->pluck('esms_faculty_id');
        $get_semsubject = srgb_semsubject::where('sy',$request->filter_year)->where('sem',$request->filter_sem)->whereIn('facultyid',$get_semsubject_fid)->get();
        // $get_semsubject = srgb_semsubject::where('sy','2016-2017')->where('sem','1')->whereIn('facultyid',$get_semsubject_fid)->get();
        // dd( $get_semsubject);

        foreach ($get_semsubject as $subject) {

            $primary_key = srgb_semsubject::
                where('sy',$subject->sy)
                ->where('sem',$subject->sem)
                ->where('subjcode',$subject->subjcode)
                ->where('section',$subject->section)
                ->where('subjsecno',$subject->subjsecno)
                ->where('block',$subject->block)
                ->where('facultyid',$subject->facultyid)
                ->where('forcoll',$subject->forcoll)
                ->where('semsubject_id',$subject->semsubject_id)
                ->where('fordept',$subject->fordept)
                ->where('lock',$subject->lock)
                ->where('facultyload',$subject->facultyload)
                ->pluck('oid')->first();

            $get_status = link_meeting::where('_oid',$primary_key)->first();

                $status = 'No Link';
                $class_color = 'pending';
                $status_btn = '';
                if($get_status){

                    if($get_status->status == 14){

                        $status = 'Closed';
                        $class_color = 'danger';
                        $status_btn = '<input id="'.$primary_key.'" data-id-oid="'.$primary_key.'" data-id-lm="'.$get_status->id.'" data-id-lnk="'.$get_status->link_meeting.'"  onclick="checkClickFunc('.$primary_key.','.$get_status->id.','.$get_status->link_class_id.')" class="form-check-input" type="checkbox">';

                    }elseif($get_status->status == 15){

                        $status = 'Ongoing';
                        $class_color = 'primary';
                        $status_btn = '<input id="'.$primary_key.'" data-id-oid="'.$primary_key.'" data-id-lm="'.$get_status->id.'" data-id-lnk="'.$get_status->link_meeting.'"  onclick="checkClickFunc('.$primary_key.','.$get_status->id.','.$get_status->link_class_id.')" class="form-check-input" type="checkbox" checked>';

                    }

                }


                $td = [

                    "oid" => $subject->getKey(),
                    "sy" => $subject->sy,
                    "sem" => $subject->sem,
                    "subjcode" => $subject->subjcode,
                    "section" => $subject->section,
                    "subjsecno" => $subject->subjsecno,
                    "days" => $subject->days,
                    "time" => $subject->time,
                    "room" => $subject->room,
                    "bldg" => $subject->bldg,
                    "block" => $subject->block,
                    "maxstud" => $subject->maxstud,
                    "facultyid" => $subject->facultyid,
                    "forcoll" => $subject->forcoll,
                    "fordept" => $subject->fordept,
                    "lock" => $subject->lock,
                    "facultyload" => $subject->facultyload,
                    "tuitionfee" => $subject->tuitionfee,
                    "lockgraduating" => $subject->lockgraduating,
                    "offertype" => $subject->offertype,
                    "semsubject_id" => $subject->semsubject_id,
                    "editable" => $subject->editable,
                    "fused_lec_to" => $subject->fused_lec_to,
                    "primary_key" => $primary_key,
                    "status" => $status,
                    "class_color" => $class_color,
                    "status_btn" => $status_btn,

                ];
                $tres[count($tres)] = $td;
            }


        echo json_encode($tres);

    }

    public function load_linked(Request $request){
        $data = $request->all();
        $tres = [];

        $linked_data = linked_faculty_agency_user::where('active',1)->where('esms_faculty_id',$request->esms_faculty)->orWhere('hris_agency_id',$request->agency_employee)->get();

        foreach ($linked_data as $linked) {

                $fullname = fullname($linked->hris_agency_id);

                $td = [
                    "esms_faculty_id" => $linked->esms_faculty_id,
                    "hris_agency_id" => $linked->hris_agency_id,
                    "fullname" => $fullname,
                ];
                $tres[count($tres)] = $td;
            }


        echo json_encode($tres);

    }

    public function add_schedule(Request $request){
            $data = $request->all();

            $add_new_schedule = [
                'agency_id'=> Auth::user()->employee,
                'subject_name'=> $request->modal_subject_name,
                'subject_code'=> $request->modal_subject_code,
                'date_time'=> $request->modal_date_time,
                'status'=> $request->modal_status,
                'type'=> $request->modal_type,
                'created_by'=> Auth::user()->employee,
            ];

            $schedule_id = fm_class_schedule::updateOrCreate(['id' => $request->schedule_id],$add_new_schedule)->id;

            return json_encode(array(
                "data"=>$add_new_schedule,
            ));
    }

    public function add_linked(Request $request){
    $data = $request->all();

    $add_new_linked_data = [
        'esms_faculty_id'=> $request->esms_facultyList,
        'hris_agency_id'=> $request->agency_employeeList,
        'created_by'=> Auth::user()->employee,
    ];

    $linked_id = linked_faculty_agency_user::updateOrCreate(['esms_faculty_id' => $request->esms_facultyList,'hris_agency_id' => $request->agency_employeeList],$add_new_linked_data)->id;

    return json_encode(array(
        "data"=>$data,
    ));
    }

    public function add_link_meeting(Request $request){
    $data = $request->all();

    $add_new_link_data = [
        '_oid'=> $request->pk,
        'sy'=> $request->sy,
        'sm'=> $request->sm,
        'sc'=> $request->sc,
        'sec'=> $request->sec,
        'scd'=> $request->scd,
        'blk'=> $request->blk,
        'fid'=> $request->fid,
        'fc'=> $request->fc,
        'link_meeting'=> $request->modal_link_meeting,
        'link_meeting_description'=> $request->modal_link_meeting_description,
        'created_by'=> Auth::user()->employee,
    ];

    $link_id = link_meeting::updateOrCreate([
        '_oid'=> $request->pk,
    ],$add_new_link_data)->id;

    return json_encode(array(
        "data"=>$data,
        "add_new_link_data"=>$add_new_link_data,
    ));

    }

    public function load_link_meeting_update(Request $request){
    $data = $request->all();

    $get_status = link_meeting::where('_oid',$request->pk)->first();

    return json_encode(array(
        "data"=>$data,
        "get_status"=>$get_status,
    ));

    }

    public function add_class_started(Request $request){
        $data = $request->all();
        $date_now = now();

        $add_new_class = [
            '_oid'=> $request->primary_key,
            'link_meeting_id'=> $request->link_meeting,
            'meeting_link'=> $request->link_meeting_text,
            'started_at'=> $date_now,
            'created_by'=> Auth::user()->employee,
        ];
        $class_id = link_classes::updateOrCreate(['id' =>$date_now],$add_new_class)->id;

        $update_link_meeting = [
            'link_class_id'=> $class_id,
            'status'=> 15,
        ];

        link_meeting::updateOrCreate(['id'=> $request->link_meeting],$update_link_meeting);


        return json_encode(array(
            "data"=>$data,
        ));

    }

    public function add_class_ended(Request $request){
        $data = $request->all();

        $date_now = now();

        $update_link_meeting = [
            'link_class_id'=> '',
            'status'=> 14,
        ];

        link_meeting::updateOrCreate(['id'=> $request->link_meeting],$update_link_meeting);

        $update_link_class = [
            'ended_at'=> $date_now,
        ];

        link_classes::updateOrCreate(['id'=> $request->class_id],$update_link_class);

        return json_encode(array(
            "data"=>$data,
        ));

    }




}
