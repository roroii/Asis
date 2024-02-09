<?php

namespace App\Http\Controllers\e_hris_controllers;

use App\Http\Controllers\Controller;
use App\Models\e_hris_models\chat\chat_viewers;
use App\Models\e_hris_models\clearance\clearance_request;
use App\Models\e_hris_models\document\doc_file_attachment;
use App\Models\e_hris_models\document\doc_file_track;
use App\Models\e_hris_models\document\doc_groups;
use App\Models\e_hris_models\document\doc_level;
use App\Models\e_hris_models\document\doc_tempfiles;
use App\Models\e_hris_models\document\doc_track;
use App\Models\e_hris_models\document\doc_trail;
use App\Models\e_hris_models\document\doc_type;
use App\Models\e_hris_models\document\doc_user_rc_g;
use App\Models\e_hris_models\document\doc_file;
use App\Models\tbl_responsibilitycenter;
use App\Models\tblemployee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class DocumentController extends Controller
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

    public function my_documents()
    {
        $priv = check_privileges();

        return view('Documents.My_Documents');
    }

    public function docDetails(Request $request)
    {
        $docID = $request->docID;
        $tres = [];

        $docDetails = doc_file::where('track_number', $docID)->where('active', true)->with(['get_travel_orders','getDocType', 'getDocLevel', 'getDocStatus', 'getDocTypeSubmitted'])->get();

        foreach ($docDetails as $dt) {

            $td = [
                "id" => $dt->id,
                "track_number" => $dt->track_number,
                "name" => $dt->name,
                "desc" => $dt->desc,
                "type" => $dt->getDocType->doc_type,
                "desc_level" => $dt->getDocLevel->desc,
                "level" => $dt->getDocLevel->doc_level,
                "class_level" => $dt->getDocLevel->class,
                "status" => $dt->getDocStatus->name,
                "class" => $dt->getDocStatus->class,
                "active" => $dt->active,
                "type_submitted" => $dt->getDocTypeSubmitted->type,

            ];
            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }

    public function employee_List()
    {
        $tres = [];

        $employees = tblemployee::where('active',1)->has('getUsername')->with(['getHRdetails.getPosition'])->get();

        foreach ($employees as $dt) {
            $td = [
                "agencyid" => $dt->agencyid,
                "lastname" => $dt->lastname,
                "firstname" => $dt->firstname,
                "mi" => $dt->mi,
            ];
            $tres[count($tres)] = $td;


        }
        echo json_encode($tres);
    }

    public function created_docs()
    {
        $tres = [];
        $date_time = '';
        $note = '';
        $track_creator = '';
        $doc_track_created_date = '';

        $created_Docs = doc_file::where('active',1)
            ->where('created_by', Auth::user()->employee)
            ->with(['get_travel_orders' => function ($query) {
                $query->where('active', '1');},'getDocType', 'getDocLevel', 'getDocTypeSubmitted', 'getDocStatus', 'getAttachments', 'countUsersToReceive', 'get_track_creator.getSender_Details'])
            ->orderBy('created_at', 'DESC')
            ->get();

            //dd($created_Docs);
        foreach ($created_Docs as $dt) {

            if($dt->get_track_creator()->exists()){
                if($dt->get_track_creator)
                {
                    foreach ($dt->get_track_creator as $doc_track)
                    {
                        $date_time = Carbon::parse($doc_track->created_at);
                        $note = $doc_track->note;
                        $track_creator = $doc_track->getSender_Details->firstname." ".$doc_track->getSender_Details->lastname;
                        $doc_track_created_date = format_date_time(0, $date_time);
                    }

                }
            }


            $td = [
                "id" => $dt->id,
                "track_number" => $dt->track_number,
                "name" => $dt->name,
                "desc" => $dt->desc,
                "status" => $dt->getDocStatus->name,
                "class" => $dt->getDocStatus->class,
                "type" => $dt->getDocType->doc_type,
                "type_id" => $dt->getDocType->id,
                "level" => $dt->getDocLevel->doc_level,
                "level_id" => $dt->getDocLevel->id,
                "level_class" => $dt->getDocLevel->class,
                "type_submitted" => $dt->getDocTypeSubmitted->type,
                "created_by" => $dt->created_by,
                "created_at" => $dt->created_at,
                "recipients" => $dt->countUsersToReceive->count(),
                "display_type" => $dt->display_type,
                "doc_track_creator" => $track_creator,
                "doc_track_created_date" =>$doc_track_created_date,
                "doc_track_note" => $note,
                "_is_admin" => Auth::user()->role_name,

            ];

            $tres[count($tres)] = $td;
        }

        echo json_encode($tres);
    }

    public function rc_List(Request $request)
    {
        $tres = [];

        if($request->rc_id){
            $rc = tbl_responsibilitycenter::with('sub_employeeinf')->where('responid',$request->rc_id)->where('active',1)->first();
        }else{
            $rc = tbl_responsibilitycenter::with('sub_employeeinf')->where('active',1)->get();
        }
        foreach ($rc as $dt) {
            $fullname = '';
            if($dt->sub_employeeinf()->exists()){
                $fullname =  $dt->sub_employeeinf->firstname .' '.$dt->sub_employeeinf->lastname;
            }
            $td = [
                "responid" => $dt->responid,
                "centername" => $dt->centername,
                "department" => $dt->department,
                "descriptions" => $dt->descriptions,
                "head" => $dt->head,
                "head_name" => $fullname,
            ];
            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }

    public function group_List()
    {
        $tres = [];

        $groups = doc_groups::with(['getHead'])->where('active',1)->get();

        if($groups){

            foreach ($groups as $dt) {
                $lastname =  "";
                $firstname = "";
                $midname =  "";
                if($groups->getHead()->exists()){
                    $lastname =  $dt->getHead->lastname;
                    $firstname =  $dt->getHead->firstname;
                    $midname =  $dt->getHead->mi;
                }
                $td = [
                    "id" => $dt->id,
                    "group_name" => $dt->name,
                    "lastname" => $lastname,
                    "firstname" =>  $firstname,
                    "midname" =>  $midname,
                ];
                $tres[count($tres)] = $td;
            }
        }


        echo json_encode($tres);

    }

    public function create_documents(Request $request)
    {
        //dd($request);

        $month = \date('m');
        $year = \date('Y');

        $counter = doc_file::where('created_by', Auth::user()->employee)->get()->count();
        $doc_count = sprintf('%06u', $counter + 1);
        $doc_code = $year .'-'.$month .'-'.Auth::user()->employee.'-'.$doc_count;

        $folder_name = $request->document_folder;

        if ($request->document_type_submitted == "1")
        {
            if ($folder_name)
            {
                //For Soft Copy
                $insert_file = [
                    'track_number' => $doc_code,
                    'name' => $request->document_title,
                    'desc' => $request->message,
                    'type_submitted' => $request->document_type_submitted,
                    'type' => $request->document_type,
                    'level' => $request->document_level,
                    'active' => true,
                    'created_by' => Auth::user()->employee,
                    'display_type' => $request->document_pub_pri_file,
                ];
                doc_file::create($insert_file);

                foreach ($folder_name as $key => $folder) {

                    $getFolder = doc_tempfiles::where('folder', $folder)->get();

                    foreach ($getFolder as $tempFolder)
                    {
                        $insert_doc_attachment = [
                            'doc_file_id' => $doc_code,
                            'name' => $tempFolder->filename,
                            'path' => $tempFolder->folder,
                            'active' => true,
                            'created_by' => Auth::user()->employee,
                            'added_attachments' => false,
                        ];
                        doc_file_attachment::create($insert_doc_attachment);

                        Storage::copy('public/tmp/' . $tempFolder->folder. '/' . $tempFolder->filename, 'public/documents/' . $tempFolder->folder .'/'. $tempFolder->filename);

                        Storage::deleteDirectory('public/tmp/' . $tempFolder->folder);

                        doc_tempfiles::where('folder',  $tempFolder->folder)->delete();
                        //                        $tempFolder->delete();
                    }
                }
                //                __notification_set(1,'Success','Document with track #: '.$doc_code.' Created Successfully!');
                return response()->json([
                    'status' => 200,
                ]);

            }else{
            //                __notification_set(-1, "Document Attachment is Empty!", "Please fill-up provided fields!");
            }

        }else if ($request->document_type_submitted == "2")
        {
            //for Hard Copy
            $insert_file = [
                'track_number' => $doc_code,
                'name' => $request->document_title,
                'desc' => $request->message,
                'type_submitted' => $request->document_type_submitted,
                'type' => $request->document_type,
                'level' => $request->document_level,
                'active' => true,
                'created_by' => Auth::user()->employee,
                'display_type' => $request->document_pub_pri_file,
            ];
            doc_file::create($insert_file);

            //            __notification_set(1,'Success','Document with track #: '.$doc_code.' Created Successfully!');
            return response()->json([
                'status' => 200,
            ]);
        }

        else {
            //For Both Hard Copy and Soft Copy
            if ($folder_name)
            {
                $insert_file = [
                    'track_number' => $doc_code,
                    'name' => $request->document_title,
                    'desc' => $request->message,
                    'type_submitted' => $request->document_type_submitted,
                    'type' => $request->document_type,
                    'level' => $request->document_level,
                    'active' => true,
                    'created_by' => Auth::user()->employee,
                    'display_type' => $request->document_pub_pri_file,
                ];
                doc_file::create($insert_file);

                foreach ($folder_name as $key => $folder) {

                    $getFolder = doc_tempfiles::where('folder', $folder)->get();

                    foreach ($getFolder as $tempFolder)
                    {
                        $insert_doc_attachment = [
                            'doc_file_id' => $doc_code,
                            'name' => $tempFolder->filename,
                            'path' => $tempFolder->folder,
                            'active' => true,
                            'created_by' => Auth::user()->employee,
                            'added_attachments' => false,
                        ];
                        doc_file_attachment::create($insert_doc_attachment);

                        Storage::copy('public/tmp/' . $tempFolder->folder. '/' . $tempFolder->filename, 'public/documents/' . $tempFolder->folder .'/'. $tempFolder->filename);

                        Storage::deleteDirectory('public/tmp/' . $tempFolder->folder);

                        doc_tempfiles::where('folder',  $tempFolder->folder)->delete();
                //                        $tempFolder->delete();
                    }
                }
                //                __notification_set(1,'Success','Document with track #: '.$doc_code.' Created Successfully!');
                return response()->json([
                    'status' => 200,
                ]);

            }else{
                //                __notification_set(-1, "Document Attachment is Empty!", "Please fill-up provided fields!");
            }
        }
    }

    public function update_documents(Request $request)
    {
        doc_file::where('track_number', $request->document_id)->update([
            'name' => $request->document_title,
            'desc' => $request->message,
            'type' => $request->document_type,
            'level' => $request->document_level,
            'display_type' => $request->document_pub_pri_file,
        ]);
        __notification_set(1,'Success','Document #: '.$request->document_id.' Updated Successfully!');
        return response()->json([
            'status' => 200,
        ]);
    }

    public function delete_documents(Request $request)
    {
        doc_file::where('track_number', $request->docID)->update([
            'active' => false,
        ]);

        doc_track::where('track_number', $request->docID)->update([
            'active' => false,
        ]);
        __notification_set(1,'Success','Document with a code of '.$request->docID.' Deleted Successfully!');
    }

    public function tmpUpload(Request $request)
    {
        $Size = '';

        if ($request->hasFile('document')) {

            foreach ($request->file('document')as $file )
            {
                $fileName = $file->getClientOriginalName();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder,$fileName);

                doc_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

        //                $Size = $file->getSize();

                return $folder;
            }
        }
        return '';
    }

    public function tmpDelete()
    {
        $get_doc_path = request()->getContent();

        $splitDocFilePath = explode("<", $get_doc_path);

        $filePath = $splitDocFilePath[0];

        $tmp_file = doc_tempfiles::where('folder', $filePath)->first();
        if($tmp_file)
        {
            Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            return response('');
        }
    }

    public function attachments_tmpUpload(Request $request)
    {
        if ($request->hasFile('attach_new_document')) {

            foreach ($request->file('attach_new_document')as $file )
            {
                $fileName = $file->getClientOriginalName();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder,$fileName);

                doc_tempfiles::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                //                $Size = $file->getSize();

                return $folder;
            }
        }
        return '';
    }

    public function tmpDeleteIfCanceled(Request $request)
    {
        $folder_name = $request->array_doc_folder;
        if ($folder_name)
        {
            foreach ($folder_name as $getPath) {

                doc_tempfiles::where('folder', $getPath)->delete();

                Storage::deleteDirectory('public/tmp/' . $getPath);
            }
        }
        return response('');
    }

    //load document settings
    public function document_settings_index()
    {
        return view('admin.management.document_settings');
    }

    //docs Level
    public function document_level(Request $request)
    {
        $tres = [];

        $doc_type = doc_level::where('active',1)->get();

        foreach ($doc_type as $dt) {
            $td = [
                "id" => $dt->id,
                "doc_level" => $dt->doc_level,
                "desc" => $dt->desc,
                "legend" => $dt->class,
            ];
            $tres[count($tres)] = $td;


        }
        echo json_encode($tres);
    }

    public function document_level_insert(Request $request)
    {
        $addDocLevel = new doc_level();
        $addDocLevel->doc_level = $request->docLevel;
        $addDocLevel->desc = $request->description;
        $addDocLevel->active = true;
        $addDocLevel->save();

        __notification_set(1,'Success','Type'.$request->docLevel.' Created Successfully!');
    }

    public function document_level_update(Request $request)
    {
        doc_level::where('id', $request->docID)->update([
            'doc_level' => $request->docLevel,
            'desc' => $request->docDesc,
            'class' => $request->color,
        ]);
        __notification_set(1,'Success','Document Level Updated Successfully!');
    }

    public function document_level_delete(Request $request)
    {
        doc_level::where('id', $request->docID)->update([
            'active' => false,
        ]);
    }

    //docs type
    public function document_type(Request $request)
    {
        $tres = [];

        $doc_type = doc_type::where('active',1)->get();

        foreach ($doc_type as $dt) {
            $td = [
                "id" => $dt->id,
                "doc_type" => $dt->doc_type,
                "doc_desc" => $dt->desc,
            ];
            $tres[count($tres)] = $td;


        }
        echo json_encode($tres);
    }

    public function document_type_insert(Request $request)
    {
        $addDocType = new doc_type();
        $addDocType->doc_type = $request->docType;
        $addDocType->desc = $request->description;
        $addDocType->active = true;
        $addDocType->save();

        __notification_set(1,'Success','Type'.$request->docType.' Created Successfully!');

        return json_encode(array(
            'status'=>200,
            'message'=>'Added Successfully',
        ));
    }

    public function document_type_update(Request $request)
    {
      doc_type::where('id', $request->docID)->update([
            'doc_type' => $request->docType,
            'desc' => $request->docDesc,
        ]);

        __notification_set(1,'Success','Type'.$request->docType.' Updated Successfully!');

    }

    public function document_type_delete(Request $request)
    {
        doc_type::where('id', $request->docID)->update([
            'active' => false,
        ]);
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
                    'note' => $request->note,
                ]);

                $this->sendToAllEmployees($request);

            }else {

                //store User Tracks
                if ($request->has('employee')) {

                    foreach ($request->employee as $key => $user_id) {

                        $add_tracks = [
                            'track_number' => $request->docID,
                            'type' => $request->__from,
                            'type_id' => $request->senderID,
                            'for_status' => 3,
                            'target_user_id' => $user_id,
                            'action' => 0,
                            'seen' => 0,
                            'note' => $request->note,
            //  'message_note' => $request->note,
                            'created_by' => Auth::user()->employee,
                            'target_type' => 'user',
                            'target_id' => $user_id,
                            'last_activity' => false,
                        ];
                        doc_track::create($add_tracks);

                        createNotification('document', $request->docID, 'user', Auth::user()->employee, $user_id, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
                    }
                }

                //store Group Tracks
                if ($request->groups) {
                    foreach ($request->groups as $key => $groupID) {

                        $getGroupID = doc_user_rc_g::where('type', 'group')->where('type_id', $groupID)->get();

                        foreach ($getGroupID as $grpID) {

                            $add_tracks = [
                                'track_number' => $request->docID,
                                'type' => $request->__from,
                                'type_id' => $request->senderID,
                                'for_status' => 3,
                                'target_user_id' => $grpID->user_id,
                                'action' => 0,
                                'seen' => 0,
                                'note' => $request->note,
                        //     'message_note' => $request->note,
                                'created_by' => Auth::user()->employee,
                                'target_type' => 'group',
                                'target_id' => $groupID,
                                'last_activity' => false,
                            ];
                            doc_track::create($add_tracks);
                            createNotification('document', $request->docID, 'user', Auth::user()->employee, $grpID->user_id, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
                        }
                    }
                }

                //store RC Tracks
                if ($request->RC) {
                    foreach ($request->RC as $key => $rc_id) {

                        $getRC_ID = doc_user_rc_g::where('type', 'rc')->where('type_id', $rc_id)->get();

                        foreach ($getRC_ID as $userID) {

                            $add_tracks = [
                                'track_number' => $request->docID,
                                'type' => $request->__from,
                                'type_id' => $request->senderID,
                                'for_status' => 3,
                                'target_user_id' => $userID->user_id,
                                'action' => 0,
                                'seen' => 0,
                                'note' => $request->note,
                                //                                'message_note' => $request->note,
                                'created_by' => Auth::user()->employee,
                                'target_type' => 'rc',
                                'target_id' => $rc_id,
                                'last_activity' => false,
                            ];
                            doc_track::create($add_tracks);

                            createNotification('document', $request->docID, 'user', Auth::user()->employee, $userID->user_id, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
                        }
                    }
                }

            }
                doc_file::where('track_number', $request->docID)->update([
                    'show_author' => $request->showAuthor,
                    'trail_release' => 0,
                    'note' => $request->note,
                    'status' => 7,
                ]);

            return response()->json([
                'status' => 200,
            ]);
        }else{
            __notification_set(-1, "Recipient is Empty!", "Please select either Employees, Groups or Responsibility Center!");
        }
    }

    //Send to all Documents
    function sendToAllEmployees($request)
    {
        $getAllUsers = User::has('getUserinfo')->where('active', 1)->get();

        foreach ($getAllUsers as $users) {

            $add_tracks = [
                'track_number' => $request->docID,
                'type' => $request->__from,
                'type_id' => $request->senderID,
                'for_status' => 3,
                'target_user_id' => $users->employee,
                'action' => 0,
                'seen' => 0,
                'note' => $request->note,
                'created_by' => Auth::user()->employee,
                'target_type' => 'user',
                'target_id' => $users->employee,
            ];
            doc_track::create($add_tracks);

            createNotification('document', $request->docID, 'user', Auth::user()->employee, $users->employee, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');

        }
    }

    function sendCompleted(Request $request)
    {
        doc_file::where('track_number', $request->docID)->update([
            'status' => 7,
        ]);
    }

    function markAsComplete(Request $request)
    {
        if($request->has('swal_mark_action'))
        {
            if ($request->swal_mark_action == 1)
            {
                doc_file::where('track_number', $request->docID)->update([
                    'status' => 1,
                ]);
                __notification_set(1,'Success','Document updated as pending!');
                return response()->json([
                    'status' => 200,
                ]);
            }else if ($request->swal_mark_action == 2)
            {
                doc_file::where('track_number', $request->docID)->update([
                    'status' => 2,
                ]);
                __notification_set(1,'Success','Document updated as outgoing!');
                return response()->json([
                    'status' => 200,
                ]);
            }else
            {
                doc_file::where('track_number', $request->docID)->update([
                    'status' => 7,
                ]);
                __notification_set(1,'Success','Document updated as complete!');
                return response()->json([
                    'status' => 200,
                ]);
            }
        }
        __notification_set(-1,'Warning','Something went wrong!');
    }

    public function TrailSend_Docs(Request $request)
    {
        $data = $request->all();

        if($request->has('sendToEmps'))
        {
            if($request->is_sortable == "false")
            {

                $this->add_trail_if_not_sorted($request);


            }else
            {
                $this->add_trail_if_sorted($request);
            }
        }

        return json_encode(array(
            "data"=>$data,
            "status" => 'success'
        ));
    }

    function add_trail_if_not_sorted($request)
    {
        foreach ($request->sendToEmps as $arry_id => $user_id) {

            $check = doc_trail::where('track_number',$request->docID)->where('target_user_id',$user_id)->first();
            if(!$check){
                $add_trail = [
                    'track_number' => $request->docID,
                    'type' => $request->__from,
                    'type_id' => $request->senderID,
                    'target_user_id' => $user_id,
                    'created_by' => Auth::user()->employee,
                ];
                $trail_id = doc_trail::create($add_trail)->id;
            }
            if( $arry_id == 0){

                $add_incoming_track = [
                    'track_number' => $request->docID,
                    'doc_trail_id' => $trail_id,
                    'type' => $request->__from,
                    'type_id' => $request->senderID,
                    'target_user_id' =>$user_id,
                    'note' => $request->note,
                    'for_status' => 3,
                    'created_by' => Auth::user()->employee,
                    'last_activity' => true,
                    'target_type' => null,
                    'target_id' => null,
                ];
                $track_id = doc_track::create($add_incoming_track)->id;
                createNotification('document', $request->docID, 'user', Auth::user()->employee, $user_id, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
            }
        }

        doc_file::where('track_number', $request->docID)->update([
            'show_author' => $request->showAuthor,
            'trail_release' => 1,
            'note' => $request->note,
            'status' => 2,
        ]);

        __notification_set(1,'Success','Document has been successfully sent');
    }

    function add_trail_if_sorted($request)
    {
        foreach ($request->sendToEmps as $arry_id => $array_user_id)
        {
            foreach ($array_user_id as $user_id) {

                $check = doc_trail::where('track_number',$request->docID)->where('target_user_id',$user_id)->first();
                if(!$check){
                    $add_trail = [
                        'track_number' => $request->docID,
                        'type' => $request->__from,
                        'type_id' => $request->senderID,
                        'target_user_id' => $user_id,
                        'created_by' => Auth::user()->employee,
                    ];
                    $trail_id = doc_trail::create($add_trail)->id;
                }
                if( $arry_id == 0){

                    $add_incoming_track = [
                        'track_number' => $request->docID,
                        'doc_trail_id' => $trail_id,
                        'type' => $request->__from,
                        'type_id' => $request->senderID,
                        'target_user_id' =>$user_id,
                        'note' => $request->note,
                        'for_status' => 3,
                        'created_by' => Auth::user()->employee,
                        'last_activity' => 1,
                        'target_type' => null,
                        'target_id' => null,
                    ];
                    $track_id = doc_track::create($add_incoming_track)->id;
                    createNotification('document', $request->docID, 'user', Auth::user()->employee, $user_id, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
                }
            }

            doc_file::where('track_number', $request->docID)->update([
                'show_author' => $request->showAuthor,
                'trail_release' => 1,
                'note' => $request->note,
                'status' => 2,
            ]);

            __notification_set(1,'Success','Document has been successfully sent');
        }
    }

    function firstSendtoEmp($request){
        $data = $request->all();
        $doc_track_id = $request->docID;

        if ($request->has('sendToEmps') || $request->has('sendToGroups') || $request->has('sendToRC'))
        {
            if($request->has('sendToEmps'))
            {

                foreach ($request->sendToEmps as $key => $userID) {

                    $lastkey = count($request->sendToEmps) - 1;
                    $end_of_trail = '0';

                    if($key==$lastkey){
                        $end_of_trail = '1';
                    }
                    if($key==0){
                        $getdocfile = doc_file::where('track_number',$request->docID)->where('active',1)->first();

                        $update_doc_file = [
                            'send_via' => '1',
                            'status' => '2',
                            'holder_type' => 'user',
                            'holder_id' => $userID,
                            'holder_user_id' => $userID,
                        ];
                        doc_file::where(['id' =>  $getdocfile->id])->first()->update($update_doc_file);
                    }
                    $add_empTracks = [
                                    'doc_file_id' => $doc_track_id,
                                    'receive_date' => $request->receive_date,
                                    'type' => 'user',
                                    'type_id' => $userID,
                                    'status' => 3,
                                    'user_id' => $userID,
                                    'active' => true,
                                    'note' => $request->note,
                                    'ass_from'=> $request->senderID,
                                    'ass_from_type' => $request->__from,
                                    'end_of_trail' => $end_of_trail,
                                    'send_via' => '1',
                                    'created_by' => Auth::user()->employee,
                                ];
                                doc_file_track::create($add_empTracks);

                                createNotification('document', $request->docID, 'user', Auth::user()->employee, $userID, 'user', 'You have a document to receive with tracking number : ' . $request->docID . '.');
                }
            }

            if($request->has('sendToGroups'))
            {
                $countGroupID = $request->sendToGroups;
                $groupIDCounted = count($countGroupID);

                if ($groupIDCounted <= 1)
                {
                    foreach ($request->sendToGroups as $key => $getGroupID) {
                        $splitGroupID = explode("-", $getGroupID);

                        $groupID = $splitGroupID[0];
                    }
                }else{
                    foreach ($request->sendToGroups as $key => $getGroupID) {
                        foreach ($getGroupID as $id)
                        {
                            $splitGroupID = explode("-", $id);

                            $groupID = $splitGroupID[0];
                        }
                    }
                }
            }
            if ($request->has('sendToRC'))
            {
                $countRCID = $request->sendToRC;
                $rcIDCounted = count($countRCID);

                if ($rcIDCounted <= 1)
                {
                    foreach ($request->sendToRC as $key => $getRC_ID) {
                        $splitRCID = explode("-", $getRC_ID);

                        $rcID = $splitRCID[0];
                    }

                }else{
                    foreach ($request->sendToRC as $key => $getRC_ID) {
                        foreach ($getRC_ID as $id)
                        {
                            $splitRCID = explode("-", $id);

                            $rcID = $splitRCID[0];
                        }
                    }
                }
            }
        }else{
            __notification_set(-1, "Recipient is Empty!", "Please select either Employees, Groups or Responsibility Center!");
        }

        return json_encode(array(
            "data"=>$data,
            "add_empTracks"=>$add_empTracks,
            "lastkey"=>$lastkey,
            "getdocfile"=>$getdocfile,
            "update_doc_file"=>$update_doc_file,
            "ywa"=> $request->all(),
            "doc_track_id"=> $doc_track_id,
        ));
    }

    public function Download_Documents($path)
    {
        $getFile = doc_file_attachment::where('path', $path)->first();

        //        $file = Storage::disk('local')->path("public.documents".$path.$getFile->name);

        //$file = asset('storage/')
        //dd($file);
        //return response()->file($file);
    }


    //Backup Code
    /*Backup Code
     * Old Code for Create Documents
     public function create_documents(Request $request)
    {
        dd($request);

        $month = \date('m');
        $year = \date('Y');

        $counter = doc_file::get()->count();
        $doc_count = sprintf('%06u', $counter + 1);
        $doc_code = $year .'-'.$month .'-'.$doc_count;

        $folder_name = $request->input('document');

        if ($request->document_type_submitted == "1")
        {
            if ($folder_name)
            {
                $insert_file = [
                    'track_number' => $doc_code,
                    'name' => $request->document_title,
                    'desc' => $request->message,
                    'type_submitted' => $request->document_type_submitted,
                    'type' => $request->document_type,
                    'level' => $request->document_level,
                    'active' => true,
                    'created_by' => Auth::user()->employee,
                    'display_type' => $request->document_pub_pri_file,
                ];
                doc_file::create($insert_file);

                foreach ($folder_name as $key => $getPath) {
                    $splitDocFilePath = explode("<", $getPath);

                    $filePath = $splitDocFilePath[0];

                    $getFolder = doc_tempfiles::where('folder', $filePath)->get();

                    foreach ($getFolder as $tempFolder)
                    {
                        $docAttachment = new doc_file_attachment();
                        $docAttachment->doc_file_id = $doc_code;
                        $docAttachment->path = $tempFolder->folder;
                        $docAttachment->name = $tempFolder->filename;
                        $docAttachment->active = true;
                        $docAttachment->save();

                        Storage::copy('public/tmp/' . $tempFolder->folder. '/' . $tempFolder->filename, 'public/documents/' . $tempFolder->folder .'/'. $tempFolder->filename);

                        Storage::deleteDirectory('public/tmp/' . $tempFolder->folder);
                        $tempFolder->delete();
                    }
                }
                __notification_set(1,'Success','Document with track #: '.$doc_code.' Created Successfully!');
                return response()->json([
                    'status' => 200,
                ]);

            }else{
                __notification_set(-1, "Document Attachment is Empty!", "Please fill-up provided fields!");
            }

        }else if ($request->document_type_submitted == "2")
        {
            //for Hard Copy
            $insert_file = [
                'track_number' => $doc_code,
                'name' => $request->document_title,
                'desc' => $request->message,
                'type_submitted' => $request->document_type_submitted,
                'type' => $request->document_type,
                'level' => $request->document_level,
                'active' => true,
                'created_by' => Auth::user()->employee,
                'display_type' => $request->document_pub_pri_file,
            ];
            doc_file::create($insert_file);

            __notification_set(1,'Success','Document with track #: '.$doc_code.' Created Successfully!');
            return response()->json([
                'status' => 200,
            ]);
        }else
        {
            if ($folder_name)
            {
                $insert_file = [
                    'track_number' => $doc_code,
                    'name' => $request->document_title,
                    'desc' => $request->message,
                    'type_submitted' => $request->document_type_submitted,
                    'type' => $request->document_type,
                    'level' => $request->document_level,
                    'active' => true,
                    'created_by' => Auth::user()->employee,
                    'display_type' => $request->document_pub_pri_file,
                ];
                doc_file::create($insert_file);

                foreach ($folder_name as $key => $getPath) {
                    $splitDocFilePath = explode("<", $getPath);

                    $filePath = $splitDocFilePath[0];

                    $getFolder = doc_tempfiles::where('folder', $filePath)->get();

                    foreach ($getFolder as $tempFolder)
                    {
                        $docAttachment = new doc_file_attachment();
                        $docAttachment->doc_file_id = $doc_code;
                        $docAttachment->path = $tempFolder->folder;
                        $docAttachment->name = $tempFolder->filename;
                        $docAttachment->active = true;
                        $docAttachment->save();

                        Storage::copy('public/tmp/' . $tempFolder->folder. '/' . $tempFolder->filename, 'public/documents/' . $tempFolder->folder .'/'. $tempFolder->filename);

                        Storage::deleteDirectory('public/tmp/' . $tempFolder->folder);
                        $tempFolder->delete();
                    }
                }
                __notification_set(1,'Success','Document with track #: '.$doc_code.' Created Successfully!');
                return response()->json([
                    'status' => 200,
                ]);
            }else{
                __notification_set(-1, "Document Attachment is Empty!", "Please fill-up provided fields!");
            }
        }
    }
    */


    public function load_document_count(Request $request)
    {
        $current_user_id = Auth::user()->employee;

        $my_documents_count = doc_file::where('created_by',Auth::user()->employee)->where('active',1)->count();

        $my_documents_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium">'.$my_documents_count.'</div>';


        $incoming_docs_count = doc_track::where('active', 1)
        ->where('for_status', 3)
        ->where('action', 0)
        ->where('target_user_id', Auth::user()->employee)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->unique('track_number')->count();


        $incoming_docs_unread_count = doc_track::where('active', 1)
        ->where('for_status', 3)
        ->where('seen', 0)
        ->where('target_user_id', Auth::user()->employee)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->unique('track_number')->count();

        $has_incoming_unread = '';

        if(!$incoming_docs_unread_count == 0){
            $has_incoming_unread = '<div  class="w-2 h-2 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-white font-medium -mt-1 -mr-1 fa-beat"></div>';
        }

        $my_incoming_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium incoming_counter">'.$incoming_docs_unread_count .'/'.$incoming_docs_count.'</div>
            '.$has_incoming_unread .'
        ';


        $received_docs_count = doc_track::where('target_user_id',Auth::user()->employee)
            ->where('for_status',6)
            ->where('active',1)
            ->whereIn('action',[1,0])
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->unique('track_number')->count();

        $received_docs_unread_count = doc_track::where('target_user_id',Auth::user()->employee)
            ->where('for_status',6)
            ->where('active',1)
            ->where('seen',0)
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->unique('track_number')->count();


        $has_received_unread = '';

        if(!$received_docs_unread_count == 0){
            $has_received_unread = '<div  class="w-2 h-2 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-white font-medium -mt-1 -mr-1 fa-beat"></div>';
        }

        $my_received_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium incoming_counter">'.$received_docs_unread_count .'/'.$received_docs_count.'</div>
            '.$has_received_unread .'
        ';


        $get_doc_file_count = doc_file::where('status',2)
        ->where('active',1)
        ->where('created_by',Auth::user()->employee)
        ->get()->count();

        $my_outgoing_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium incoming_counter">'.$get_doc_file_count.'</div>';


        $hold_doc_file_count = doc_track::where('for_status',5)
            ->where('active',1)
            ->where('target_user_id',Auth::user()->employee)
            ->get()
            ->unique('track_number')->count();

        $my_hold_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium incoming_counter">'.$hold_doc_file_count.'</div>';


        $returned_doc_file_count  = doc_track::where('for_status',4)
            ->where('active',1)
            ->where('target_user_id',Auth::user()->employee)
            ->get()
            ->unique('track_number')->count();

        $my_returned_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium incoming_counter">'.$returned_doc_file_count.'</div>';

        $trash_doc_file_count = doc_file::
            where('active',false)
            ->where('created_by', Auth::user()->employee)
            ->get()->count();

        $my_trash_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium incoming_counter">'.$trash_doc_file_count.'</div>';

        $message_not_read_count = chat_viewers::with('get_conversation')->where('user_id',Auth::user()->employee)->where('read',0)->whereHas('get_conversation')->where('active',1)->get()->count();
        if($message_not_read_count == 0){

            $message_not_read_count = '';

        }

        $has_message_unread = '';
        if(!$message_not_read_count == 0){
            $has_message_unread = '<div  class="w-2 h-2 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-white font-medium -mt-1 -mr-1 fa-beat"></div>';
        }
        $messages_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium">'.$message_not_read_count.'</div>
        '.$has_message_unread .'
        ';

        $clearance_request_count = clearance_request::where('status', 1)
                                            ->orWhere('status', 12)
                                            ->get()->count();

        $has_clearance_unread = '';
        if(!$clearance_request_count == 0){
            $has_clearance_unread = '<div  class="w-2 h-2 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-white font-medium -mt-1 -mr-1 fa-beat"></div>';
        }

        $clearance_count_div = '<div class="py-1 px-2  rounded-full text-xs text-white cursor-pointer font-medium">'.$clearance_request_count.'</div>
        '.$has_clearance_unread .'
        ';

        $clearance_not_read_count = '';


        return json_encode(array(
            'my_documents_count' => $my_documents_count,
            'my_documents_count_div' => $my_documents_count_div,
            'my_incoming_count_div' => $my_incoming_count_div,
            'my_received_count_div' => $my_received_count_div,
            'my_outgoing_count_div' => $my_outgoing_count_div,
            'my_hold_count_div' => $my_hold_count_div,
            'my_returned_count_div' => $my_returned_count_div,
            'my_trash_count_div' => $my_trash_count_div,
            'incoming_docs_count' => $incoming_docs_count,
            'incoming_docs_unread_count' => $incoming_docs_unread_count,
            'current_user_id' => $current_user_id,
            'messages_count_div' => $messages_count_div,
            'clearance_count_div' => $clearance_count_div,
        ));
    }



    public function load_summary_print(Request $request){
        $data = $request->all();

        $now = date('m/d/Y g:ia');
        $status_text = '';
        $from = $request->modal_summray_from;
        $to = $request->modal_summray_to;

        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');

        $filename ='Documents '. $request->modal_summray_from.'/'.$request->modal_summray_to. ' pdf';
        //SayMeow169
        if($request->modal_summray_from &&  $request->modal_summray_to){
            $dateS = new Carbon($from);
            $dateE = new Carbon($to);
            if($request->modal_summray_status){

                $get_documents = doc_file::with('get_track_sent_to','get_track_received_by')->whereBetween('created_at', [$dateS->format('Y-m-d')." 00:00:00", $dateE->format('Y-m-d')." 23:59:59"])->where('status',$request->modal_summray_status)->where('created_by',Auth::user()->employee)->where('active',1)->get();

                // $get_documents = doc_file::with('get_track_sent_to','get_track_received_by')->where('created_by',Auth::user()->employee)->get();
            }else{
                $get_documents = doc_file::with('get_track_sent_to','get_track_received_by')->whereBetween('created_at', [$dateS->format('Y-m-d')." 00:00:00", $dateE->format('Y-m-d')." 23:59:59"])->where('created_by',Auth::user()->employee)->where('active',1)->get();

                // $get_documents = doc_file::with('get_track_sent_to','get_track_received_by')->where('created_by',Auth::user()->employee)->get();
            }
        }else{
            if($request->modal_summray_status){

                $get_documents = doc_file::with('get_track_sent_to','get_track_received_by')->where('status',$request->modal_summray_status)->where('created_by',Auth::user()->employee)->where('active',1)->get();

            }else{
                $get_documents = doc_file::with('get_track_sent_to','get_track_received_by')->where('created_by',Auth::user()->employee)->where('active',1)->get();

            }
        }





        // dd($get_documents);
        $system_image_header ='';
        $system_image_footer ='';

        if(system_settings()){
            $system_image_header = system_settings()->where('key','image_header_landscape')->first();
            $system_image_footer = system_settings()->where('key','image_footer_landscape')->first();
        }



        $pdf = PDF::loadView('Documents.print.document_summary_print',compact('get_documents','system_image_header','system_image_footer','filename','current_date','status_text','from','to'))->setPaper('a4', 'landscape');

        if ($request->modal_summray_type == 'vw') {
            return $pdf->stream($filename . '.pdf');
        } elseif ($request->modal_summray_type == 'dl') {
            return $pdf->download($filename . '.pdf');
        }

    }





}
