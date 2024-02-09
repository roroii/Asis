<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\document\doc_file_track;
use App\Models\document\doc_file_trail;
use App\Models\document\doc_track;
use App\Models\document\doc_trail;
use App\Models\employee_hr_details;
use App\Models\tblemployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class IncomingController extends Controller
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


    public function incoming()
    {

        return view('Documents.Incoming');
    }

    public function incoming_Docs()
    {
        $userID = Auth::user()->employee;

        $tres = [];


        $incomingDocs = doc_track::
        with(['getDocDetails.getDocType',
        'getDocDetails.getDocLevel',
        'getDocDetails.getDocTypeSubmitted',
        'getDocDetails.getDocStatus',
        'getDocDetails.getAuthor',
        'getSender_Details'])
        ->where('active', 1)
        ->where('for_status', 3)
        ->where('action', 0)
        ->where('target_user_id', Auth::user()->employee)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->unique('track_number');

        foreach ($incomingDocs as $dt) {
            $td = [

                "id" => $dt->getDocDetails->id,
                "track_id" => $dt->id,
                "track_number" => $dt->getDocDetails->track_number,
                "name" => $dt->getDocDetails->name,
                "desc" => $dt->getDocDetails->desc,
                "status" => $dt->getDocStatus->name,
                "class" => $dt->getDocStatus->class,
                "type" => $dt->getDocDetails->getDocType->doc_type,
                "level" => $dt->getDocDetails->getDocLevel->doc_level,
                "level_class" => $dt->getDocDetails->getDocLevel->class,
                "type_submitted" => $dt->getDocDetails->getDocTypeSubmitted->type,
                "created_by" => $dt->created_by,
                "created_at" => $dt->created_at,
                "note" => $dt->note,
                "author" => $dt->getDocDetails->getAuthor->firstname." ".$dt->getDocDetails->getAuthor->lastname,
                "sender" => $dt->getSender_Details->firstname." ".$dt->getSender_Details->lastname,
                "action" => $dt->action,
                "seen" => $dt->seen,
            ];
            $tres[count($tres)] = $td;

        }

        $getdocfile = doc_file::
        with('getTrackdetails.getDocDetails.getDocType',
        'getTrackdetails.getDocDetails.getDocLevel',
        'getTrackdetails.getDocDetails.getDocTypeSubmitted',
        'getTrackdetails.getDocDetails.getDocStatus')
        ->where('active',1)
        ->where('holder_user_id', Auth::user()->employee)
        ->get()
        ->unique('doc_file_id');
        foreach ($getdocfile as $doc) {
            foreach ($doc->getTrackdetails->where('user_id',Auth::user()->employee)->where('action_taken',0) as $doc_track) {
                $td = [
                    "id" => $doc_track->getDocDetails->id,
                    "track_number" => $doc_track->getDocDetails->track_number,
                    "name" => $doc_track->getDocDetails->name,
                    "desc" => $doc_track->getDocDetails->desc,
                    "status" => $doc_track->getDocStatus->name,
                    "class" => $doc_track->getDocStatus->class,
                    "type" => $doc_track->getDocDetails->getDocType->doc_type,
                    "level" => $doc_track->getDocDetails->getDocLevel->doc_level,
                    "level_class" => $doc_track->getDocDetails->getDocLevel->class,
                    "type_submitted" => $doc_track->getDocDetails->getDocTypeSubmitted->type,
                    "created_by" => $doc_track->created_by,
                    "created_at" => $doc_track->created_at,
                ];
                //$tres[count($tres)] = $td;
            }
            # code...
        }
        //dd($getdocfile );

        echo json_encode($tres);

    }


    public function take_action(Request $request)
    {
        $data = $request->all();
        $trail_id = null;
        $created_by = null;

        $getDocTrack = doc_track::where('track_number',$request->docID)->get();
        if($getDocTrack){
            foreach($getDocTrack->where('for_status',3)->where('target_user_id',Auth::user()->employee) as $track){
                if(!$track->doc_trail_id == null){
                    $trail_id = $track->doc_trail_id;
                    $update_trail= [
                        'receive_date' => now(),
                    ];
                    doc_trail::where(['id' =>  $track->doc_trail_id])->first()->update($update_trail);

                    /* Added by Montz */
                    $created_by = doc_trail::where('track_number', $request->docID)->first();

                    $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
                    $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;

                    /* Created Notification for document receive */
                    createNotification('document_receive', $request->docID, 'user', Auth::user()->employee, $created_by->created_by, 'user', 'Your document with a tracking number : ' . $request->docID . ' has been received by '.$holder_fullname.'.');
                    /* Added by Montz */

                }
                $update_track= [
                    'action' => '1',
                    'seen' => '1',
                    'last_activity' => false,
                ];
                doc_track::where(['id' =>  $track->id])->first()->update($update_track);
            }

            $add_receive_track = [
                'track_number' => $request->docID,
                'doc_trail_id' => $trail_id,
                'type' => $request->doc_sendAstype,
                'type_id' => $request->doc_sendAs,
                'target_user_id' =>Auth::user()->employee,
                'note' => $request->note,
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
            ];
            doc_file::where(['track_number' =>  $track->track_number])->first()->update($update_doc_file);
        }


        //__notification_set(1, "Document Received Successfully", "View your received files at the receive section!");
        return json_encode(array(
            "data"=>$data,
            "status" => 200
        ));
    }


    function firstAction($request){
        $data = $request->all();
        $getDoc = doc_file::where('track_number',$request->docID)->where('active',1)->first();
        $action = '';

        //take action to track
        $getDoctrack = doc_file_track::where('doc_file_id',$request->docID)->where('user_id',Auth::user()->employee)->where('active',1)->where('action',0)->get();
        foreach($getDoctrack as $track){
            $update_track= [
                'action_taken' => $request->action,
                'action' => '1',
                'seen' => '1',
            ];
            doc_file_track::where(['id' =>  $track->id])->first()->update($update_track);
        }


        if($request->action == '6'){
            //receive
            $action = '0';




        }elseif($request->action == '8'){
            //hold
            $action = '0';



        }elseif($request->action == '5'){
            //hold
            $action = '0';



        }else{
            //return
            $action = '1';


        }

        //update document
        if( $getDoc->type_submitted  == 2 || $getDoc->type_submitted  == 3 || $getDoc->send_via == 1){
            $update_doc= [
                'status' => '2',
                'holder_type' => 'user',
                'holder_id' => Auth::user()->employee,
                'holder_user_id' => Auth::user()->employee,
            ];
            doc_file::where(['track_number' =>  $request->docID])->first()->update($update_doc);
        }



        if ($request->has('docID')) {

            $add_empTracks = [
                'doc_file_id' => $request->docID,
                'track_number' => $request->docID,
                'type' => 'user',
                'type_id' => Auth::user()->employee,
                'status' => $request->action,
                'user_id' => Auth::user()->employee,
                'note' => $request->note,
                'created_by' => Auth::user()->employee,
                'action_taken' => $request->action,
                'action' =>  $action ,
                'seen' => '1',
            ];
            doc_file_track::create($add_empTracks);
        }




        return json_encode(array(
            "data"=>$data,
            "getDoc"=>$getDoc,
        ));
    }

    public function incoming_docDetails(Request $request)
    {
        $docID = $request->docID;
        $tres = [];
        $user_ = '';

        $incomingDocDetails = doc_track::with(['getDocDetails', 'getDocStatus', 'get_Author'])
        ->where('track_number', $docID)->where('active', true)
        ->where('for_status', 3)->where('action', 0)
        ->where('target_user_id', Auth::user()->employee)
        ->get();

        foreach ($incomingDocDetails as $dt) {

            $update_track = [
                'seen' => '1',
            ];

            doc_track::where('id',  $dt->id)->update($update_track);


            if($dt->type == "position")
            {
                $user_ = $dt->get_Author->firstname.' '.$dt->get_Author->lastname;
            }
            if($dt->type == "user")
            {
                $user_ = $dt->get_Author->firstname.' '.$dt->get_Author->lastname;
            }
            if($dt->type == "desig")
            {
                $user_ = $dt->get_Author->firstname.' '.$dt->get_Author->lastname;
            }
            if($dt->type == "rc")
            {
                $user_ = $dt->get_Author->firstname.' '.$dt->get_Author->lastname;
            }
            if($dt->type == "group")
            {
                $user_ = $dt->get_Author->firstname.' '.$dt->get_Author->lastname;
            }

            if( $dt->getDocDetails)
            {
                $doc_id = $dt->getDocDetails->id;
                $track_number = $dt->getDocDetails->track_number;
                $name = $dt->getDocDetails->name;
                $desc = $dt->getDocDetails->desc;
                $active = $dt->getDocDetails->active;


                if($dt->getDocDetails->getDocType)
                {
                    $doc_type = $dt->getDocDetails->getDocType->doc_type;
                }else
                {
                    $doc_type = 'Not Set';
                }

                if($dt->getDocDetails->getDocLevel)
                {
                    $desc_level = $dt->getDocDetails->getDocLevel->desc;
                    $level = $dt->getDocDetails->getDocLevel->doc_level;
                    $level_class =  $dt->getDocDetails->getDocLevel->class;
                }else
                {
                    $desc_level = 'Not Set';
                    $level = 'Not Set';
                }

                if($dt->getDocStatus)
                {
                    $doc_status = $dt->getDocStatus->name;
                    $doc_status_class = $dt->getDocStatus->class;
                }else
                {
                    $doc_status = 'Not Set';
                    $doc_status_class = 'Not Set';
                }

            }

            $td = [
                "id" => $doc_id,
                "track_number" => $track_number,
                "name" => $name,
                "desc" => $desc,
                "type" => $doc_type,
                "desc_level" => $desc_level,
                "level" => $level,
                "class_level" => $level_class,
                "status" => $doc_status,
                "class" => $doc_status_class,
                "active" => $active,
                "type_submitted" => $dt->getDocDetails->getDocTypeSubmitted->type,
                "__from" => $user_,
                "note" => $dt->note,

            ];
            $tres[count($tres)] = $td;
        }
        //$getdocfile = doc_file::with('getTrackdetails')->where('active',1)->where('send_via', 1)->where('holder_user_id', Auth::user()->employee)->get();



        echo json_encode($tres);

        //        dd($tres);
    }

    public function load_document_details(Request $request)
    {
        $data = $request->all();
        $option_1 = get_option_for_release();
        $getDoc = doc_file::where('track_number',$request->docID)->where('active', 1)->first();
        $release_to = '';

        $get_trail = doc_trail::tree()->where('track_number',$request->docID);


        $release_to = release_to(doc_trail::tree()->where('track_number',$request->docID),$request->docID);




        return json_encode(array(
            "data"=>$data,
            "getDoc"=>$getDoc,
            "option_Value"=>$option_1,
            "release_to"=>$release_to,
            "get_trail"=>$get_trail,
        ));
    }
}
