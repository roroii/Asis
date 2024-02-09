<?php

namespace App\Http\Controllers;

use App\Models\document\doc_file_attachment;
use App\Models\document\doc_tempfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentAttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);
    }

    public function attach_documents(Request $request)
    {
        $folder_name = $request->attachment_document_folder;

        if($folder_name)
        {
            foreach ($folder_name as $key => $folder) {

                $getFolder = doc_tempfiles::where('folder', $folder)->get();

                foreach ($getFolder as $tempFolder)
                {
                    $insert_doc_attachment = [
                        'doc_file_id' => $request->tracking_number,
                        'name' => $tempFolder->filename,
                        'path' => $tempFolder->folder,
                        'active' => true,
                        'created_by' => Auth::user()->employee,
                        'added_attachments' => true,
                        'desc' =>$request->attachment_note,
                    ];
                    doc_file_attachment::create($insert_doc_attachment);

                    Storage::copy('public/tmp/' . $tempFolder->folder. '/' . $tempFolder->filename, 'public/documents/' . $tempFolder->folder .'/'. $tempFolder->filename);

                    Storage::deleteDirectory('public/tmp/' . $tempFolder->folder);

                    doc_tempfiles::where('folder',  $tempFolder->folder)->delete();
//                        $tempFolder->delete();
                }
            }
            return json_encode(array(
                'status'=>200,
            ));
        }
    }

    public function delete_attached_documents(Request $request)
    {
        $find_attachment = doc_file_attachment::where('path',  $request->attachment_path)->first();

//        dd($find_attachment);
        if($find_attachment)
        {
            Storage::deleteDirectory('public/tmp/' . $find_attachment->folder);
            $find_attachment->delete();

            return json_encode(array(
                'status'=>200,
            ));
        }

    }
}
