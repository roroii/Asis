<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\document\doc_file_track;
use App\Models\document\doc_file_trail;
use App\Models\document\doc_trail;
use App\Models\document\doc_user_rc_g;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class snippetController extends Controller
{
    //incoming doc
    public function load_document_details(Request $request)
    {
        $data = $request->all();

        $option_1 = get_option_for_release();
        $release_to = '';
        $created_at = '';
        //$option_2 = get_option_for_release_users();

        $getDoc = doc_file::where('track_number',$request->docID)->first();

        $userID = Auth::user()->employee;

        $trail = doc_file_trail::with('get_sub_trail')->where('doc_file_id',$request->docID)->where('currently_file_holder',1)->first();

        if( $trail){

            if($trail->get_sub_trail()->exists()){

                $sub_trail = $trail->get_sub_trail()->where('action',0)->where('release_date',null)->where('active',1)->first();

                $userFullName = loaduser($sub_trail->user_id)->getUserinfo->firstname." ".loaduser($sub_trail->user_id)->getUserinfo->lastname;
                $release_to .=  '<option value="'.$sub_trail->user_id .'">'.$userFullName.'</option>';
            }else{
                $trail = doc_file_trail::with('get_sub_trail')->where('doc_file_id',$request->docID)->where('action',0)->where('active',1)->first();
                if($trail->end_trail == 1){
                    $userFullName = loaduser($getDoc->created_by)->getUserinfo->firstname." ".loaduser($getDoc->created_by)->getUserinfo->lastname;
                    $release_to .=  '<option value="'.$getDoc->created_by .'">'.$userFullName.'</option>';
                }else{
                    $userFullName = loaduser($trail->user_id)->getUserinfo->firstname." ".loaduser($trail->user_id)->getUserinfo->lastname;
                    $release_to .=  '<option value="'.$trail->user_id .'">'.$userFullName.'</option>';
                }

            }

        }else{
            $release_to .=  '<option value="e404">No user found!</option>';
        }
        $created_at =  $getDoc->created_at->diffForHumans();



        return json_encode(array(
            "data"=>$data,
            "trail"=>$trail,
            "getDoc"=>$getDoc,
            "userID" => $userID,
            "option_Value" => $option_1,
            "release_to" => $release_to,
            "created_at" => $created_at,


        ));
    }

    //mydoc
    public function TrailSend_Docs(Request $request)
    {
        $data = $request->all();
        if($request->has('sendToEmps'))
        {
            foreach ($request->sendToEmps as $arry_id => $user_id) {

                //get last user in the array to mark as the end of the trail and complete the file status
                $lastkey = count($request->sendToEmps) - 1;
                $end_of_trail = '0';

                if($arry_id==$lastkey){
                    $end_of_trail = '1';
                }

                //add first file holder
                if($arry_id==0){
                    $getdocfile = doc_file::where('track_number',$request->docID)->where('active',1)->first();
                    //add currunt file holder add the first in the trail
                    $add_Trail = [
                        'doc_file_id' => $request->docID,
                        'track_number' => $request->docID,
                        'user_id' => $user_id,
                        'to' => $user_id,
                        'from' => $request->senderID,
                        'expected_release_date' => $request->expected_release_date,
                        'expected_receive_date' => $request->expected_receive_date,
                        'currently_file_holder' => '1',
                    ];
                    $trail_id = doc_file_trail::create($add_Trail)->id;

                    //add the track to display to the incoming files
                    $add_empTracks = [
                        'doc_file_id' => $request->docID,
                        'track_number' => $request->docID,
                        'receive_date' => $request->receive_date,
                        'type' => 'user',
                        'type_id' => $user_id,
                        'status' => 3,
                        'user_id' => $user_id,
                        'note' => $request->note,
                        'ass_from'=> $request->senderID,
                        'ass_from_type' => $request->__from,
                        'end_of_trail' => $end_of_trail,
                        'send_via' => '1',
                        'created_by' => Auth::user()->employee,
                        'doc_file_trail_id' => $trail_id,
                    ];
                    doc_file_track::create($add_empTracks);

                    //update the file status and holder
                    $update_doc_file = [
                        'send_via' => '1',
                        'status' => '2',
                        'holder_user_id' => Auth::user()->employee,
                    ];
                    //doc_file::where(['id' =>  $getdocfile->id])->first()->update($update_doc_file);

                }else{
                    //add the other user to be the receiver
                    $add_Trail = [
                        'doc_file_id' => $request->docID,
                        'track_number' => $request->docID,
                        'user_id' => $user_id,
                        'end_trail' =>  $end_of_trail,
                    ];
                    doc_file_trail::create($add_Trail);
                }

            }




        }


        return json_encode(array(
            "data"=>$data,
        ));
    }

    //take action incoming to receive
    public function take_action(Request $request)
    {
        $data = $request->all();
        $end_of_trail = '0';
        $update_status = '2';
        $send_via = 0;
        $trail_id = '';

        $get_doc = doc_file::where('track_number',$request->docID)->first();

        $getDocTrack = doc_file_track::where('track_number',$request->docID)->get();

        if($getDocTrack){
            foreach($getDocTrack->where('status',3)->where('user_id',Auth::user()->employee) as $track){

                $update_track= [
                    'action_taken' => $request->action,
                    'action' => '1',
                    'seen' => '1',
                ];
                doc_file_track::where(['id' =>  $track->id])->first()->update($update_track);

                $update_trail= [
                    'receive_date' => now(),
                ];
                doc_file_trail::where(['id' =>  $track->doc_file_trail_id])->first()->update($update_trail);


                $trail_id = $track->doc_file_trail_id;
                $send_via = $track->send_via;

                if($track->end_trail == 1){
                    $update_status = '7';
                    $end_of_trail = '1';
                }

                $update_doc_file = [
                    'status' => $update_status,
                    'holder_id' => $request->doc_sendAs,
                    'holder_type' => $request->doc_sendAstype,
                    'holder_user_id' => Auth::user()->employee,
                ];
                doc_file::where(['track_number' =>  $track->track_number])->first()->update($update_doc_file);
            }

            //add the track to display to the incoming files
            $add_Track = [
                'doc_file_id' => $request->docID,
                'track_number' => $request->docID,
                'receive_date' => now(),
                'type' => $request->doc_sendAstype,
                'type_id' =>$request->doc_sendAs,
                'status' => 6,
                'user_id' => Auth::user()->employee,
                'note' => $request->note,
                'created_by' => Auth::user()->employee,
                'send_via' =>  $get_doc->send_via,
                'doc_file_trail_id' => $trail_id,
            ];
            doc_file_track::create($add_Track);
        }


        __notification_set(1, "Document Received Successfully", "View your received files at the receive section!");
        return json_encode(array(
            "data"=>$data,

        ));
    }

    //load receive trail
    public function load_trail(Request $request){
        $data = $request->all();

        $release_to = '';
        $created_at = '';
        $userFullName = '';
        $holder = '';
        $getDoc = doc_file::where('track_number',$request->docID)->first();

        $userID = Auth::user()->employee;

        $trail_holder = doc_file_trail::with('get_sub_trail.get_user')->where('doc_file_id',$request->docID)->where('currently_file_holder',1)->first();

                $trails = doc_file_trail::with('get_sub_trail.get_user','get_user')->where('doc_file_id',$request->docID)->where('doc_file_trail_id',null)->where('active',1)->get();
                foreach ($trails as $trail) {

                    //$userFullName = loaduser($trail->user_id)->getUserinfo->firstname." ".loaduser($trail->user_id)->getUserinfo->lastname;
                    $holder = '';
                    if($trail->currently_file_holder == 1){
                        $holder = 'Holder';
                    }

                    $release_to .=  '<div class="intro-x zoom-in">
                    <div class="box px-5 py-3 mb-3  flex items-center zoom-in">

                        <div class="ml-20 mr-auto ">
                            <div class="font-medium">'.$trail->get_user->firstname.' '.$trail->get_user->lastname.'</div>
                            <div class="text-slate-500 text-xs mt-0.5">3 June 2020</div>
                        </div>
                        <div class="text-success">'.$holder.'</div>
                    </div>';
                    if($trail->get_sub_trail()->exists()){


                        foreach ($trail->get_sub_trail->where('active',1) as $index => $sub_trail) {
                            $holder = '';
                            $del = '';
                            if($sub_trail->currently_file_holder == 1){
                                $holder = 'Holder';
                            }
                            if($trail_holder->id ==  $sub_trail->doc_file_trail_id && $trail_holder->user_id == Auth::user()->employee){
                                $del = '<button type="button" class="btn btn-outline-secondary rc_members_deleterow"><i class="fa fa-trash text-danger"></i></button>';
                            }

                            $release_to .= '<div class="box px-5 py-3 mb-3 flex items-center zoom-in">

                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">'.$sub_trail->get_user->firstname.' '.$sub_trail->get_user->lastname.'</div>
                                    <div class="text-slate-500 text-xs mt-0.5">3 June 2020</div>
                                </div>
                                <div class="text-success">'.$holder.'</div>
                                <div class="text-danger">'.$del.'</div>
                            </div>';

                        }
                    }

            '</div>';
                }




        return json_encode(array(
            "release_to"=>$release_to,
        ));

    }

    //receive action
    public function release_action(Request $request)
    {
        $data = $request->all();

        $getDoc = doc_file::where('track_number',$request->docID)->first();

        $current_trail = doc_file_trail::with('get_sub_trail')->where('doc_file_id',$request->docID)->where('currently_file_holder',1)->first();

        if($current_trail){
            if($current_trail->get_sub_trail()->exists()){
                //release
                $get_sub_trail = $current_trail->get_sub_trail()->where('currently_file_holder',0)->where('active',1)->first();
                $update_sub_trail= [
                    'release_date' => now(),
                    'currently_file_holder' => 1,
                    'action' => 1,
                ];
                doc_file_trail::where(['id' =>  $get_sub_trail->id])->first()->update($update_sub_trail);

                $update_doc_file = [
                    'holder_type' => $request->doc_sendAstype,
                    'holder_id' => $request->doc_sendAs,
                    'holder_user_id' => Auth::user()->employee,
                ];

                //add track
                $add_empTracks = [
                    'doc_file_id' => $request->docID,
                    'track_number' => $request->docID,
                    'type' => 'user',
                    'type_id' => $get_sub_trail->user_id,
                    'status' => 3,
                    'user_id' => $request->swal_release_to,
                    'note' => $request->swal_release_textarea,
                    'ass_from'=> $request->doc_sendAs,
                    'ass_from_type' => $request->doc_sendAstype,
                    'end_of_trail' => $get_sub_trail->end_trail,
                    'send_via' => $getDoc->send_via,
                    'created_by' => Auth::user()->employee,
                    'doc_file_trail_id' => $get_sub_trail->id,
                ];
                doc_file_track::create($add_empTracks);


            }else{
                //release
                $next_trail = doc_file_trail::where('doc_file_id',$request->docID)->where('currently_file_holder',0)->where('active',1)->first();
                $update_next_trail= [
                    'release_date' => now(),
                    'currently_file_holder' => 1,
                    'action' => 1,
                ];
                doc_file_trail::where(['id' =>  $next_trail->id])->first()->update($update_next_trail);

                $update_doc_file = [
                    'holder_type' => $request->doc_sendAstype,
                    'holder_id' => $request->doc_sendAs,
                    'holder_user_id' => Auth::user()->employee,
                ];

                //add track
                $add_empTracks = [
                    'doc_file_id' => $request->docID,
                    'track_number' => $request->docID,
                    'type' => 'user',
                    'type_id' => $next_trail->user_id,
                    'status' => 3,
                    'user_id' => $request->swal_release_to,
                    'note' => $request->swal_release_textarea,
                    'ass_from'=> $request->doc_sendAs,
                    'ass_from_type' => $request->doc_sendAstype,
                    'end_of_trail' => $next_trail->end_trail,
                    'send_via' => $getDoc->send_via,
                    'created_by' => Auth::user()->employee,
                    'doc_file_trail_id' => $next_trail->id,
                ];
                doc_file_track::create($add_empTracks);



            }

            $update_current_track= [
                            'release_date' => now(),
                            'currently_file_holder' => 0,
                            'action' => 1,
                        ];
            doc_file_trail::where(['id' =>  $current_trail->id])->first()->update($update_current_track);


            doc_file::where(['track_number' =>  $getDoc->track_number])->first()->update($update_doc_file);

            $get_track = doc_file_track::where('doc_file_trail_id',$current_trail->id)->where('active',1)->where('action',0)->first();

            $update_track= [
                'action_taken' => $request->swal_release_action,
                'action' => '1',
                'seen' => '1',
            ];

            doc_file_track::where(['id' =>  $get_track->id])->first()->update($update_track);

            __notification_set(1, "Document Release Successfully", "File Released!");
        }else{
            //file complete

        }

        return json_encode(array(
            "data"=>$data,
        ));
    }

        //Send to all Documents
        function sendToAllEmployees($request)
        {
            $getAllUsers = User::has('getUserinfo')->where('active', 1)->get();

            foreach ($getAllUsers as $users) {

                $add_empTracks = [
                    'track_number' => $request->docID,
                    'receive_date' => $request->receive_date,
                    'type' => 'user',
                    'type_id' => $users->employee,
                    'status' => 3,
                    'user_id' => $users->employee,
                    'active' => true,
                    'note' => $request->note,
                    'ass_from'=> $request->senderID,
                    'ass_from_type' => $request->__from,
                    'created_by' => Auth::user()->employee,
                ];
                doc_file_track::create($add_empTracks);

                createNotification('document', $request->docID, 'user', Auth::user()->employee, $users->employee, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
            }
        }

        //Fast Send Documents
    public function FastSend_Docs(Request $request)
    {
        if ($request->has('employee') || $request->has('groups') || $request->has('RC') || $request->sendToAll == 1)
        {

            if($request->sendToAll == 1)
            {
                doc_file::where('track_number', $request->docID)->update([
                    'send_to_all' => 1,
                    'status' => 7,
                ]);

                $this->sendToAllEmployees($request);

            }else {

                //store User Tracks
                if ($request->has('employee')) {

                    foreach ($request->employee as $key => $user_id) {
                        $add_empTracks = [
                            'doc_file_id' => $request->docID,
                            'type' => 'user',
                            'type_id' => $user_id,
                            'status' => 3,
                            'user_id' => $user_id,
                            'active' => true,
                            'note' => $request->note,
                            'ass_from'=> $request->senderID,
                            'ass_from_type' => $request->__from,
                            'created_by' => Auth::user()->employee,
                        ];
                        doc_file_track::create($add_empTracks);

                        createNotification('document', $request->docID, 'user', Auth::user()->employee, $user_id, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
                    }
                }

                //store Group Tracks
                if ($request->groups) {
                    foreach ($request->groups as $key => $groupID) {

                        $getGroupID = doc_user_rc_g::where('type', 'group')->where('type_id', $groupID)->get();

                        foreach ($getGroupID as $grpID) {
                            $add_empTracks = [
                                'doc_file_id' => $request->docID,
                                'type' => 'group',
                                'type_id' => $groupID,
                                'status' => 3,
                                'user_id' => $grpID->user_id,
                                'active' => true,
                                'note' => $request->note,
                                'ass_from'=> $request->senderID,
                                'ass_from_type' => $request->__from,
                                'created_by' => Auth::user()->employee,
                            ];
                            doc_file_track::create($add_empTracks);

                            createNotification('document', $request->docID, 'user', Auth::user()->employee, $grpID->user_id, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
                        }
                    }
                }

                //store RC Tracks
                if ($request->RC) {
                    foreach ($request->RC as $key => $rc_id) {

                        $getRC_ID = doc_user_rc_g::where('type', 'rc')->where('type_id', $rc_id)->get();

                        foreach ($getRC_ID as $userID) {
                            $add_empTracks = [
                                'doc_file_id' => $request->docID,
                                'type' => 'rc',
                                'type_id' => $rc_id,
                                'status' => 3,
                                'user_id' => $userID->user_id,
                                'active' => true,
                                'note' => $request->note,
                                'ass_from'=> $request->senderID,
                                'ass_from_type' => $request->__from,
                                'created_by' => Auth::user()->employee,
                            ];
                            doc_file_track::create($add_empTracks);

                            createNotification('document', $request->docID, 'user', Auth::user()->employee, $userID->user_id, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
                        }
                    }
                }

            }
            if ($request->showAuthor == 1)
            {
                doc_file::where('track_number', $request->docID)->update([
                    'show_author' => 1,
                ]);
            }
            __notification_set(1,'Success','Document with Tracking #: '.$request->docID.' Send Successfully!');
            return response()->json([
                'status' => 200,
            ]);
        }else{
            __notification_set(-1, "Recipient is Empty!", "Please select either Employees, Groups or Responsibility Center!");
        }
    }

    public function add_trail(Request $request){
        $data = $request->all();

        $trail_holder = doc_file_trail::with('get_sub_trail.get_user')->where('doc_file_id',$request->docID)->where('currently_file_holder',1)->first();

        if($request->has('new_trail')) {
            foreach($request->new_trail as $key => $user_id){

                    $add_new_track = [
                        'doc_file_id' =>  $request->docID,
                        'track_number' =>  $request->docID,
                        'user_id' =>  $user_id,
                        'doc_file_trail_id' =>  $trail_holder->id,
                        'end_trail' =>  $user_id,
                    ];
                    doc_file_trail::create($add_new_track);
            }

            }

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function load_document_detailsv2(Request $request)
    {
        $data = $request->all();
        $option_1 = get_option_for_release();
        $getDoc = doc_file::where('track_number',$request->docID)->first();
        $release_to = '';

        $get_trail = doc_trail::where('track_number',$request->docID)->where('receive_date',null)->where('release_date',null)->first();


        if($get_trail){
            $userFullName = loaduser($get_trail->target_user_id)->getUserinfo->firstname." ".loaduser($get_trail->target_user_id)->getUserinfo->lastname;
            $release_to .=  '<option value="'.$get_trail->target_user_id .'">'.$userFullName.'</option>';

        }else{
            $userFullName = loaduser($getDoc->created_by)->getUserinfo->firstname." ".loaduser($getDoc->created_by)->getUserinfo->lastname;
            $release_to .=  '<option value="'.Auth::user()->employee .'">'.$userFullName.'</option>';
        }

        return json_encode(array(
            "data"=>$data,
            "getDoc"=>$getDoc,
            "option_Value"=>$option_1,
            "release_to"=>$release_to,

        ));
    }

    public function load_trailv2(Request $request){
        $data = $request->all();

        $release_to = '';
        $image_status = '';

        $get_trails = doc_trail::with('get_user','get_sub_trail.get_user','get_sub_sub_trail.get_user')
        ->where('track_number',$request->docID)
        ->where('active',1)
        ->where('trail_id',null)
        ->where('created_by','!=',Auth::user()->employee)
        ->get();


        foreach ($get_trails as $idx => $trail) {
            if(!$trail->receive_date == null && !$trail->release_date == null){
                $image_status = '<img alt="done" src="../dist/images/QuaintLikelyFlyingfish-max-1mb.gif">';
            }else if(!$trail->receive_date == null && $trail->release_date == null){
                $image_status = '<img alt="file holder" src="../dist/images/sun-energy.gif">';
            }else{
                $image_status = '<img alt="to load" src="../dist/images/80ZN.gif">';
            }

                $release_to .= '<div class="intro-x relative flex items-center mb-3">
                <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                        '. $image_status.'
                    </div>
                </div>
                <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                    <div class="flex items-center">
                        <div class="font-medium">'.$trail->get_user->firstname.' '.$trail->get_user->lastname.'</div>
                        <div class="text-xs text-slate-500 ml-auto">'.$trail->created_at.'</div>
                    </div>
                    <div class="text-slate-500 mt-1">Received: '.$trail->receive_date.'</div>
                    <div class="text-slate-500 mt-1">Released: '.$trail->release_date.'</div>
                </div>
            </div>

            ';


            if($trail->get_sub_trail()->exists() ){
            foreach ($trail->get_sub_trail  as $indx => $sub_trail) {

                if(!$sub_trail->receive_date == null && !$sub_trail->release_date == null){
                    $image_status = '<img alt="done" src="../dist/images/QuaintLikelyFlyingfish-max-1mb.gif">';
                }else if(!$sub_trail->receive_date == null && $sub_trail->release_date == null){
                    $image_status = '<img alt="file holder" src="../dist/images/sun-energy.gif">';
                }else{
                    $image_status = '<img alt="to load" src="../dist/images/80ZN.gif">';
                }
                $release_to .= '<div class="intro-x relative flex items-center mb-3">
                <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                        '. $image_status.'
                    </div>
                </div>
                <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                    <div class="flex items-center">
                        <div class="font-medium">'.$sub_trail->get_user->firstname.' '.$sub_trail->get_user->lastname.'</div>
                        <div class="text-xs text-slate-500 ml-auto">'.$sub_trail->created_at.'</div>
                    </div>
                    <div class="text-slate-500 mt-1">Received: '.$sub_trail->receive_date.'</div>
                    <div class="text-slate-500 mt-1">Released: '.$sub_trail->release_date.'</div>
                </div>
            </div>
            ';

            foreach ($sub_trail->get_sub_sub_trail as $dx => $sub_sub_trail) {

                if(!$sub_sub_trail->receive_date == null && !$sub_sub_trail->release_date == null){
                    $image_status = '<img alt="done" src="../dist/images/QuaintLikelyFlyingfish-max-1mb.gif">';
                }else if(!$sub_sub_trail->receive_date == null && $sub_sub_trail->release_date == null){
                    $image_status = '<img alt="file holder" src="../dist/images/sun-energy.gif">';
                }else{
                    $image_status = '<img alt="to load" src="../dist/images/80ZN.gif">';
                }

                $release_to .= '<div class="intro-x relative flex items-center mb-3">
                <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                        '. $image_status.'
                    </div>
                </div>
                <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                    <div class="flex items-center">
                        <div class="font-medium">'.$sub_sub_trail->get_user->firstname.' '.$sub_sub_trail->get_user->lastname.'</div>
                        <div class="text-xs text-slate-500 ml-auto">'.$sub_sub_trail->created_at.'</div>
                    </div>
                    <div class="text-slate-500 mt-1">Received: '.$sub_sub_trail->receive_date.'</div>
                    <div class="text-slate-500 mt-1">Released: '.$sub_sub_trail->release_date.'</div>
                </div>
            </div>
            ';
            }

            }
            }



        }



        return json_encode(array(
            "data"=>$data,
            "get_trails"=>$get_trails,
            "release_to"=>$release_to,
        ));

    }

    public function load_document_details2(Request $request)
    {
        $data = $request->all();
        $option_1 = get_option_for_release();
        $getDoc = doc_file::where('track_number',$request->docID)->where('active', 1)->first();
        $release_to = '';

        $get_trail = doc_trail::with('get_user','get_sub_trail.get_user','get_sub_trail.get_sub_trail.get_user')
        ->where('track_number',$request->docID)
        ->where('created_by', Auth::user()->employee)
        ->whereNull('receive_date')
            ->whereNull('release_date')
        ->where('active', 1)
        ->first();

        if($get_trail){
            $release_to .=  '<option value="'.$get_trail->target_user_id .'">'.$get_trail->get_user->firstname.' '.$get_trail->get_user->lastname.'</option>';

        }else{
            $get_sub_trail = doc_trail::with('get_user','get_sub_trail.get_user','get_sub_trail.get_sub_trail.get_user')
            ->where('track_number',$request->docID)
            ->whereNull('receive_date')
            ->whereNull('release_date')
            ->orderBy('created_at', 'desc')
            ->where('active', 1)
            ->first();

            if($get_sub_trail){
                $release_to .=  '<option value="'.$get_sub_trail->target_user_id .'">'.$get_sub_trail->get_user->firstname.' '.$get_sub_trail->get_user->lastname.'</option>';
            }


        }

        if($get_trail->get_sub_trail()->exists()){

            $get_sub_trail = $get_trail->get_sub_trail()->whereNull('receive_date')->whereNull('release_date')->first();
            $release_to .=  '<option value="'.$get_sub_trail->target_user_id .'">'.$get_sub_trail->get_user->firstname.' '.$get_sub_trail->get_user->lastname.'</option>';

        }else{
            $get_trail_with_id = doc_trail::where('id',$get_trail->trail_id)->first();
            $get_sub_trail_with_id  = doc_trail::where('trail_id',$get_trail_with_id->trail_id)->get();
            if($get_sub_trail_with_id){
                $get_sub_trail = $get_sub_trail_with_id->whereNull('receive_date')->whereNull('release_date')->first();
            $release_to .= '<option value="'.$get_sub_trail->target_user_id .'">'.$get_sub_trail->get_user->firstname.' '.$get_sub_trail->get_user->lastname.'</option>';

            }else{
                $get_trail_null = doc_trail::with('get_sub_trail')
                ->where('track_number',$request->docID)
                ->whereNull('trail_id')
                ->whereNull('receive_date')
                ->whereNull('release_date')
                ->first();
                if($get_trail){
                    $release_to .=  '<option value="'.$get_trail_null->target_user_id .'">'.$get_trail_null->get_user->firstname.' '.$get_trail_null->get_user->lastname.'</option>';
                }
            }

        }



        return json_encode(array(
            "data"=>$data,
            "getDoc"=>$getDoc,
            "option_Value"=>$option_1,
            "release_to"=>$release_to,
            "get_trail"=>$get_trail,
        ));
    }
}
