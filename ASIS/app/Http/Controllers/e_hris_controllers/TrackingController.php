<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\document\doc_file_track;
use App\Models\document\doc_groups;
use App\Models\document\doc_modules;
use App\Models\document\doc_notes;
use App\Models\document\doc_track;
use App\Models\document\doc_trail;
use App\Models\document\_user_privilege;
use App\Models\document\doc_user_rc_g;
use App\Models\tbl_responsibilitycenter;
use App\Models\tblemployee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */



    public function dockTracks($docCode)
    {

        /*
         * Legend: Document Status

            1  == Pending,
            2  == Outgoing,
            3  == Incoming,
            4  == Return,
            5  == Hold,
            6  == Receive,
            7  == Completed,
            8  == Release,

        */

        $Details = doc_file::with(['getDocStatus', 'getAuthor', 'getDocLevel', 'getTrackdetails', 'getAttachments'])->where('track_number', $docCode)->get();

        $Date = '';
        $trackNumber = '';
        $lastName = '';
        $firstName = '';
        $fullName = '';
        $contact = '';
        $Status ='';
        $class = '';
        $usersCount = '';
        $level = '';
        $getTrackdetails = '';
        $getDocType = '';
        $count = 0;
        $level_id = '';
        $level_doc_level ='';
        $level_class = '';
        $counter = 0;
        $getAttachments = '';


        foreach ($Details as $details)
        {
            //dd($details->getAttachments);

            $doc_name = $details->name;
            $doc_desc = $details->desc;

            $doc_created_by = $details->created_by;

            $Date = $details->created_at;
            $trackNumber = $details->track_number;

            if ($details->active == 0)
            {
                $Status = "Deleted";
                $class = "danger";

            }else
            {
                $Status = $details->getDocStatus->name;
                $class = $details->getDocStatus->class;
            }



            $lastName = $details->getAuthor->lastname;
            $firstName = $details->getAuthor->firstname;
            $contact = $details->getAuthor->contact;

            $level_id = $details->getDocLevel->id;
            $level_class = $details->getDocLevel->class;
            $level_doc_level = $details->getDocLevel->doc_level;
            $getTrackdetails = $details->getTrackdetails;
            $getDocType = $details->getDocType->doc_type;

            if ($details->getAttachments()->exists())
            {
                $getAttachments = $details->getAttachments;
                $count = $details->getAttachments->count();
            }
            if($details->getAuthor()->exists())
            {
                $fullName = $lastName.", ".$firstName;
            }else{
                $fullName = 'Author name hidden';
            }

        }

        $type_id = doc_track::where('track_number', $docCode)->get();

        foreach ($type_id as $data)
        {
            if ($data->type_id != $data->target_user_id)
            {
                $counter++;
            }
        }

        $count_recipients = doc_track::where('track_number', $docCode)->get()->unique('target_user_id')->count();

        if ($contact == "")
        {
            $contact = "No Contact Number";
        }


        $format = Carbon::parse($Date);
        $createdAt = $format->format('M d Y');

        //dd($fullName);
        return view('track.tracking', compact('doc_created_by','doc_name','doc_desc','createdAt', 'level_id', 'count', 'level_doc_level', 'level_class', 'trackNumber', 'Status', 'class', 'fullName', 'contact', 'count_recipients', 'level', 'getTrackdetails', 'getDocType', 'getAttachments'));
    }

    public function track_Docs(Request $request)
    {
        $userID = Auth::user()->employee;
        $tres = [];
        $doc_track_id = $request->doc_track_id;
        //$incomingDocs = doc_file_track::where('active',1)->where('user_id', $userID)->with(['getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus'])->get();
        $trackDocs = doc_file_track::with(['getUser','getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus'])->where('doc_file_id',$doc_track_id)->where('active',1)->get();


        foreach ($trackDocs as $dt) {
            $fullname ='';
            $seen ='';
            if($dt->getUser()->exists()){
                $fullname =  $dt->getUser->firstname .' '.$dt->getUser->lastname;
            }
            if($dt->seen == 0){
                $seen ='No';
            }else{
                $seen ='Yes';
            }
            $td = [
                "id" => $dt->getDocDetails->id,
                "track_number" => $dt->getDocDetails->track_number,
                "name" => $fullname,
                "desc" => $dt->getDocDetails->desc,
                "status" => $dt->getDocStatus->name,
                "class" => $dt->getDocStatus->class,
                "type" => $dt->getDocDetails->getDocType->doc_type,
                "level" => $dt->getDocDetails->getDocLevel->doc_level,
                "level_class" => $dt->getDocDetails->getDocLevel->class,
                "type_submitted" => $dt->getDocDetails->getDocTypeSubmitted->type,
                "created_by" => $dt->created_by,
                "created_at" => $dt->created_at->diffForHumans(),
                "seen" => $seen,
            ];
            $tres[count($tres)] = $td;

        }

        echo json_encode($tres);

    }


    //Transaction Details
    public function load_recipient(Request $request)
    {
        $load_recipient = '';
        $doc_status = '';
        $icon = '';
        $trail_receive = '';
        $get_sender = '';
        $get_note = '';

        $get_recipients = doc_track::with(['getUser', 'get_created_by', 'get_target_user', 'get_type_user', 'getDocStatus', 'get_Trail','getAttachments'])->where('track_number', $request->track_number)->orderBy('created_at', 'DESC')->get();

        $get_author = doc_file::with('getAuthor','getAttachments')->where('track_number', $request->track_number)->first();

        $time_created = $this->format_Date_Time($get_author->created_at);

        if ($get_recipients->count() == 1)
        {
            $recipient_count = 'one';
        }else{
            $recipient_count = 'more';
        }

        foreach ($get_recipients as $recipient)
        {
            $date_acted = $this->format_Date_Time($recipient->created_at);

            if (!$recipient->target_user_id == null)
            {
                if (!$recipient->target_user_id == null)
                {
                    if($recipient->for_status == 3)
                    {
                        $doc_status = '<div class="font-normal">Document has been released to</div>';

                        $get_sender = $recipient->type_id;
                        $icon = '<div class="w-6 h-6 mt-2 ml-2 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/release-01.png">
                        </div>';
                        $full_name = $recipient->getUser->firstname." ".$recipient->getUser->lastname;



                    }elseif($recipient->for_status == 4)
                    {
                        $doc_status = '<div class="font-normal">Document has been returned by</div>';

                        $get_note = $recipient->note;
                        $get_sender = $recipient->type_id;

                        $icon = '<div class="w-6 h-6 mt-2 ml-2 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/returned-01.png">
                        </div>';
                        $full_name = $recipient->get_created_by->firstname." ".$recipient->get_created_by->lastname;

                    }elseif($recipient->for_status == 5)
                    {
                        $doc_status = '<div class="font-normal">Document has been held by</div>';

                        $get_note = $recipient->note;
                        $get_sender = $recipient->type_id;

                        $icon = '<div class="w-6 h-6 mt-2 ml-2 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/hold-01.png">
                        </div>';
                        $full_name = $recipient->get_created_by->firstname." ".$recipient->get_created_by->lastname;

                    }elseif($recipient->for_status == 6)
                    {
                        $doc_status = '<div class="font-normal">Document has been received by</div>';

                        $get_note = $recipient->note;
                        $get_sender = $recipient->type_id;

                        $icon = '<div class="w-6 h-6 mt-2 ml-2 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/receive-01.png">
                        </div>';
                        $full_name = $recipient->get_created_by->firstname." ".$recipient->get_created_by->lastname;

                    }

                }else
                {
                    $doc_status = '<div class="font-normal">Document has been released by</div>';
                    $full_name = $recipient->get_created_by->firstname." ".$recipient->get_created_by->lastname;
                    $get_sender = $recipient->type_id;
                }

            }else
            {
                $doc_status = '<div class="font-normal">Document has been released by</div>';
                $full_name = $recipient->get_created_by->firstname." ".$recipient->get_created_by->lastname;
                $get_sender = $recipient->type_id;
            }

            if($recipient->last_activity == true && $recipient->for_status == 3)
            {
                $icon = '<div class="w-6 h-6 mt-2 ml-2 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/pending-01.png">
                        </div>';
                $get_sender = $recipient->type_id;
            }elseif($recipient->last_activity == true && $recipient->for_status == 6)
            {
                $icon = '<div class="w-8 h-8 mt-1 ml-1 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/checked-01.png">
                        </div>';
                $get_sender = $recipient->type_id;
                $full_name = $recipient->get_created_by->firstname." ".$recipient->get_created_by->lastname;
            }


            /*Backup Code
            if($recipient->for_status == 6 && $recipient->action == false && $recipient->last_activity == true)
            {
                $icon = '<div class="w-8 h-8 ml-1 mt-1 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/checked-01.png">
                        </div>';
                $get_sender = $recipient->type_id;

            }elseif ($recipient->for_status == 6 && $recipient->action == true && $recipient->last_activity == false)
            {
                //If na receive then na actionan
                $icon = '<div class="w-6 h-6 mt-2 ml-2 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/receive-01.png">
                        </div>';

            }elseif ($recipient->for_status == 3 && $recipient->action == true && $recipient->last_activity == true)
            {
                //If na release then na actionan
                $icon = '<div class="w-4 h-4 mt-3 ml-3 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/done.png">
                        </div>';
            }elseif ($recipient->for_status == 3 && $recipient->action == false && $recipient->last_activity == false)
            {
                //If na release then na actionan
                $icon = '<div class="w-4 h-4 mt-3 ml-3 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/release-01.png">
                        </div>';
            }else{

                //Pinaka Latest update sa document
                $icon = '<div class="w-8 h-8 mt-1 ml-1 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                            <img alt="to load" src="../../dist/images/latest-01.png">
                        </div>';
            }*/
            $note_ = '';
            $attchments = '';
            $count_text = '';
            if($recipient->note){
                $note_ = $recipient->note;
            }

            if($recipient->getAttachments()->exists()){
                $count_file = $recipient->getAttachments->where('created_by',$recipient->created_by)->count();
                if( $count_file != 0){
                    $count_text = '<div class="text-xs text-slate-500 pt-2">has '.$count_file.' file(s).</div>';
                }
                    $attchments .= '<div class="text-slate-500">
                    '.$count_text.'
                    <div class="flex mt-2">';
                    foreach($recipient->getAttachments->where('created_by',$recipient->created_by) as $attcmnts)
                    {
                        if($attcmnts->path)
                        {
                            $attchments .='
                            <div class="tooltip image-fit  zoom-in" title="'.$attcmnts->name.'">
                            <div class="flex items-center "><a href="/documents/download-documents/'.$attcmnts->path.'" target="_blank"> <i class="fa fa-file text-slate-500 mr-2"></i></a></div>
                            </div>';
                        }

                        if($attcmnts->url)
                        {
                            $attchments .='
                            <div class="tooltip image-fit  zoom-in" title="'.$attcmnts->name.'">
                            <div class="flex items-center "><a href="'.$attcmnts->url.'" target="_blank"> <i class="fa fa-file text-slate-500 mr-2"></i></a></div>
                            </div>';
                        }

                    }
                        $attchments .='</div>
                </div>';


            }


            $load_recipient .=
                '<div id="transaction_details"
                        data-trans-id="'.$recipient->id.'"
                        data-trans-number="'.$request->track_number.'"
                        data-trans-recipient="'.$full_name.'"
                        data-trans-date="'.$recipient->created_at->diffForHumans().'"
                        data-trans-statsid="'.$recipient->for_status.'"
                        data-trans-status="'.$recipient->getDocStatus->name.'"
                        data-status-class="'.$recipient->getDocStatus->class.'"
                        data-trans-note="'.$get_note.'"
                        data-trans-sender="'.$get_sender.'"
                        data-date-acted="'.$date_acted.'"

                        data-tw-toggle="modal" data-tw-target="#open_transaction_details"
                        class="intro-x relative flex items-center mb-3">

                    <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                        '.$icon.'
                    </div>
                    <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                        <div class="flex items-center">
                        <div class="text-slate-500 mt-1">
                        '.$doc_status.'
                        </div>
                        <div class="text-xs text-slate-500 ml-auto ">'.$date_acted.'</div>
                        </div>

                        <div class="flex items-center">
                            <div class="font-medium">
                                <div class="font-medium">'.$full_name.'</div>
                                <div class="text-xs text-slate-500 ">'.$note_.'</div>
                            </div>

                        </div>
                            '. $attchments.'
                    </div>
                </div>';
        }

        //        $created_by = '<div class="box px-4 py-4 mb-3 flex items-center zoom-in">
        //                            <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
        //                                <img alt="Midone - HTML Admin Template" src="../../dist/images/profile-3.jpg">
        //                            </div>
        //                            <div class="ml-4 mr-auto">
        //                                <div class="font-medium">'.$get_author->getAuthor->firstname." ".$get_author->getAuthor->lastname.'</div>
        //                                <div class="text-slate-500 text-xs mt-0.5">created this document '.$get_author->created_at->diffForHumans().'</div>
        //                                <div class="text-slate-500 text-xs mt-0.5">'.$time_created.'</div>
        //                            </div>
        //                            <div class="py-1 px-2 rounded-full text-xs bg-success text-white cursor-pointer font-medium">
        //                                Author
        //                            </div>
        //                        </div>';
        //

        $created_by = '<div class="intro-x relative flex items-center mb-3">
                            <div class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden flex-1 zoom-in">
                                    <img alt="Profile Picture" src="../../dist/images/author.png">
                                </div>
                            </div>
                            <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">'.$get_author->getAuthor->firstname." ".$get_author->getAuthor->lastname.'</div>
                                    <div class="text-xs text-slate-500 ml-auto">'.$time_created.'</div>
                                </div>
                                <div class="text-slate-500 mt-1">created this document '.$get_author->created_at->diffForHumans().'</div>
                            </div>
                        </div>';

        return json_encode(array(
            "get_recipients" => $load_recipient,
            "recipient_count" => $recipient_count,
            "created_by"=>$created_by,
        ));

    }

    public function get_sender(Request $request)
    {
//        dd($request->transaction_sender);

        $check_document = doc_file::where('track_number', $request->transaction_number)->first();
        if ($check_document->trail_release == true)
        {
            $get_employee_details = tblemployee::where('agencyid', $request->transaction_sender)->first();

            if($get_employee_details)
            {
                $emp_full_name = $get_employee_details->firstname." ".$get_employee_details->lastname;
            }else
            {
                $emp_full_name = '';
            }


            return json_encode(array(
                "employee_name" => $emp_full_name,
            ));
        }else
        {
            $get_employee_details = tblemployee::where('agencyid', $check_document->created_by)->first();

            $emp_full_name = $get_employee_details->firstname." ".$get_employee_details->lastname;

            return json_encode(array(
                "employee_name" => $emp_full_name,
            ));
        }
    }

    public function format_Date_Time($created_at): string
    {
        $date_time = Carbon::parse($created_at);

        return format_date_time(0, $date_time);
    }

    public function add_document_notes(Request $request)
    {
        $data = $request->all();

        $add_note = [
            'title' => $request->documents_note_title,
            'desc' => $request->documents_note_message,
            'created_by' => Auth::user()->employee,
            'type_id' => $request->tracking_number,
            'type' => $request->note_type,

        ];
        $note_id = doc_notes::create($add_note)->id;

        __notification_set(1, "Note Added!", "Document note added successfully!");
        return json_encode(array(
            "data"=>$data,
            "status" => 200,
        ));
    }

    public function remove_document_notes(Request $request)
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

    public function load_file_attachments(Request $request)
    {
        $docCode = $request->tracking_number;
        $tres = [];
        $attachment_html = '';

        $Details = doc_file::with(['getAttachments'])->where('track_number', $docCode)->get();

        foreach ($Details as $details)
        {
            if ($details->getAttachments()->exists())
            {
                if($details->getAttachments)
                {
                    foreach($details->getAttachments as $attachments)
                    {

                        if($attachments->path)
                        {
                            $path = $attachments->path;
                            $name = $attachments->name;

                            $attachment_html .= '<i class="fa-solid fa-file w-4 h-4 text-slate-500 mr-2"></i><a href="/documents/download-documents/'.$path.'" target="_blank" class="underline decoration-dotted ml-1 text-toldok2">'.$name.'</a>';
                        }else
                        {
                            $link = $attachments->url;
                            $name = $attachments->name;

                            $attachment_html .= '<i class="fa-solid fa-link w-4 h-4 text-slate-500 mr-2"></i><a href="'.$link.'" target="_blank" class="underline decoration-dotted ml-1 text-toldok2">'.$name.'</a>';
                        }
                    }
                    return json_encode(array(

                        'attachment_html' => $attachment_html,

                    ));
                }
            }
        }
    }
}
