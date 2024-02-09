<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file_attachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentPreviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function Download_Documents($path)
    {
        $getFile = doc_file_attachment::where('path', $path)->get();

        foreach ($getFile as $data)
        {
            $fileName = $data->name;
        }

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $pathToFile = $storagePath."public/documents/".$path."/".$fileName;

        return response()->file($pathToFile);

    }

    public function docView(Request $request)
    {
        $docID = $request->docID;
        $tres = [];
        $full_name = '';

        $docAttachments = doc_file_attachment::with('getUsers')->where('doc_file_id', $docID)->where('active', true)->get();

//        get Original Attachments
        foreach ($docAttachments as $dt) {
            if($dt->getUsers)
            {
                $full_name = $dt->getUsers->firstname.' '.$dt->getUsers->lastname;
            }

            if($dt->created_at)
            {
                $format = Carbon::parse($dt->created_at);
                $createdAt = format_date_time(0, $format);
            }

            if($dt->url)
            {
                $link = $dt->url;
            }else
            {
                $link = '';
            }

            $td = [
                "id" => $dt->id,
                "doc_file_id" => $dt->doc_file_id,
                "name" => $dt->name,
                "view_count" => $dt->view_count,
                "path" => $dt->path,
                "link" => $link,
                "added_attachments" => $dt->added_attachments,
                "full_name" => $full_name,
                "date_created" => $createdAt,
                "description" => $dt->desc,
                "check_login" => Auth::check(),
                "logged_user" => Auth::user()->employee,
                "created_by" => $dt->created_by,
            ];
            $tres[count($tres)] = $td;


        }
        echo json_encode($tres);


//        echo json_encode($docAttachments);
    }
}
