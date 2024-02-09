<?php

namespace App\Http\Controllers\signature;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ASIS_Models\signature\user_tempfiles_model;
use App\Models\ASIS_Models\signature\user_signature_model;
use Response;
use Storage;


class mySignatureController extends Controller
{
    public function signaturePage(){
        return view('signature.mySignature_page');
    }
    
    public function tmpUploadSignature(Request $request)
    {
        $getUser_studid = User::where('studid', Auth::user()->studid)->first();

        $user_id = $getUser_studid->studid;

        if ($request->hasFile('user_signature'))
        {
            $file = $request->file('user_signature');
            $get_file_type = $file->getClientMimeType();
            $explode_file_type = explode("/", $get_file_type);
            $file_type = $explode_file_type[1];

            $fileName = $user_id.'-'.date("YmdHis").'.'.$file_type;
            $folder = $user_id.'-'.uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/tmp/' . $folder,$fileName);

            $destinationPath = 'uploads/user_signature/';
            $file->move(public_path($destinationPath), $fileName);

            user_tempfiles_model::create([
                'folder' => $folder,
                'filename' => $fileName]);

            return $folder;
        }
        return '';

    }  

    public function delete_temp_user_signature(Request $request){

        $get_doc_path = request()->getContent();
        // dd($get_doc_path);
        $splitDocFilePath = explode("<", $get_doc_path);

        $filePath = $splitDocFilePath[0];

        $tmp_file = user_tempfiles_model::where('folder', $filePath)->first();
        if($tmp_file)
        {
            //Remove picture from public/uploads
            $fp = public_path("uploads/user_signature") . "\\" . $tmp_file->filename;
            if(file_exists($fp)) {
                unlink($fp);
            }

            Storage::deleteDirectory('public/tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            return response('');
        }
    }

    public function saveSignature(Request $request){

        $user_id = Auth::user()->studid;

        $user_signature = $request->input('user_signature');

        $splitDocFilePath = explode("<", $user_signature);

        
        $filePath = $splitDocFilePath[0];

        $get_temp_user_sig = user_tempfiles_model::where('folder', $filePath)->first();

        user_signature_model::updateOrCreate(
            ['studid' => $user_id],
            [
                'studid' =>  $user_id,
                'signature' => $get_temp_user_sig->filename,
            ]
        );

        Storage::deleteDirectory('public/tmp/' . $get_temp_user_sig->filename);
        user_tempfiles_model::where('folder', $get_temp_user_sig->folder)->delete();

        return response()->json([
            'status' => 200,
        ]);

    }
}
