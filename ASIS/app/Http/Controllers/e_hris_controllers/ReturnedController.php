<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\document\doc_file_track;
use App\Models\document\doc_track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnedController extends Controller
{

    public function returned()
    {
        return view('Documents.Returned');
    }

    public function returned_Docs()
    {
        $userID = Auth::user()->employee;

        $tres = [];

        //$incomingDocs = doc_file_track::where('active',1)->where('user_id', $userID)->with(['getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus'])->get();

        $returnedDocs = doc_track::
        with(['getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus', 'getDocDetails'])
            ->where('for_status',4)
            ->where('active',1)
            ->where('target_user_id',Auth::user()->employee)
            ->get()
            ->unique('track_number');

        foreach ($returnedDocs as $dt) {
            $td = [
                "id" => $dt->getDocDetails->id,
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
                "original_note" => $dt->getDocDetails->note,
                "returned_by" => $dt->get_created_by->firstname." ".$dt->get_created_by->lastname,
                "note"=> $dt->note,
            ];
            $tres[count($tres)] = $td;

        }
        echo json_encode($tres);

    }
}
