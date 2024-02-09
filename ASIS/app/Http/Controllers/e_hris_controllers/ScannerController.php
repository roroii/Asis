<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\document\doc_notes;
use App\Models\document\doc_track;
use App\Models\document\doc_trail;
use App\Models\tblemployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScannerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function scanner()
    {
        return view('scanner.scan');
    }


    public function take_action_viaqr(Request $request)
    {
        $data = $request->all();

        $getfile = doc_file::with('getDocType','getDocLevel','getDocTypeSubmitted','getDocStatus','getAttachments','getTrackdetails','getAuthor','getAddress')->where('track_number',$request->docID)->where('active',1)->first();
        $hasUser = '';
        if(Auth::check()){
            $hasUser = 'true';
        }

        return json_encode(array(
            "data"=>$data,
            "getfile"=>$getfile,
            "hasUser"=>$hasUser,
        ));
    }


    public function add_note(Request $request)
    {
        $data = $request->all();

        if( $request->track_id){
            $add_note = [
                'title' => $request->modal_note_title,
                'desc' => $request->modal_not_message,
                'created_by' => Auth::user()->employee,
                'type' => 'document',
                'type_id' => $request->track_id,

            ];
        }else{
            $add_note = [
                'title' => $request->modal_note_title,
                'desc' => $request->modal_not_message,
                'created_by' => Auth::user()->employee,
            ];
        }


        $note_id = doc_notes::create($add_note)->id;

        __notification_set(1, "Note Added!", "Important note added successfully!");
        add_log('note',$note_id,'Note added Successfully!');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function remove_note(Request $request)
    {
        $data = $request->all();

        $update_note= [
            'dismiss' => 0,
        ];

        doc_notes::where(['id' =>  $request->note_id])->first()->update($update_note);

        __notification_set(-1, "Note Removed!", "Important note removed successfully!");
        return json_encode(array(
            "data"=>$data,
        ));
    }


    public function receive_details(Request $request , $status)
    {
        $data = $request->all();

        $option_1 = get_option_for_release();
        $getDoc = doc_file::where('track_number',$request->search_scan_documet_receive)->where('active', 1)->first();
        $release_to = '';
        $recent_activity = '';

        $get_trail = doc_trail::tree()->where('track_number',$request->search_scan_documet_receive);


        $release_to = release_to(doc_trail::tree()->where('track_number',$request->search_scan_documet_receive),$request->search_scan_documet_receive);

        $check_doc = doc_file::where('track_number',$request->search_scan_documet_receive)->first();



        if($status == 6){
            $get_track = doc_track::with('getUser','getDocStatus','get_sender')
            ->where('track_number',$request->search_scan_documet_receive)
            ->where('target_user_id',Auth::user()->employee)
            ->where('for_status',$status)
            ->where('active',1)
            ->orderBy('id', 'DESC')->limit(3)->get();
        }else if($status == 8){
            $get_track = doc_track::with('getUser','getDocStatus','get_sender')
            ->where('track_number',$request->search_scan_documet_receive)
            ->where('created_by',Auth::user()->employee)
            ->where('for_status',3)
            ->where('active',1)
            ->orderBy('id', 'DESC')->limit(3)->get();

        }else if($status == 5){
            $get_track = doc_track::with('getUser','getDocStatus','get_sender')
            ->where('track_number',$request->search_scan_documet_receive)
            ->where('created_by',Auth::user()->employee)
            ->where('for_status',$status)
            ->where('active',1)
            ->orderBy('id', 'DESC')->limit(3)->get();
        }else if($status == 4){
            $get_track = doc_track::with('getUser','getDocStatus','get_sender')
            ->where('track_number',$request->search_scan_documet_receive)
            ->where('created_by',Auth::user()->employee)
            ->where('for_status',$status)
            ->where('active',1)
            ->orderBy('id', 'DESC')->limit(3)->get();
        }else if($status == 3){
            $get_track = doc_track::with('getUser','getDocStatus','get_sender')
            ->where('track_number',$request->search_scan_documet_receive)
            ->where('target_user_id',Auth::user()->employee)
            ->where('for_status',$status)
            ->where('active',1)
            ->orderBy('id', 'DESC')->limit(3)->get();
        }






        if($get_track){
            $fullname = '';
            $status_detail = '';
            $status_ = '';
            foreach($get_track as $track_m){

                    if($track_m->get_sender()->exists()){
                        $fullname = $track_m->get_sender->firstname .' '. $track_m->get_sender->lastname;
                    }

                    if($track_m->for_status == 6){
                        $status_detail = 'You received this document';
                        $status_ = 'Received';
                    }else if($track_m->for_status == 8){
                        $status_detail = 'You released this document';
                        $status_ = 'Released';
                    }else if($track_m->for_status == 5){
                        $status_detail = 'You held this document';
                        $status_ = 'Held';
                    }else if($track_m->for_status == 4){
                        $status_detail = 'You returned this document';
                        $status_ = 'Returned';
                    }else if($track_m->for_status == 3){
                        if($track_m->getUser()->exists()){
                            $status_detail = 'You released this document to '.$track_m->getUser->firstname.' '.$track_m->getUser->lastname;
                        }else{
                            $status_detail = 'You released this document';
                        }

                        $status_ = 'Released';
                    }

                    $recent_activity .= '
                    <div class="intro-y">
                        <div class="box px-4 py-4 mb-3 flex items-center zoom-in">

                            <div class=" text-left">
                                <div class="text-slate-500 text-xs">'. $status_detail.'</div>
                                <div class="text-slate-500 text-xs mt-0.5">'.$track_m->created_at->diffForHumans().'</div>
                            </div>

                            <div  class="py-1 px-2 rounded-full ml-auto text-xs bg-'.$track_m->getDocStatus->class.' text-white cursor-pointer font-medium">'.$status_.'</div>
                        </div>
                    </div>
                        ';

            }


        }





        return json_encode(array(
            "data"=>$data,
            "check_doc"=>$check_doc,
            "getDoc"=>$getDoc,
            "option_Value"=>$option_1,
            "release_to"=>$release_to,
            "get_trail"=>$get_trail,
            "recent_activity"=>$recent_activity,
        ));
    }


    public function receive_action(Request $request)
    {
        $data = $request->all();
        $trail_id = null;
        $created_by = null;

        $getDocTrack = doc_track::where('track_number',$request->track_id)->where('target_user_id',Auth::user()->employee)->where('action',0)->get();
        if($getDocTrack){
            foreach($getDocTrack->where('for_status',3) as $track){
                if(!$track->doc_trail_id == null){
                    $trail_id = $track->doc_trail_id;
                    $update_trail= [
                        'receive_date' => now(),
                    ];
                    doc_trail::where(['id' =>  $track->doc_trail_id])->first()->update($update_trail);

                    /* Added by Montz */
                    $created_by = doc_trail::where('track_number', $request->track_id)->first();

                    $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
                    $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;

                    /* Created Notification for document receive */
                    createNotification('document_receive', $request->track_id, 'user', Auth::user()->employee, $created_by->created_by, 'user', 'Your document with a tracking number : ' . $request->docID . ' has been received by '.$holder_fullname.'.');
                    /* Added by Montz */

                }
                $update_track= [
                    'action' => '1',
                    'seen' => '1',
                    'last_activity' => false,
                ];
                doc_track::where(['id' =>  $track->id])->first()->update($update_track);
            }
            $get_active = doc_track::where('last_activity',1)->where('track_number',$request->track_id)->get();
            if( $get_active){
                foreach($get_active->where('target_user_id', Auth::user()->employee) as $track_last_active){
                    $update_track= [
                        'action' => '1',
                        'seen' => '1',
                        'last_activity' => false,
                    ];
                    doc_track::where(['id' =>  $track_last_active->id])->first()->update($update_track);
                }
            }


            $add_receive_track = [
                'track_number' => $request->track_id,
                'doc_trail_id' => $trail_id,
                'type' => $request->doc_sendAstype,
                'type_id' => $request->doc_sendAs,
                'target_user_id' =>Auth::user()->employee,
                'note' => $request->swal_receive_message,
                'for_status' => 6,
                'created_by' => Auth::user()->employee,
                'target_type' => null,
                'target_id' => null,
                'last_activity' => true,
            ];
            $track_id = doc_track::create($add_receive_track)->id;

            $update_doc_file = [
                'holder_id' => $request->doc_sendAs,
                'holder_type' => $request->doc_sendAstype,
                'holder_user_id' => Auth::user()->employee,
                'status' => 2,
            ];
            doc_file::where(['track_number' =>  $request->track_id])->first()->update($update_doc_file);
        }else{
            $getDoc = doc_file::where('track_number',$request->track_id)->first();

            $get_active = doc_track::where('last_activity',1)->where('track_number',$request->track_id)->get();
            foreach($get_active->where('target_user_id', Auth::user()->employee) as $track_last_active){
                $update_track= [
                    'action' => '1',
                    'seen' => '1',
                    'last_activity' => false,
                ];
                doc_track::where(['id' =>  $track_last_active->id])->first()->update($update_track);
            }

            $add_receive_track = [
                'track_number' => $request->track_id,
                'doc_trail_id' => $trail_id,
                'type' => $request->doc_sendAstype,
                'type_id' => $request->doc_sendAs,
                'target_user_id' =>Auth::user()->employee,
                'note' => $request->swal_receive_message,
                'for_status' => 6,
                'created_by' => Auth::user()->employee,
                'target_type' => null,
                'target_id' => null,
                'last_activity' => true,
            ];
            $track_id = doc_track::create($add_receive_track)->id;

            $update_doc_file = [
                'holder_id' => $request->doc_sendAs,
                'holder_type' => $request->doc_sendAstype,
                'holder_user_id' => Auth::user()->employee,
                'status' => 2,

            ];
            doc_file::where(['track_number' =>  $request->track_id])->first()->update($update_doc_file);


        }


        //__notification_set(1, "Document Received Successfully", "View your received files at the receive section!");
        return json_encode(array(
            "data"=>$data,
            "getDoc"=>$getDoc,
            "status" => 200
        ));
    }


    public function release_action(Request $request)
    {
        $data = $request->all();

        $getDoc = doc_file::where('track_number',$request->track_id)->first();

        if($getDoc){
            $update_sub_trail= [
                'release_date' => now(),
            ];
            $checktrail  = doc_trail::where('track_number',$request->track_id)->where('target_user_id',$getDoc->holder_user_id)->first();
            if($checktrail ){
                doc_trail::where(['track_number' =>  $request->track_id, 'target_user_id' =>  $getDoc->holder_user_id])->first()->update($update_sub_trail);

            }
        }


        /* Added by Montz */
        $created_by = doc_trail::where('track_number', $request->track_id)->first();
        if($created_by ){
            $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
            $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;
            /* Created Notification for document release */
            createNotification('document_release', $request->track_id, 'user', Auth::user()->employee, $created_by->created_by, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been released by '.$holder_fullname.'.');

            /* Added by Montz */
        }


        $get_track = doc_track::where('for_status',6)->where('target_user_id',Auth::user()->employee)->first();

        if($get_track ){
            $update_track= [
                'action' => 1,
                'seen' => 1,
                'last_activity' => false,
            ];
            doc_track::where(['id' =>  $get_track->id])->first()->update($update_track);
        }


        $get_trail = doc_trail::where('track_number',$request->track_id)->where('target_user_id',$request->swal_release_to)->where('receive_date',null)->where('release_date',null)->first();
        if($get_trail){
            $add_incoming_track = [
                'track_number' => $request->track_id,
                'doc_trail_id' => $get_trail->id,
                'type' => $request->doc_sendAstype,
                'type_id' => $request->doc_sendAs,
                'target_user_id' =>$request->swal_release_to,
                'note' => $request->swal_release_textarea,
                'for_status' => 3,
                'created_by' => Auth::user()->employee,
                'target_type' => null,
                'target_id' => null,
                'last_activity' => true,
            ];
            $track_id = doc_track::create($add_incoming_track)->id;



            /* Added by Montz */
            $target_id_for_notification = doc_track::where('target_user_id', $request->swal_release_to)->first();
            /* Created Notification for document release and send to another user */
            createNotification('document', $request->track_id, 'user', Auth::user()->employee, $target_id_for_notification->target_user_id, 'user', 'You have a document to receive with tracking number : '.$request->track_id.'.');

            /* Added by Montz */

        }else{

            $get_active = doc_track::where('last_activity',1)->where('track_number',$request->track_id)->get();
            if( $get_active){
                foreach($get_active->where('target_user_id', Auth::user()->employee) as $track_last_active){
                    $update_track= [
                        'action' => '1',
                        'seen' => '1',
                        'last_activity' => false,
                    ];
                    doc_track::where(['id' =>  $track_last_active->id])->first()->update($update_track);
                }
            }

            $add_receive_track = [
                'track_number' => $request->track_id,
                'doc_trail_id' => null,
                'type' => $request->doc_sendAstype,
                'type_id' => $request->doc_sendAs,
                'target_user_id' => null,
                'note' => $request->swal_receive_message,
                'for_status' => 3,
                'created_by' => Auth::user()->employee,
                'target_type' => null,
                'target_id' => null,
                'last_activity' => true,
            ];
            $track_id = doc_track::create($add_receive_track)->id;

            /* Added by Montz */
            $target_id_for_notification = doc_track::where('target_user_id', $request->swal_release_to)->first();

            /* Created Notification for document release and send to another user */
            createNotification('document', $request->track_id, 'user', Auth::user()->employee, $target_id_for_notification->target_user_id, 'user', 'You have a document to receive with tracking number : '.$request->track_id.'.');

            /* Added by Montz */

            $update_doc_file = [
                'status' => 2,
            ];
            //doc_file::where(['track_number' =>  $request->track_id])->first()->update($update_doc_file);
        }

        return json_encode(array(
            "data"=>$data,
            "get_track"=>$get_track,
            "status" => 200,
        ));
    }



    public function hold_action(Request $request)
    {
        $data = $request->all();
        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function return_action(Request $request)
    {
        $data = $request->all();

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function multiple_action(Request $request)
    {
        $data = $request->all();



        if($request->modal_action == 6){
            $this->receive_multiple_action($request);

            __notification_set(1, "Received!", "Document Received Successfully!");
            add_log('track',$request->track_id,'Document Received Successfully!');


        }else if($request->modal_action == 8){
            $this->release_multiple_action($request);

            __notification_set(1, "Released!", "Document Released Successfully!");
            add_log('track',$request->track_id,'Document Released Successfully!');

        }else if($request->modal_action == 5){
            $this->hold_multiple_action($request);

            __notification_set(1, "Held!", "Document Held Successfully!");
            add_log('track',$request->track_id,'Document Held Successfully!');

        }else if($request->modal_action == 4){
            $this->return_multiple_action($request);

            __notification_set(1, "Returned!", "Document Returned Successfully!");
            add_log('track',$request->track_id,'Document Returned Successfully!');

        }else{

            __notification_set(1, "Error!", "Something went wrong!");
            add_log('track',$request->track_id,'Unknown Error!');
        }






        return json_encode(array(
            "data"=>$data,
        ));
    }



    function receive_multiple_action($request)
    {
        $trail_id = null;
        $created_by = null;
        $getDocTrack = doc_track::where('track_number',$request->track_id)->where('target_user_id',Auth::user()->employee)->where('action',0)->get();

        if($getDocTrack){
            foreach($getDocTrack as $track){
                if(!$track->doc_trail_id == null){
                    $trail_id = $track->doc_trail_id;
                    $update_trail= [
                        'receive_date' => now(),
                    ];
                    doc_trail::where(['id' =>  $track->doc_trail_id])->first()->update($update_trail);

                    /* Added by Montz */
                    $created_by = doc_trail::where('track_number', $request->track_id)->first();

                    $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
                    $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;

                    /* Created Notification for document receive */
                    createNotification('document_receive', $request->track_id, 'user', Auth::user()->employee, $created_by->created_by, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been received by '.$holder_fullname.'.');
                    /* Added by Montz */

                }
                $update_track= [
                    'action' => '1',
                    'seen' => '1',
                    'last_activity' => false,
                ];
                doc_track::where(['id' =>  $track->id])->first()->update($update_track);
            }
            $get_active = doc_track::where('last_activity',1)->where('track_number',$request->track_id)->get();
            if( $get_active){
                foreach($get_active->where('target_user_id', Auth::user()->employee) as $track_last_active){
                    $update_track= [
                        'action' => '1',
                        'seen' => '1',
                        'last_activity' => false,
                    ];
                    doc_track::where(['id' =>  $track_last_active->id])->first()->update($update_track);
                }
            }
            $from ='';
            if($request->has('emp_List')){
                foreach($request->emp_List as $key => $user_id){
                    $from = $user_id;
                }

            }

            $add_receive_track = [
                'track_number' => $request->track_id,
                'doc_trail_id' => $trail_id,
                'type' => $request->model_ass_type,
                'type_id' => $request->model_as,
                'target_user_id' =>Auth::user()->employee,
                'note' => $request->modal_message,
                'for_status' => 6,
                'created_by' => Auth::user()->employee,
                'target_type' => null,
                'target_id' => null,
                'last_activity' => true,
                'has_qr_id' => $request->modal_scan_id_from,
                'from_to_user_id' => $from,
            ];
            $track_id = doc_track::create($add_receive_track)->id;

            $update_doc_file = [
                'holder_id' => $request->model_as,
                'holder_type' => $request->model_ass_type,
                'holder_user_id' => Auth::user()->employee,
                'status' => 2,
            ];
            doc_file::where(['track_number' =>  $request->track_id])->first()->update($update_doc_file);

            $get_document = doc_file::where('track_number',$request->track_id)->first();
            $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
            $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;

            createNotification('document_receive', $request->track_id, 'user', Auth::user()->employee, $get_document->created_by, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been received by '.$holder_fullname.'.');
        }else{
            $getDoc = doc_file::where('track_number',$request->track_id)->first();

            $get_active = doc_track::where('last_activity',1)->where('track_number',$request->track_id)->get();
            foreach($get_active->where('target_user_id', Auth::user()->employee) as $track_last_active){
                $update_track= [
                    'action' => '1',
                    'seen' => '1',
                    'last_activity' => false,
                ];
                doc_track::where(['id' =>  $track_last_active->id])->first()->update($update_track);
            }

            if($request->has('emp_List')) {

                foreach($request->emp_List as $key => $user_id){
                    $add_receive_track = [
                        'track_number' => $request->track_id,
                        'doc_trail_id' => $trail_id,
                        'type' => $request->model_ass_type,
                        'type_id' => $request->model_as,
                        'target_user_id' =>Auth::user()->employee,
                        'note' => $request->modal_message,
                        'for_status' => 6,
                        'created_by' => Auth::user()->employee,
                        'target_type' => null,
                        'target_id' => null,
                        'last_activity' => true,
                        'has_qr_id' => $request->modal_scan_id_from,
                        'from_to_user_id' => $user_id,
                    ];
                    $track_id = doc_track::create($add_receive_track)->id;
                }
            }


            $update_doc_file = [
                'holder_id' => $request->model_as,
                'holder_type' => $request->model_ass_type,
                'holder_user_id' => Auth::user()->employee,
                'status' => 2,

            ];
            doc_file::where(['track_number' =>  $request->track_id])->first()->update($update_doc_file);

            $get_document = doc_file::where('track_number',$request->track_id)->first();
            $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
            $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;

            createNotification('document_receive', $request->track_id, 'user', Auth::user()->employee, $get_document->created_by, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been received by '.$holder_fullname.'.');
        }

    }
    function release_multiple_action($request)
    {

        $getDocTrack = doc_track::where('track_number',$request->track_id)->where('target_user_id',Auth::user()->employee)->where('action',0)->get();

        if($getDocTrack){
            foreach($getDocTrack as $track){
                $update_track= [
                    'action' => '1',
                    'seen' => '1',
                    'last_activity' => false,
                ];
                doc_track::where(['id' =>  $track->id])->first()->update($update_track);
            }
        }

        $getDoc = doc_file::where('track_number',$request->track_id)->first();

        if($getDoc){
            $update_sub_trail= [
                'release_date' => now(),
            ];
            $checktrail  = doc_trail::where('track_number',$request->track_id)->where('target_user_id',$getDoc->holder_user_id)->first();
            if($checktrail ){
                doc_trail::where(['track_number' =>  $request->track_id, 'target_user_id' =>  $getDoc->holder_user_id])->first()->update($update_sub_trail);

            }
        }


        /* Added by Montz */
        $created_by = doc_trail::where('track_number', $request->track_id)->first();
        if($created_by ){
            $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
            $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;
            /* Created Notification for document release */
            createNotification('document_release', $request->track_id, 'user', Auth::user()->employee, $created_by->created_by, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been released by '.$holder_fullname.'.');

            /* Added by Montz */
        }


        $get_track = doc_track::where('for_status',6)->where('target_user_id',Auth::user()->employee)->first();

        if($get_track ){
            $update_track= [
                'action' => 1,
                'seen' => 1,
                'last_activity' => false,
            ];
            doc_track::where(['id' =>  $get_track->id])->first()->update($update_track);
        }

        $get_trail = doc_trail::where('track_number',$request->track_id)->where('target_user_id',$request->swal_release_to)->where('receive_date',null)->where('release_date',null)->first();

        if($get_trail){
            $add_incoming_track = [
                'track_number' => $request->track_id,
                'doc_trail_id' => $get_trail->id,
                'type' => $request->model_ass_type,
                'type_id' => $request->model_as,
                'target_user_id' =>$request->swal_release_to,
                'note' => $request->modal_message,
                'for_status' => 3,
                'created_by' => Auth::user()->employee,
                'target_type' => null,
                'target_id' => null,
                'last_activity' => true,
                'has_qr_id' => $request->modal_scan_id_from,
                'from_to_user_id' => $request->emp_List,
            ];
            $track_id = doc_track::create($add_incoming_track)->id;



            /* Added by Montz */
            $target_id_for_notification = doc_track::where('target_user_id', $request->swal_release_to)->first();
            /* Created Notification for document release and send to another user */
            createNotification('document_release', $request->track_id, 'user', Auth::user()->employee, $target_id_for_notification->target_user_id, 'user', 'You have a document to released with tracking number : '.$request->track_id.'.');

            /* Added by Montz */

        }else{

            $get_active = doc_track::where('last_activity',1)->where('track_number',$request->track_id)->get();
            if( $get_active){
                foreach($get_active->where('target_user_id', Auth::user()->employee) as $track_last_active){
                    $update_track= [
                        'action' => '1',
                        'seen' => '1',
                        'last_activity' => false,
                    ];
                    doc_track::where(['id' =>  $track_last_active->id])->first()->update($update_track);
                }
            }

            if($request->has('emp_List')) {

                foreach($request->emp_List as $key => $user_id){

                    $add_receive_track = [
                        'track_number' => $request->track_id,
                        'doc_trail_id' => null,
                        'type' => $request->model_ass_type,
                        'type_id' => $request->model_as,
                        'target_user_id' => $user_id,
                        'note' => $request->modal_message,
                        'for_status' => 3,
                        'created_by' => Auth::user()->employee,
                        'target_type' => null,
                        'target_id' => null,
                        'last_activity' => true,
                        'has_qr_id' => $request->modal_scan_id_from,
                        'from_to_user_id' => $user_id,
                    ];
                    $track_id = doc_track::create($add_receive_track)->id;

                    /* Added by Montz */
                    $target_id_for_notification = doc_track::where('target_user_id', $request->emp_List)->first();

                    /* Created Notification for document release and send to another user */
                    createNotification('document_receive', $request->track_id, 'user', Auth::user()->employee, $user_id, 'user', 'You have a document to receive with tracking number : '.$request->track_id.'.');

                    /* Added by Montz */
                }
            }


            $update_doc_file = [
                'status' => 2,
            ];
            doc_file::where(['track_number' =>  $request->track_id])->first()->update($update_doc_file);

            //creator adminNotification

            $get_document = doc_file::where('track_number',$request->track_id)->first();
            $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
            $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;

            createNotification('document_release', $request->track_id, 'user', Auth::user()->employee, $get_document->created_by, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been released by '.$holder_fullname.'.');
        }
    }
    function hold_multiple_action($request)
    {

        $getDocTrack = doc_track::where('track_number',$request->track_id)->where('target_user_id',Auth::user()->employee)->where('action',0)->get();

        if($getDocTrack){
            foreach($getDocTrack as $track){
                $update_track= [
                    'action' => '1',
                    'seen' => '1',
                    'last_activity' => false,
                ];
                doc_track::where(['id' =>  $track->id])->first()->update($update_track);
            }
        }


        $get_active = doc_track::where('last_activity',1)->where('track_number',$request->track_id)->get();
            if( $get_active){
                foreach($get_active->where('target_user_id', Auth::user()->employee) as $track_last_active){
                    $update_track= [
                        'action' => '1',
                        'seen' => '1',
                        'last_activity' => false,
                    ];
                    doc_track::where(['id' =>  $track_last_active->id])->first()->update($update_track);
                }
            }


            $from ='';
            if($request->has('emp_List')){
                foreach($request->emp_List as $key => $user_id){
                    $from = $user_id;
                }

            }

            $add_receive_track = [
                'track_number' => $request->track_id,
                'doc_trail_id' => null,
                'type' => $request->model_ass_type,
                'type_id' => $request->model_as,
                'target_user_id' => Auth::user()->employee,
                'note' => $request->modal_message,
                'for_status' => 5,
                'created_by' => Auth::user()->employee,
                'target_type' => null,
                'target_id' => null,
                'last_activity' => true,
                'has_qr_id' => $request->modal_scan_id_from,
                'from_to_user_id' => $from,
            ];
            $track_id = doc_track::create($add_receive_track)->id;

            /* Added by Montz */

            /* Created Notification for document release and send to another user */
            createNotification('document_hold', $request->track_id, 'user', Auth::user()->employee, Auth::user()->employee, 'user', 'You have held the document with tracking number : '.$request->track_id.'.');

            /* Added by Montz */


            $update_doc_file = [
                'status' => 5,
                'holder_id' => $request->model_as,
                'holder_type' => $request->model_ass_type,
                'holder_user_id' => Auth::user()->employee,
            ];
            doc_file::where(['track_number' =>  $request->track_id])->first()->update($update_doc_file);


            //creator adminNotification
            $get_document = doc_file::where('track_number',$request->track_id)->first();
            $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
            $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;

            createNotification('document_hold', $request->track_id, 'user', Auth::user()->employee, $get_document->created_by, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been held by '.$holder_fullname.'.');
    }
    function return_multiple_action($request)
    {
        $getDocTrack = doc_track::where('track_number',$request->track_id)->where('target_user_id',Auth::user()->employee)->where('action',0)->get();


        if($getDocTrack){
            foreach($getDocTrack as $track){
                $update_track= [
                    'action' => '1',
                    'seen' => '1',
                    'last_activity' => false,
                ];
                doc_track::where(['id' =>  $track->id])->first()->update($update_track);
            }
        }

            $doc_org = doc_file::where('track_number',$request->track_id)->first();
            $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
            $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;
            /* Created Notification for document release */
            createNotification('document_return', $request->track_id, 'user', Auth::user()->employee, $doc_org->created_by, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been returned by '.$holder_fullname.'.');

            /* Added by Montz */


            $get_active = doc_track::where('last_activity',1)->where('track_number',$request->track_id)->get();
            if( $get_active){
                foreach($get_active->where('target_user_id', Auth::user()->employee) as $track_last_active){
                    $update_track= [
                        'action' => '1',
                        'seen' => '1',
                        'last_activity' => false,
                    ];
                    doc_track::where(['id' =>  $track_last_active->id])->first()->update($update_track);
                }
            }

            $to = $doc_org->created_by;
            if($request->has('emp_List')){
                foreach($request->emp_List as $key => $user_id){
                    $to = $user_id;

                }
               //creator adminNotification
            $get_document = doc_file::where('track_number',$request->track_id)->first();
            $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
            $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;

            createNotification('document_hold', $request->track_id, 'user', Auth::user()->employee, $to, 'user', 'Your document with a tracking number : ' . $request->track_id . ' has been returned by '.$holder_fullname.'.');
            }

            $add_receive_track = [
                'track_number' => $request->track_id,
                'doc_trail_id' => null,
                'type' => $request->model_ass_type,
                'type_id' => $request->model_as,
                'target_user_id' => $to,
                'note' => $request->modal_message,
                'for_status' => 4,
                'created_by' => Auth::user()->employee,
                'target_type' => null,
                'target_id' => null,
                'last_activity' => true,
                'has_qr_id' => $request->modal_scan_id_from,
                'from_to_user_id' =>  $to,
            ];
            $track_id = doc_track::create($add_receive_track)->id;




            /* Added by Montz */
            $target_id_for_notification = doc_track::where('target_user_id', $request->emp_List)->first();

            /* Created Notification for document release and send to another user */
            createNotification('document_return', $request->track_id, 'user', Auth::user()->employee,Auth::user()->employee, 'user', 'You have returned the document with tracking number : '.$request->track_id.'.');

            /* Added by Montz */

            $update_doc_file = [
                'status' => 4,
                'holder_id' => $to,
                'holder_type' => 'user',
                'holder_user_id' => $to,
            ];
            doc_file::where(['track_number' =>  $request->track_id])->first()->update($update_doc_file);

    }


}
