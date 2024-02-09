<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\document\doc_file_track;
use App\Models\document\doc_file_trail;
use App\Models\document\doc_track;
use App\Models\document\doc_trail;
use App\Models\global_signatories;
use App\Models\global_signatories_history;
use App\Models\tblemployee;
use App\Models\travel_order\to_travel_orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiveController extends Controller
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


    public function received()
    {
        $get = doc_trail::tree()->where('track_number','2023-03-000002');
        //dd($get );

        return view('Documents.Received');
    }

    public function received_Docs()
    {
        $userID = Auth::user()->employee;

        $tres = [];

        //$incomingDocs = doc_file_track::where('active',1)->where('user_id', $userID)->with(['getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus'])->get();

        $receivedDocs = doc_track::
        with([
            'getDocDetails.get_travel_orders',
            'getDocDetails.getDocType',
            'getDocDetails.getDocLevel',
            'getDocDetails.getDocTypeSubmitted',
            'getDocDetails.getDocStatus',
            'getDocDetails.getAuthor',
            'getSender_Details'])
            ->where('target_user_id',Auth::user()->employee)
            ->where('for_status',6)
            ->where('active',1)
            ->whereIn('action',[1,0])
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->unique('track_number');

            //dd($receivedDocs);

        //        ->whereIn('action',[1,0])
        //Remove by Montz

        foreach ($receivedDocs as $dt) {
            $td = [
                "id" => $dt->getDocDetails->id,
                "track_number" => $dt->getDocDetails->track_number,
                "track_id" => $dt->id,
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
                "release_type" => $dt->getDocDetails->trail_release,
                "action" => $dt->action,
                "note" => $dt->note,
                "original_note" => $dt->getDocDetails->note,
                "__from" => $dt->getDocDetails->getAuthor->firstname." ".$dt->getDocDetails->getAuthor->lastname,
                "sender" => $dt->getSender_Details->firstname." ".$dt->getSender_Details->lastname,

                "doc_type" => $dt->getDocDetails->doc_type,
                "doc_type_id" => $dt->getDocDetails->doc_type_id,

                "action" => $dt->action,
                "seen" => $dt->seen,
            ];
            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);

    }



    public function release_action(Request $request)
    {
        $data = $request->all();

        $getDoc = doc_file::where('track_number',$request->docID)->first();

        $update_sub_trail= [
            'release_date' => now(),
        ];
        doc_trail::where(['track_number' =>  $request->docID,'target_user_id' =>  $getDoc->holder_user_id])->first()->update($update_sub_trail);

        /* Added by Montz */
        $created_by = doc_trail::where('track_number', $request->docID)->first();
        $doc_holder = tblemployee::where('agencyid', Auth::user()->employee)->first();
        $holder_fullname = $doc_holder->firstname.' '.$doc_holder->lastname;
        /* Created Notification for document release */
        createNotification('document_release', $request->docID, 'user', Auth::user()->employee, $created_by->created_by, 'user', 'Your document with a tracking number : ' . $request->docID . ' has been released by '.$holder_fullname.'.');

        /* Added by Montz */

        $get_track = doc_track::where('for_status',6)->where('target_user_id',Auth::user()->employee)->first();

        $update_track= [
            'action' => 1,
            'seen' => 1,
            'last_activity' => false,
        ];
        doc_track::where(['id' =>  $get_track->id])->first()->update($update_track);

        $get_trail = doc_trail::where('track_number',$request->docID)->where('target_user_id',$request->swal_release_to)->where('receive_date',null)->where('release_date',null)->first();
        if($get_trail){
            $add_incoming_track = [
                'track_number' => $request->docID,
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
            createNotification('document', $request->docID, 'user', Auth::user()->employee, $target_id_for_notification->target_user_id, 'user', 'You have a document to receive with tracking number : '.$request->docID.'.');

            /* Added by Montz */

        }else{
            $add_incoming_track = [
                'track_number' => $request->docID,
                'type' => $request->doc_sendAstype,
                'type_id' => $request->doc_sendAs,
                'target_user_id' =>$getDoc->created_by,
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
            createNotification('document', $request->docID, 'user', Auth::user()->employee, $target_id_for_notification->target_user_id, 'user', 'You have a document to receive with tracking number : '.$request->docID.'.');

            /* Added by Montz */

            $update_doc_file = [
                'status' => 7,
            ];
            doc_file::where(['track_number' =>  $getDoc->track_number])->first()->update($update_doc_file);
        }

        return json_encode(array(
            "data"=>$data,
            "get_track"=>$get_track,
            "status" => 200,
        ));
    }

    public function load_trail(Request $request){
        $data = $request->all();


        $image_status = '';

        $get_trails = doc_trail::tree()->where('track_number',$request->docID);


        $release_to = sub_trail($get_trails,$request->docID);

        return json_encode(array(
            "data"=>$data,
            "get_trails"=>$get_trails,
            "release_to"=>$release_to,
        ));

    }

    public function add_trail(Request $request){
        $data = $request->all();

        //$trail_holder = doc_file_trail::with('get_sub_trail.get_user')->where('doc_file_id',$request->docID)->where('currently_file_holder',1)->first();


        if($request->has('new_trail')) {

            $holder = doc_track::where('track_number',$request->docID)->where('action',0)->first();
            $trail_holder = doc_trail::where('track_number',$request->docID)->where('target_user_id',Auth::user()->employee)->first();

            foreach($request->new_trail as $key => $user_id){

                    $add_new_trail = [
                        'track_number' =>  $request->docID,
                        'trail_id' =>  $trail_holder->id,
                        'type' =>  'user',
                        'type_id' =>  $user_id,
                        'target_user_id' =>  $user_id,
                        'created_by' =>  Auth::user()->employee,
                        'target_type' => null,
                        'target_id' => null,
                    ];
                    doc_trail::create($add_new_trail);
            }

            }

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function load_signatories(Request $request){
        $data = $request->all();
        $get_travel_order = '';
        $modal_content_title_and_desc = '';
        $modal_content_signatories = '';

        if($request->has('doc_type')){

            //travel oder type of file
            if($request->doc_type == 'to'){
                    //document type travel order
                    $get_travel_order = to_travel_orders::with('get_signatories.getUserinfo.getHRdetails.getPosition',
                    'get_signatories.getUserinfo.getHRdetails.getDesig',
                    'get_desig',
                    'get_position')
                    ->where('active',1)
                    ->where('id',$request->doc_type_id)
                    ->first();

                    $get_document = doc_file::where('doc_type','to')->where('doc_type_id',$request->doc_type_id)->first();

                    $track_number = '';
                    if($get_document){
                        $modal_content_title_and_desc .= '<div>
                        <div class="mr-2">
                            <label class="form-label"><strong>Title</strong></label>
                            <p>'.$get_document->name.'</p>
                        </div>
                        </div>
                        <div class="mt-2">
                            <div class="mr-2">
                                <label class="form-label"><strong>Description</strong></label>
                                <p>'.$get_document->desc.'</p>
                            </div>
                        </div>';

                        $track_number = $get_document->track_number;

                    }else{
                        $modal_content_title_and_desc .= '<div>
                        <div class="mr-2">
                            <label class="form-label"><strong>Title</strong></label>
                            <p>Document not found!</p>
                        </div>
                        </div>
                        <div class="mt-2">
                            <div class="mr-2">
                                <label class="form-label"><strong>Description</strong></label>
                                <p>Document not found!</p>
                            </div>
                        </div>';
                    }


                    if($get_travel_order->get_signatories()->exists()){
                        foreach ($get_travel_order->get_signatories as $sig) {
                            $fullname= 'N/A';
                            $image= 'N/A';
                            if( $sig->getUserinfo()->exists()){
                                $fullname = $sig->getUserinfo->firstname .' '. $sig->getUserinfo->lastname;
                                $image= $sig->getUserinfo->image;
                            }
                            $action_status = '';
                            $to_status = $get_travel_order->status;
                            $take_action = '';
                            $take_action_class = '';
                            $take_action_done = '';

                            if($sig->action == 1){
                                $take_action_done = 'primary';
                            }else{
                                $take_action_done = 'secondary';
                            }

                            if($sig->employee_id == Auth::user()->employee){
                                if($get_document){
                                    if($to_status == 15){
                                        $take_action = '<li>
                                            <a href="javascript:;" class="dropdown-item modal_third_signatory_action" data-sig-id="'.$sig->id.'" data-doc-id="'.$track_number.'"> <i data-lucide="share-2" class="fa fa-edit w-4 h-4 mr-2"></i> Action </a>
                                            </li>';
                                    }

                                    $take_action_class = 'person_on_signatory_click_history data-sig-id="'.$sig->id.'" data-doc-id="'.$track_number.'"';
                                }
                            }else{
                                $take_action = '';
                                $take_action_class ='person_on_signatory_click_history';
                            }

                            if($sig->approved == 1){
                                $action_status = '<div data-sig-id="'.$sig->id.'" data-doc-id="'.$track_number.'" class="w-24 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-success font-medium -mt-1 -mr-1 '.$take_action_class.'"><i class="fa fa-thumbs-up w-3 h-3 mr-2"></i>Approved</div>';
                            }elseif($sig->approved == 2){
                                $action_status = '<div data-sig-id="'.$sig->id.'" data-doc-id="'.$track_number.'" class="w-24 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-danger font-medium -mt-1 -mr-1 '.$take_action_class.'"><i class="fa fa-thumbs-down w-3 h-3 mr-2"></i>Disapproved</div>';
                            }elseif($sig->approved == 3){
                                $action_status = '<div data-sig-id="'.$sig->id.'" data-doc-id="'.$track_number.'" class="w-24 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-primary font-medium -mt-1 -mr-1 '.$take_action_class.' person_on_signatory_click_history"><i class="fa fa-circle w-3 h-3 mr-2"></i>Updated</div>';
                            }else{
                                $action_status = '<div data-sig-id="'.$sig->id.'" data-doc-id="'.$track_number.'" class="w-24 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-warning font-medium -mt-1 -mr-1 '.$take_action_class.' person_on_signatory_click_history"><i class="fa fa-warning w-3 h-3 mr-2"></i>No Action</div>';
                            }

                            $modal_content_signatories .='
                                    <div class="cursor-pointer box relative flex items-center p-5 mt-5">
                                            <div class="flex person_on_signatory_click_history" data-sig-id="'.$sig->id.'" data-doc-id="'.$track_number.'">
                                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                                    <img alt="Profile Picture" class="rounded-full" src="'.get_profile_image($sig->employee_id).'">
                                                    <div class="w-3 h-3 bg-'.$take_action_done.' absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600"></div>
                                                </div>
                                                <div class="ml-2 overflow-hidden">
                                                    <div class="flex items-center "> <a href="javascript:;" class="font-medium truncate w-72">'.$fullname.'</a> </div>
                                                    <div class="w-full truncate text-slate-500 mt-0.5">'.$sig->description.'</div>
                                                </div>
                                            </div>
                                                <div class="dropdown ml-auto">
                                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h w-5 h-5 text-slate-500"></i> </a>
                                                    <div class="dropdown-menu w-40">
                                                        <ul class="dropdown-content">
                                                                '.$take_action.'
                                                            <li>
                                                                <a href="javascript:;" class="dropdown-item person_on_signatory_click_history" data-sig-id="'.$sig->id.'" data-doc-id="'.$track_number.'"> <i data-lucide="copy" class="fa fa-align-left w-4 h-4 mr-2"></i> History </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                    '.$action_status.'
                                            </div>
                            ';
                        }
                    }else{
                        $modal_content_signatories .='
                                <div class="cursor-pointer box relative flex items-center p-1 mt-1 ">
                                    No data found!
                                </div>
                        ';
                    }

            }else{
                $modal_content_signatories .='
                    <div class="cursor-pointer box relative flex items-center p-1 mt-1 ">
                        No data found!
                    </div>
                    ';
                __notification_set(-1,'Notice','No signatories found!');
            }

        }else{
            $modal_content_signatories .='
                <div class="cursor-pointer box relative flex items-center p-1 mt-1 ">
                    No data found!
                </div>
                ';
            __notification_set(-1,'Notice','Document unavailable!');

        }


        return json_encode(array(
            "data"=>$data,
            "modal_content_title_and_desc"=>$modal_content_title_and_desc,
            "modal_content_signatories"=>$modal_content_signatories,

        ));
    }

    public function add_action_signatory(Request $request){
        $data = $request->all();
        $doc_type ='';
        $doc_type_id ='';

        $get_document = doc_file::where('track_number',$request->track_id)->first();

        if( $get_document){
            $doc_type =$get_document->doc_type;
            $doc_type_id =$get_document->doc_type_id;
        }

        global_signatories::where('id',  $request->sig_id)->update([
            'approved' => $request->action_third_modal_list,
            'allow_esig' => $request->esig_third_modal_list,
            'action' => '1',
            'action_taken_status' => $request->action_third_modal_list,
        ]);

        $add_signatory_history = [
            'signatory_id' =>  $request->sig_id,
            'action' => $request->action_third_modal_list,
            'note' => $request->third_modal_message,
            'employee_id' => $request->doc_sendAs,
            'created_by' => Auth::user()->employee,

        ];
        $sig_his_id = global_signatories_history::create($add_signatory_history)->id;


        if($request->doc_track_id){
            doc_track::where('id', $request->doc_track_id)->update([
                'seen' =>  1
            ]);
        }

        //change the status of the submited file

        //if travel order file
        if( $doc_type == 'to'){
            $get_travel_order = to_travel_orders::with('get_signatories.getUserinfo.getHRdetails.getPosition',
            'get_signatories.getUserinfo.getHRdetails.getDesig',
            'get_desig',
            'get_position')
            ->where('active',1)
            ->where('id',$doc_type_id)
            ->first();

            if($get_travel_order->get_signatories()->exists()){
                $count_signatories = $get_travel_order->get_signatories()->count();
                $count_of_approved_signatories = $get_travel_order->get_signatories()->where('approved',1)->count();
                $count_of_disapproved_signatories = $get_travel_order->get_signatories()->where('approved',2)->count();

                to_travel_orders::where('id',  $doc_type_id)->update([ 'status' => '15']);

                if($count_signatories === $count_of_approved_signatories){

                    to_travel_orders::where('id',  $doc_type_id)->update([ 'status' => '11']);

                }elseif(!$count_of_disapproved_signatories == 0){

                    to_travel_orders::where('id',  $doc_type_id)->update([ 'status' => '12']);
                }

            }
        }



        $action_text = 'Something went wrong';
        if($request->action_third_modal_list == 1){
            $action_text = 'Approved';
        }else{
            $action_text = 'Disapproved';
        }

        createNotification('document', $request->track_id, 'user', Auth::user()->employee, $get_document->created_by, 'user', 'Your document has been '.$action_text.' with tracking number : '.$request->track_id.'.');

        __notification_set(1,'Success','Action taken successfully!');


        return json_encode(array(
            "data"=>$data,
            "doc_type"=>$doc_type,
            "doc_type_id"=>$doc_type_id,

        ));
    }

    public function load_signatories_history(Request $request){
        $data = $request->all();
        $load_sig_div_modal_history = '';


        if($request->has('sig_id')){

            $get_signatory = global_signatories::with(['getSignatoryHistory'])->where('id',$request->sig_id)->first();

            if($get_signatory->getSignatoryHistory()->exists()){

                foreach ($get_signatory->getSignatoryHistory()->orderBy('created_at', 'DESC')->get() as $sig_history) {
                    $action_text = '';
                    if($sig_history->action == 1){
                        $action_text = 'Approved';
                    }else{
                        $action_text = 'Disapproved';
                    }
                    $action_status = '';
                    if($sig_history->action == 1){
                        $action_status = '<div  class="w-24 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-success font-medium -mt-1 -mr-1 "><i class="fa fa-thumbs-up w-3 h-3 mr-2"></i>Approved</div>';
                    }elseif($sig_history->action == 2){
                        $action_status = '<div  class="w-24 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-danger font-medium -mt-1 -mr-1 "><i class="fa fa-thumbs-down w-3 h-3 mr-2"></i>Disapproved</div>';
                    }else{
                        $action_status = '<div  class="w-24 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-primary font-medium -mt-1 -mr-1  person_on_signatory_click_history"><i class="fa fa-circle w-3 h-3 mr-2"></i>No Action</div>';
                    }

                    $load_sig_div_modal_history .= '
                    <div class="intro-x cursor-pointer box flex items-center mb-5 p-5 ">
                        <div class="overflow-hidden">
                            <div class="flex ">
                                <a href="javascript:;" class="font-medium">'.$sig_history->created_at->diffForHumans().'</a>
                                <div class="absolute right-0 text-xs text-slate-400 ml-auto mr-1"></div>
                            </div>
                            <div class="w-full text-slate-500 mt-0.5">'.$sig_history->note.'</div>
                        </div>
                        '.$action_status.'
                    </div>';

                }

            }else{
                $load_sig_div_modal_history .='
                <div class="cursor-pointer box relative flex items-center p-1 mt-1 ">
                    No data found!
                </div>
                ';
            }



        }else{

            $load_sig_div_modal_history .='
            <div class="cursor-pointer box relative flex items-center p-1 mt-1 ">
                No data found!
            </div>
            ';
        }


        return json_encode(array(
            "data"=>$data,
            "load_sig_div_modal_history"=>$load_sig_div_modal_history,
        ));
    }
}


