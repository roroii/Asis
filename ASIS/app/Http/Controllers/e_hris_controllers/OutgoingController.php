<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\document\doc_file_track;
use App\Models\document\doc_track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutgoingController extends Controller
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
    public function outgoing()
    {

        return view('Documents.Outgoing');
    }

    public function outgoing_Docs()
    {
        $userID = Auth::user()->employee;

        $tres = [];

        //Comment by montz!
//        //$incomingDocs = doc_file_track::where('active',1)->where('user_id', $userID)->with(['getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus'])->get();
//
//        $outgoingDocs = doc_track::
//        with(['getDocDetails.getDocType',
//            'getDocDetails.getDocLevel',
//            'getDocDetails.getDocTypeSubmitted',
//            'getDocDetails.getDocStatus',
//            'getDocDetails.getAuthor',
//            'getSender_Details'])
//            ->where('target_user_id',Auth::user()->employee)
//            ->where('for_status',2)
//            ->where('active',1)
//            ->where('action',0)
//            ->get()
//            ->unique('doc_file_id');
//
//        foreach ($outgoingDocs as $dt) {
//            $td = [
//                "id" => $dt->getDocDetails->id,
//                "track_number" => $dt->getDocDetails->track_number,
//                "name" => $dt->getDocDetails->name,
//                "desc" => $dt->getDocDetails->desc,
//                "status" => $dt->getDocStatus->name,
//                "class" => $dt->getDocStatus->class,
//                "type" => $dt->getDocDetails->getDocType->doc_type,
//                "level" => $dt->getDocDetails->getDocLevel->doc_level,
//                "level_class" => $dt->getDocDetails->getDocLevel->class,
//                "type_submitted" => $dt->getDocDetails->getDocTypeSubmitted->type,
//                "created_by" => $dt->created_by,
//                "created_at" => $dt->created_at,
//                "sender" => $dt->getSender_Details->firstname." ".$dt->getSender_Details->lastname,
//            ];
//            $tres[count($tres)] = $td;
//
//        }


        $getdocfile = doc_file::
        with('getTrackdetails.getDocDetails.getDocType',
        'getTrackdetails.getDocDetails.getDocLevel',
        'getTrackdetails.getDocDetails.getDocTypeSubmitted',
        'getTrackdetails.getDocDetails.getDocStatus',
        'getAuthor')
        ->where('status',2)
        ->where('active',1)
        ->where('created_by',Auth::user()->employee)
        ->get();

        foreach ($getdocfile as $doc) {
            $td = [
                "id" => $doc->id,
                "track_number" => $doc->track_number,
                "name" => $doc->name,
                "desc" => $doc->desc,
                "status" => $doc->getDocStatus->name,
                "class" => $doc->getDocStatus->class,
                "type" => $doc->getDocType->doc_type,
                "level" => $doc->getDocLevel->doc_level,
                "level_class" => $doc->getDocLevel->class,
                "type_submitted" => $doc->getDocTypeSubmitted->type,
                "created_by" => $doc->created_by,
                "created_at" => $doc->created_at,
                "sender" => $doc->getAuthor->firstname." ".$doc->getAuthor->lastname,
            ];
            $tres[count($tres)] = $td;
            # code...
        }
        //dd($getdocfile );

        echo json_encode($tres);

    }
}


