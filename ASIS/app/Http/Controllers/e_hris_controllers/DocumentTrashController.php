<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file;
use App\Models\document\doc_file_track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentTrashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function docTrashIndex()
    {
        $getTrash = doc_file::where('created_by', Auth::user()->employee)->where('active', false)->get();

        return view('Documents.TrashBin', compact('getTrash'));
    }

    public function getTrash(Request $request)
    {
        $tres = [];

        $created_Docs = doc_file::
              where('active',false)
            ->where('created_by', Auth::user()->employee)
            ->with(['getDocType', 'getDocLevel', 'getDocTypeSubmitted', 'getDocStatus', 'getAttachments'])
            ->get();

        foreach ($created_Docs as $dt) {

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


            ];
            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }
}
