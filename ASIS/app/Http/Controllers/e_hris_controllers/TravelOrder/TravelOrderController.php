<?php

namespace App\Http\Controllers\TravelOrder;

use App\Exports\travel_order_export;
use App\Http\Controllers\Controller;
use App\Models\document\doc_file;
use App\Models\document\doc_file_attachment;
use App\Models\document\doc_notes;
use App\Models\document\doc_track;
use App\Models\document\doc_trail;
use App\Models\global_signatories;
use App\Models\global_signatories_history;
use App\Models\Leave\agency_employees;
use App\Models\tblposition;
use App\Models\tbluserassignment;
use App\Models\travel_order\to_members;
use App\Models\travel_order\to_travel_orders;
use Arr;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;
use Illuminate\Support\Str;

class TravelOrderController extends Controller
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

    public function myto(){

        return view('travelorder.mytravelorder');
    }

    public function to_list(){

        return view('travelorder.travel_orders');

    }

    public function rated(){

        return view('travelorder.rated_to');

    }

    public function load_travel_order(){
        $userID = Auth::user()->employee;
        $class = '';

        $tres = [];

        //$incomingDocs = doc_file_track::where('active',1)->where('user_id', $userID)->with(['getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus'])->get();

        $travel_orders = to_travel_orders::with('get_status')
            ->where('active',1)
            ->where('created_by',Auth::user()->employee)
            ->orderBy('created_at', 'DESC')
            ->get();


        foreach ($travel_orders as $to) {

            //user priv
            if(Session::has('get_user_priv')){
                if(Session::get('get_user_priv')[0]->delete == 1 || Auth::user()->role_name == 'Admin'){
                    $can_delete = '<a id="btn_delete_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                }else{
                    $can_delete = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                }
                if(Session::get('get_user_priv')[0]->print == 1 || Auth::user()->role_name == 'Admin'){
                    $can_view = '<a id="btn_view_to"  target="_blank" href="/travel/order/print/to/'.$to->id.'/vw" class="dropdown-item" data-to-id="'.$to->id.'" data-tw-toggle="modal" data-tw-target="#view_travel_order"> <i class="fa fa-print w-4 h-4 mr-2 text-success"></i> View </a>';
                }else{
                    $can_view = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-print w-4 h-4 mr-2 text-success"></i> View </a>';
                }
                if(Session::get('get_user_priv')[0]->write == 1 || Auth::user()->role_name == 'Admin'){
                    $can_update = '<a id="btn_update_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                }else{
                    $can_update = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                }
                if(Session::get('get_user_priv')[0]->create == 1 || Auth::user()->role_name == 'Admin'){

                    $can_release = '<a id="release_travel_order" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release" data-to-id="'.$to->id.'" ><i class="fa fa-upload w-4 h-4 text-success"></i> </a>';

                }else{
                    $can_release = '<a class="not_allowed_to_take_action w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release"><i class="fa fa-upload w-4 h-4 text-success"></i></a>';
                }
            }else{
                $can_delete = '<a id="btn_delete_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                $can_view = '<a id="btn_view_to"  target="_blank" href="/travel/order/print/to/'.$to->id.'/vw" class="dropdown-item" data-to-id="'.$to->id.'" data-tw-toggle="modal" data-tw-target="#view_travel_order"> <i class="fa fa-print w-4 h-4 mr-2 text-success"></i> View </a>';
                $can_update = '<a id="btn_update_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                $can_release = '<a id="release_travel_order" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release" data-to-id="'.$to->id.'" ><i class="fa fa-upload w-4 h-4 text-success"></i> </a>';
            }

            if($to->get_status){
                $status = $to->get_status->name;
                $class = $to->get_status->class;
            }

            $departure_dateform = new DateTime($to->departure_date);
            $return_dateform = new DateTime($to->return_date);
            $interval = Carbon::parse($departure_dateform)->diffInDays(Carbon::parse($return_dateform),false) + 1;


            $get_document = doc_file::where('doc_type','to')->where('doc_type_id',$to->id)->first();

            $doc_type ='to';
            $doc_type_id =$to->id;

            if( $get_document){
                $doc_type =$get_document->doc_type;
                $doc_type_id =$get_document->doc_type_id;
            }


            $td = [
                "id" => $to->id,
                "name_id" => $to->name_id,
                "name" => $to->name,
                "date" => $to->date,
                "departure_date" =>format_date_time(1,  Carbon::parse($to->departure_date)),
                "return_date" =>format_date_time(1,  Carbon::parse($to->return_date) ),
                "pos_des_id" => $to->pos_des_id,
                "pos_des_type" => $to->pos_des_type,
                "station" => $to->station,
                "destination" => $to->destination,
                "purpose" => $to->purpose,
                "created_at" =>format_date_time(0, $to->created_at),
                "interval" =>$interval,
                "days" =>$interval,
                "can_delete" =>$can_delete,
                "can_view" =>$can_view,
                "can_update" =>$can_update,
                "can_release" =>$can_release,
                "status" =>$status,
                "to_status" =>$to->status,
                "class" =>$class,
                "doc_type" =>$doc_type,
                "doc_type_id" =>$doc_type_id,

            ];
            $tres[count($tres)] = $td;

        }
        echo json_encode($tres);
    }

    public function load_travel_order_list(){
        $userID = Auth::user()->employee;
        $class = '';

        $tres = [];

        //$incomingDocs = doc_file_track::where('active',1)->where('user_id', $userID)->with(['getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus'])->get();

        $travel_orders = to_travel_orders::with('get_status')
            ->where('active',1)
            ->where('status',11)
            ->orderBy('created_at', 'DESC')
            ->get();


        foreach ($travel_orders as $to) {

            //user priv
            if(Session::has('get_user_priv')){
                if(Session::get('get_user_priv')[0]->delete == 1 || Auth::user()->role_name == 'Admin'){
                    $can_delete = '<a id="btn_delete_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                }else{
                    $can_delete = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                }
                if(Session::get('get_user_priv')[0]->print == 1 || Auth::user()->role_name == 'Admin'){
                    $can_view = '<a id="btn_view_to" target="_blank" href="/travel/order/print/to/'.$to->id.'/vw"  data-to-id="'.$to->id.'" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip"  ><i class="fa fa-print w-4 h-4 text-success"></i> </a>';
                }else{
                    $can_view = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-print w-4 h-4 mr-2 text-success"></i> View </a>';
                }
                if(Session::get('get_user_priv')[0]->write == 1 || Auth::user()->role_name == 'Admin'){
                    $can_update = '<a id="btn_update_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                }else{
                    $can_update = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                }
                if(Session::get('get_user_priv')[0]->create == 1 || Auth::user()->role_name == 'Admin'){

                    $can_release = '<a id="release_travel_order" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release" data-to-id="'.$to->id.'" ><i class="fa fa-upload w-4 h-4 text-success"></i> </a>';

                }else{
                    $can_release = '<a class="not_allowed_to_take_action w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release"><i class="fa fa-upload w-4 h-4 text-success"></i></a>';
                }
            }else{
                $can_delete = '<a id="btn_delete_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                $can_view = '<a id="btn_view_to"  target="_blank" href="/travel/order/print/to/'.$to->id.'/vw" class="dropdown-item" data-to-id="'.$to->id.'" data-tw-toggle="modal" data-tw-target="#view_travel_order"> <i class="fa fa-print w-4 h-4 mr-2 text-success"></i> View </a>';
                $can_update = '<a id="btn_update_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                $can_release = '<a id="release_travel_order" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release" data-to-id="'.$to->id.'" ><i class="fa fa-upload w-4 h-4 text-success"></i> </a>';
            }

            if($to->get_status){
                $status = $to->get_status->name;
                $class = $to->get_status->class;
            }

            $departure_dateform = new DateTime($to->departure_date);
            $return_dateform = new DateTime($to->return_date);
            $interval = Carbon::parse($departure_dateform)->diffInDays(Carbon::parse($return_dateform),false) + 1;


            $get_document = doc_file::where('doc_type','to')->where('doc_type_id',$to->id)->first();

            $doc_type ='to';
            $doc_type_id =$to->id;

            if( $get_document){
                $doc_type =$get_document->doc_type;
                $doc_type_id =$get_document->doc_type_id;
            }


            $td = [
                "id" => $to->id,
                "name_id" => $to->name_id,
                "name" => $to->name,
                "date" => $to->date,
                "departure_date" =>format_date_time(1,  Carbon::parse($to->departure_date)),
                "return_date" =>format_date_time(1,  Carbon::parse($to->return_date) ),
                "pos_des_id" => $to->pos_des_id,
                "pos_des_type" => $to->pos_des_type,
                "station" => $to->station,
                "destination" => $to->destination,
                "purpose" => $to->purpose,
                "created_at" =>format_date_time(0, $to->created_at),
                "interval" =>$interval,
                "days" =>$interval,
                "can_delete" =>$can_delete,
                "can_view" =>$can_view,
                "can_update" =>$can_update,
                "can_release" =>$can_release,
                "status" =>$status,
                "to_status" =>$to->status,
                "class" =>$class,
                "doc_type" =>$doc_type,
                "doc_type_id" =>$doc_type_id,

            ];
            $tres[count($tres)] = $td;

        }
        echo json_encode($tres);
    }

    public function load_travel_order_rated(){
        $userID = Auth::user()->employee;
        $class = '';

        $tres = [];


        $travel_orders = to_travel_orders::with('get_status','get_my_signatories')
            ->where('status',11)
            ->where('active',1)
            ->whereHas('get_my_signatories')
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($travel_orders as $to) {

            //user priv
            if(Session::has('get_user_priv')){
                if(Session::get('get_user_priv')[0]->delete == 1 || Auth::user()->role_name == 'Admin'){
                    $can_delete = '<a id="btn_delete_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                }else{
                    $can_delete = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                }
                if(Session::get('get_user_priv')[0]->print == 1 || Auth::user()->role_name == 'Admin'){
                    $can_view = '<a id="btn_view_to" target="_blank" href="/travel/order/print/to/'.$to->id.'/vw"  data-to-id="'.$to->id.'" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip"  ><i class="fa fa-print w-4 h-4 text-success"></i> </a>';
                }else{
                    $can_view = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-print w-4 h-4 mr-2 text-success"></i> View </a>';
                }
                if(Session::get('get_user_priv')[0]->write == 1 || Auth::user()->role_name == 'Admin'){
                    $can_update = '<a id="btn_update_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                }else{
                    $can_update = '<a href="javascript:;" class="dropdown-item not_allowed_to_take_action"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                }
                if(Session::get('get_user_priv')[0]->create == 1 || Auth::user()->role_name == 'Admin'){

                    $can_release = '<a id="release_travel_order" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release" data-to-id="'.$to->id.'" ><i class="fa fa-upload w-4 h-4 text-success"></i> </a>';

                }else{
                    $can_release = '<a class="not_allowed_to_take_action w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release"><i class="fa fa-upload w-4 h-4 text-success"></i></a>';
                }
            }else{
                $can_delete = '<a id="btn_delete_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
                $can_view = '<a id="btn_view_to"  target="_blank" href="/travel/order/print/to/'.$to->id.'/vw" class="dropdown-item" data-to-id="'.$to->id.'" data-tw-toggle="modal" data-tw-target="#view_travel_order"> <i class="fa fa-print w-4 h-4 mr-2 text-success"></i> View </a>';
                $can_update = '<a id="btn_update_to" href="javascript:;" class="dropdown-item" data-to-id="'.$to->id.'"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
                $can_release = '<a id="release_travel_order" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip" title="Release" data-to-id="'.$to->id.'" ><i class="fa fa-upload w-4 h-4 text-success"></i> </a>';
            }

            if($to->get_status){
                $status = $to->get_status->name;
                $class = $to->get_status->class;
            }

            $departure_dateform = new DateTime($to->departure_date);
            $return_dateform = new DateTime($to->return_date);
            $interval = Carbon::parse($departure_dateform)->diffInDays(Carbon::parse($return_dateform),false) + 1;


            $get_document = doc_file::where('doc_type','to')->where('doc_type_id',$to->id)->first();

            $doc_type ='to';
            $doc_type_id =$to->id;

            if( $get_document){
                $doc_type =$get_document->doc_type;
                $doc_type_id =$get_document->doc_type_id;
            }


            $td = [
                "id" => $to->id,
                "name_id" => $to->name_id,
                "name" => $to->name,
                "date" => $to->date,
                "departure_date" =>format_date_time(1,  Carbon::parse($to->departure_date)),
                "return_date" =>format_date_time(1,  Carbon::parse($to->return_date) ),
                "pos_des_id" => $to->pos_des_id,
                "pos_des_type" => $to->pos_des_type,
                "station" => $to->station,
                "destination" => $to->destination,
                "purpose" => $to->purpose,
                "created_at" =>format_date_time(0, $to->created_at),
                "interval" =>$interval,
                "days" =>$interval,
                "can_delete" =>$can_delete,
                "can_view" =>$can_view,
                "can_update" =>$can_update,
                "can_release" =>$can_release,
                "status" =>$status,
                "to_status" =>$to->status,
                "class" =>$class,
                "doc_type" =>$doc_type,
                "doc_type_id" =>$doc_type_id,

            ];
            $tres[count($tres)] = $td;

        }
        echo json_encode($tres);
    }

    public function add_travel_order(Request $request){
        $data = $request->all();
        $no_signatory = '';
        if ($request->has('table_signatory_emp_id')) {
            $fullname = Str::title(fullname(Auth::user()->employee));
            $add_update_to = [
                'name_id' => Auth::user()->employee,
                'name' => $fullname,
                'date' => $request->modal_date_now,
                'departure_date' => $request->modal_departure_date,
                'return_date' => $request->modal_return_date,
                'pos_des_id' => $request->pos_des,
                'pos_des_type' => $request->pos_des_type,
                'station' => $request->modal_station,
                'station_id' => $request->modal_station,
                'destination' => $request->modal_destination,
                'destination_id' => $request->modal_destination,
                'purpose' => $request->modal_purpose,
                'created_by' => Auth::user()->employee,
            ];

            $to_id = to_travel_orders::updateOrCreate(['id' => $request->to_id],$add_update_to)->id;

            $get_to_member = to_members::where('to_id',$to_id)->get();
                foreach ($get_to_member as $key => $mem) {
                    $update_member = [
                        'active' => 0,
                    ];
                    $mem_id = to_members::updateOrCreate(['id' => $mem->id],$update_member)->id;
                }

            if ($request->has('table_signatory_emp_id')) {
                foreach ($request->table_signatory_emp_id as $i => $emp_id) {

                    $add_sig = [
                        'name' => $request->name_modal_text,
                        'type' => 'to',
                        'type_id' => $to_id,
                        'employee_id' =>  $emp_id,
                        'for' => $request->table_signatory_description[$i],
                        'description' => $request->table_signatory_description[$i],
                        'suffix_name' => $request->table_signatory_suffix[$i],
                        'created_by' =>Auth::user()->employee,
                    ];

                    $sig_id = global_signatories::updateOrCreate(['id' => $request->table_signatory_id[$i]],$add_sig)->id;
                }
            }


            if ($request->has('to_memberList')) {
                foreach ($request->to_memberList as $i => $member_emp_id) {

                    $add_member = [
                        'to_id' => $to_id,
                        'active' => 1,
                        'user_id' => $member_emp_id,
                        'created_by' =>Auth::user()->employee,
                    ];

                    $member_id = to_members::updateOrCreate(['id' => $request->to_memberList[$i],'to_id' => $to_id],$add_member)->id;
                }
            }


            $notif ='Added';
            if($request->to_id){
                $notif ='Updated';
            }
            __notification_set(1, "Travel Order", "Travel Order ".$notif." successfully!");
            add_log('to',$to_id,'Travel Order '.$notif.' Successfully!');

            $get_to = to_travel_orders::where('id',$to_id)->first();

            if($get_to){

                if($get_to->status == 1){

                }else{
                    $get_document = doc_file::where('doc_type','to')->where('doc_type_id',$to_id)->first();
                    if($get_document){

                        $get_track = doc_track::where('track_number',$get_document->track_number)->get()->unique('target_user_id');

                        foreach($get_track as $track){
                            doc_track::where('id',  $track->id)->update([
                                'seen' => '0',
                            ]);

                            createNotification('document',  $get_document->track_number, 'user', Auth::user()->employee, $track->target_user_id, 'user', 'Travel order updated with the tracking number of : ' .  $track->track_number . '.');
                        }

                    $get_travel_order = to_travel_orders::with('get_signatories.getUserinfo.getHRdetails.getPosition',
                    'get_signatories.getUserinfo.getHRdetails.getDesig',
                    'get_desig',
                    'get_position')
                    ->where('active',1)
                    ->where('id',$to_id)
                    ->first( );

                    if($get_travel_order->get_signatories()->exists()){
                        foreach ($get_travel_order->get_signatories as $sig) {

                            global_signatories::where('id',  $sig->id)->update([
                                'approved' => '0',
                                'allow_esig' => '0',
                                'action' => '0',
                                'action_taken_status' => '1',
                            ]);

                            $add_signatory_history = [
                                'signatory_id' =>  $sig->id,
                                'action' => '0',
                                'note' => 'Travel order updated ,please check the updates!',
                                'employee_id' => Auth::user()->employee,
                                'created_by' => Auth::user()->employee,

                            ];
                            $sig_his_id = global_signatories_history::create($add_signatory_history)->id;
                        }
                    }

                    }

                    to_travel_orders::where('id', $to_id)->update([ 'status' => '15']);
                }

            }

        }else{
            $no_signatory = 'true';
            __notification_set(-1, "No Signatories", "Please make sure to add the person to the signatory list.");
        }

        return json_encode(array(
            "data"=>$data,
            "no_signatory"=>$no_signatory,
        ));
    }


    public function remove_to(Request $request){
        $data = $request->all();

        if($request->has('to_id')){

            $update_remove = [
                'active' => '0',
            ];
            to_travel_orders::where(['id' =>  $request->to_id])->first()->update($update_remove);

        }

        __notification_set(1,'Success','Travel Order removed successfully!');

        add_log('to',$request->to_id,'Travel Order removed successfully!');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function load_details(Request $request){
        $data = $request->all();
        $get_to = '';
        if($request->has('to_id')){

            $get_to = to_travel_orders::with(
            'get_signatories.getUserinfo.getHRdetails.getPosition',
            'get_signatories.getUserinfo.getHRdetails.getDesig',
            'get_desig',
            'get_position','get_members')
            ->where('active',1)
            ->where('id',$request->to_id)
            ->first();


        if($get_to->status != 1){
            __notification_set(-1,'Notice','Travel order already released!');
        }else{

        }
        }

        $sig_for_table = '';
        $sig_for_table_modal = '';

        if($get_to->get_signatories()->exists()){
            foreach ($get_to->get_signatories as $sig) {
                $fullname= '';
                if( $sig->getUserinfo()->exists()){
                    $fullname = $sig->getUserinfo->firstname .' '. $sig->getUserinfo->lastname;
                }

                $sig_for_table .= '<tr class="hover:bg-gray-200">
                    <td style="display: none">'.$sig->employee_id.'</td>
                    <td style="display: none"><input type="text"  name="table_signatory_id[]" class="form-control "  value="'.$sig->id.'"></td>
                    <td><input type="text" style="display: none" name="table_signatory_emp_id[]" class="form-control "  value="'.$sig->employee_id.'">'.$fullname.'  <input type="text" name="table_signatory_suffix[]" class="form-control w-24"  value="'.$sig->suffix_name.'"></td>
                    <td><input type="text"  name="table_signatory_description[]" class="form-control "  value="'.$sig->description.'"></td>
                    <td><a href="javascript:void(0);" class="flex items-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 far fa-trash-alt">Remove</i></a></td>
                    </tr>';

                $sig_for_table_modal .= '<tr class="hover:bg-gray-200">
                    <td>'.$sig->employee_id.'</td>
                    <td><input type="text" style="display: none" name="table_signatory_emp_id_modal[]" class="form-control "  value="'.$sig->employee_id.'">'.$fullname.' <strong>'.$sig->suffix_name.'</strong></td>
                    <td><input type="text" style="display: none" name="table_signatory_description_modal[]" class="form-control "  value="'.$sig->description.'">'.$sig->description.'</td>
                    </tr>';

            }
        }

            $selected_values_members = array();

            if($get_to->get_members()->where('user_id','!=',Auth::user()->employee)->exists()){
                foreach($get_to->get_members->where('user_id','!=',Auth::user()->employee) as $i => $member){

                    $selected_values_members[] = $member->user_id;

                }
            }

        return json_encode(
            array(
                "data"=>$data,
                "get_to"=>$get_to,
                "sig_for_table"=>$sig_for_table,
                "sig_for_table_modal"=>$sig_for_table_modal,
                "selected_values_members"=>$selected_values_members,
            )
        );
    }

    public function print($id, $type){
        $now = date('m/d/Y g:ia');

        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');

        $filename = 'pdf';


        $get_to = to_travel_orders::with('get_signatories.getUserinfo.getHRdetails.getPosition',
                                        'get_signatories.getUserinfo.getHRdetails.getDesig',
                                        'get_desig',
                                        'get_position',
                                        'get_status',
                                        'get_members')
                                        ->where('active',1)
                                        ->where('id',$id)
                                        ->first();

            $my_des_pos = 'N/A';
            if($get_to->pos_des_type === 'position'){
                    $pos = tblposition::where('id',$get_to->pos_des_id)->first();
                $my_des_pos = $pos->emp_position;
            }elseif($get_to->pos_des_type === 'desig'){
                $des = tbluserassignment::where('id',$get_to->pos_des_id)->first();
            $my_des_pos = $des->userauthority;
        }
        $status_text = '';

        if($get_to->get_status()->exists()){
            $status_text = $get_to->get_status->name;

        }


            $filename = 'Travel_Order_'.$get_to->id;

        $sig_divs = '';
            if($get_to->get_signatories()->exists()){

                foreach($get_to->get_signatories as $i => $sig){




                        $name = '';
                        $description = $sig->description;
                        $pos_des = '';
                        $suffix_name = '';
                        $image = '<div style="width: 130px; height: 50px"></div>';

                        if($sig->getUserinfo()->exists()){
                            $miden = '';
                            if($sig->getUserinfo->mi){
                                $miden = mb_substr($sig->getUserinfo->mi, 0, 1) .'. ';
                            }

                            $name = $sig->getUserinfo->firstname .' '.$miden.' '. $sig->getUserinfo->lastname.' '. $sig->getUserinfo->extension;

                            if($sig->getUserinfo->getHRdetails()->exists()){
                                if($sig->getUserinfo->getHRdetails->getDesig()->exists()){
                                    $pos_des = $sig->getUserinfo->getHRdetails->getDesig->userauthority;

                                }elseif($sig->getUserinfo->getHRdetails->getPosition()->exists())
                                {

                                    $pos_des = $sig->getUserinfo->getHRdetails->getPosition->emp_position;

                                }
                            }
                            if($sig->approved == 1 && $sig->allow_esig == 1 ){
                                if($sig->getUserinfo->e_signature){
                                    $image = '<img src="uploads/e_signature/'.$sig->getUserinfo->e_signature.'" style="width: 130px; height: 50px">';
                                }else{
                                    $image = '<div style="width: 130px; height: 50px"></div>';

                                }
                            }

                            if($sig->suffix_name){
                                $suffix_name = ' &nbsp; '. $sig->suffix_name;
                            }else{
                                $suffix_name = '';
                            }


                        }




                        if ($i % 2 == 0)
                            {
                                //echo "even";
                                $sig_divs .= '<div style="float: left; width: 50%; font-size:x-small ; padding-left:20px">
                                <div style="padding-bottom: 10px; "><strong>'.$description.'</strong></div>
                                <div style="margin-bottom: -20px; ">'. $image.'</div>
                                <div><u class="block mt-1">'.strtoupper($name).' '.$suffix_name.'</u></div>
                                <div>'.$pos_des.'</div>
                            </div>';
                            }
                            else
                            {
                                //echo "odd";
                                $sig_divs .='<div style="float: right; margin-left: 35%; width: 50%;  font-size:x-small ">
                                <div>
                                    <div style="padding-bottom: 10px;"><strong>'.$description.'</strong></div>
                                    <div style="margin-bottom: -20px;">'. $image.'</div>
                                    <div><u class="block mt-1">'.strtoupper($name).' '.$suffix_name.'</u></div>
                                    <div>'.$pos_des.'</div>
                                </div>

                            </div>

                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>';
                            }



                }


        }
        //dd($sig_divs);
        $system_image_header ='';
        $system_image_footer ='';

        if(system_settings()){
            $system_image_header = system_settings()->where('key','image_header')->first();
            $system_image_footer = system_settings()->where('key','image_footer')->first();
        }



        $pdf = PDF::loadView('travelorder.print.print_to',compact('status_text','current_date','get_to','sig_divs','filename','my_des_pos','system_image_header','system_image_footer'))->setPaper('a4', 'portrait');

        if ($type == 'vw') {
            return $pdf->stream($filename . '.pdf');
        } elseif ($type == 'dl') {
            return $pdf->download($filename . '.pdf');
        }

    }

    function export_travel_order(){

        $excel = Excel::download(new travel_order_export, 'travel-order-collection.xlsx');
        return $excel;

    }

    public function release_travel_order(Request $request){
        $data = $request->all();

        $month = \date('m');
        $year = \date('Y');

        $counter = doc_file::where('created_by', Auth::user()->employee)->get()->count();
        $doc_count = sprintf('%06u', $counter + 1);
        $doc_code = $year .'-'.$month .'-'.Auth::user()->employee.'-'.$doc_count;


        if($request->has('to_id')){

            $get_travel_order = to_travel_orders::with('get_signatories.getUserinfo.getHRdetails.getPosition',
            'get_signatories.getUserinfo.getHRdetails.getDesig',
            'get_desig',
            'get_position')
            ->where('active',1)
            ->where('id',$request->to_id)
            ->first();

            $date_of_travel = '.';
            if($get_travel_order->date){
                $date_of_travel ='on '. Carbon::createFromFormat('Y-m-d', $get_travel_order->date)->format('m/d/Y').'.';
            }

            $insert_file = [
                'track_number' => $doc_code,
                'name' => 'Travel Order of '.$get_travel_order->name .''.$date_of_travel,
                'desc' =>  $get_travel_order->purpose,
                'type_submitted' => '1',
                'type' => '20',
                'level' => '5',
                'created_by' => Auth::user()->employee,
                'display_type' => '1',
                'doc_type' => 'to',
                'doc_type_id' => $request->to_id,
            ];
            doc_file::create($insert_file);

            $insert_doc_attachment = [
                'doc_file_id' => $doc_code,
                'url' => '/travel/order/print/to/'.$get_travel_order->id.'/vw',
                'name' => 'Travel Order',
                'created_by' => Auth::user()->employee,
                'added_attachments' => false,
            ];
            doc_file_attachment::create($insert_doc_attachment);


            if($get_travel_order->get_signatories()->exists()){

                foreach($get_travel_order->get_signatories as $arry_id => $signatory){

                    $check = doc_trail::where('track_number', $doc_code)->where('target_user_id',$signatory->employee_id)->first();
                    if(!$check){
                        $add_trail = [
                            'track_number' =>  $doc_code,
                            'type' => $request->__from,
                            'type_id' => $request->senderID,
                            'target_user_id' => $signatory->employee_id,
                            'created_by' => Auth::user()->employee,
                        ];
                        $trail_id = doc_trail::create($add_trail)->id;
                    }
                    if( $arry_id == 0){

                        $add_incoming_track = [
                            'track_number' =>  $doc_code,
                            'doc_trail_id' => $trail_id,
                            'type' => $request->__from,
                            'type_id' => $request->senderID,
                            'target_user_id' =>$signatory->employee_id,
                            'note' => $request->message,
                            'for_status' => 3,
                            'created_by' => Auth::user()->employee,
                            'last_activity' => true,
                            'target_type' => null,
                            'target_id' => null,
                        ];
                        $track_id = doc_track::create($add_incoming_track)->id;
                        createNotification('document',  $doc_code, 'user', Auth::user()->employee, $signatory->employee_id, 'user', 'You have a document to receive with tracking number : ' .  $doc_code . '.');
                    }
                }

                doc_file::where('track_number',  $doc_code)->update([
                    'show_author' => $request->showAuthor,
                    'trail_release' => 1,
                    'note' => $request->message,
                    'status' => 2,
                ]);

                to_travel_orders::where('id',  $request->to_id)->update([
                    'status' => 2,
                ]);

                __notification_set(1,'Success','Document has been successfully sent');

            }

        }


        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function remove_signatory(Request $request){
        $data = $request->all();

        if($request->has('table_signatory_id')){
            global_signatories::where('id',  $request->table_signatory_id)->update([
                'active' => 1,
            ]);
        }


        __notification_set(-1,'Remove','Signatory removed successfully!');
        return json_encode(array(
            "data"=>$data,
        ));
    }
}
