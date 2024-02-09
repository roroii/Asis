<?php

namespace App\Http\Controllers\e_hris_controllers;

use App\Http\Controllers\Controller;
use App\Models\e_hris_models\document\doc_file;
use App\Models\e_hris_models\document\doc_file_attachment;
use App\Models\e_hris_models\document\doc_track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicFilesController extends Controller
{
    public function docDetails(Request $request)
    {
        $docID = $request->docID;
        $tres = [];

        $docDetails = doc_file::where('track_number', $docID)->where('active', true)->with(['getDocType', 'getDocLevel', 'getDocStatus', 'getDocTypeSubmitted', 'getAuthor'])->get();

        //update_seen
        if($request->track_id){
            doc_track::where('id', $request->track_id)->update([
                'seen' =>  1
            ]);
        }

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
                "__from" => $dt->getAuthor->firstname.' '.$dt->getAuthor->lastname,
                "recipients" => $dt->countUsersToReceive->count(),

            ];
            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }

    public function docView(Request $request)
    {
        $docID = $request->docID;
        $tres = [];

        $docAttachments = doc_file_attachment::where('doc_file_id', $docID)->where('active', true)->get();

        foreach ($docAttachments as $dt) {

            $td = [
                "id" => $dt->id,
                "doc_file_id" => $dt->doc_file_id,
                "name" => $dt->name,
                "view_count" => $dt->view_count,
                "path" => $dt->path,

            ];
            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }

    public function load_publicFiles(Request $request)
    {
        $tres = [];

        $publicFiles = doc_file::where('active',1)->where('display_type', false)->where('status', 7)->with(['getDocType', 'getDocLevel', 'getDocTypeSubmitted', 'getDocStatus', 'getAttachments'])->get();

        //        dd($created_Docs);
        foreach ($publicFiles as $dt) {

            $td = [
                "id" => $dt->id,
                "track_number" => $dt->track_number,
                "name" => $dt->name,
                "desc" => $dt->desc,
                "status" => $dt->getDocStatus->name,
                "class" => $dt->getDocStatus->class,
                "type" => $dt->getDocType->doc_type,
                "level" => $dt->getDocLevel->doc_level,
                "level_class" => $dt->getDocLevel->class,
                "type_submitted" => $dt->getDocTypeSubmitted->type,
                "created_by" => $dt->created_by,
                "created_at" => $dt->created_at,
                "recipients" => $dt->countUsersToReceive->count(),

            ];
            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }

    public function count_doc_view(Request $request)
    {
        $counter = 0;

        $counter++;

        $get_view_count = doc_file_attachment::where('id', $request->document_attachment_id)->first();

        $parse_to_int = (int)$get_view_count->view_count;

        $view_count = $parse_to_int + $counter;

        doc_file_attachment::where('id', $request->document_attachment_id)->update([
            'view_count' =>  $view_count,
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }
}
