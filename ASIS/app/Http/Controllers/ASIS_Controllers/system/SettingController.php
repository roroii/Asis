<?php

namespace App\Http\Controllers\ASIS_Controllers\system;

use App\Http\Controllers\Controller;
use App\Models\applicant\applicants_tempfiles;
use App\Models\ASIS_Models\system\default_setting;
use Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Session;

class SettingController extends Controller
{
        //Account Management
        public function system_setting()
        {

            return view('admin.system_setting.system_setting');
        }



        public function add_setting(Request $request)
        {
            $data = $request->all();
            //dd($data );
            $new_val = '';
            $new_image = '';

            $user = Auth::user();
            $setting = new default_setting();
            $setting->key = $request->input('modal_set_key');
            $setting->value = $request->input('modal_set_value');
            $setting->description = $request->input('modal_set_desc');
            $setting->link = $request->input('modal_set_link');

            if ($request->hasfile('modal_set_imageUpload')) {

                $modal_set_imageUpload = $request->file('modal_set_imageUpload');
                $avatarName = $user->id . '_theG' . time() . '.' . request()->modal_set_imageUpload->getClientOriginalExtension();
                Image::make($modal_set_imageUpload)->save(public_path('/uploads/settings/' . $avatarName));
                $request->modal_set_imageUpload->storeAs('image', $avatarName);

                $new_image= $avatarName;
                if($request->modal_set_value){
                    $new_val  = $request->modal_set_value;
                }else{
                    $new_val = $avatarName;
                }

            } else {
                $new_image = $request->modal_set_current_logo;
                $new_val  = $request->modal_set_value;
            }
            //$setting->save();


            $add_update_ss = [
                'key' => $request->modal_set_key,
                'value' => $new_val,
                'description' => $request->modal_set_desc,
                'link' => $request->modal_set_link,
                'image' => $new_image,
                'created_by' =>Auth::user()->employee,
            ];

            $ss_id =  default_setting::updateOrCreate(['id' => $request->modal_set_update_id],$add_update_ss)->id;

            if($request->modal_set_update_create == 'Update'){
                __notification_set(1,'Success','System setting with key '.$request->modal_set_key.' updated successfully!');

                add_log('ss',$ss_id,'System setting updated successfully!');
            }else{
                __notification_set(1,'Success','System setting Saved successfully!');

                add_log('ss',$ss_id,'System setting Saved successfully!');
            }





            return redirect('admin/ss');
        }

        // public function _tmp_system_Upload(Request $request)
        // {
        //     //            dd($request->file('modal_set_imageUpload'));
        //     foreach ($request->file('modal_set_imageUpload') as $file) {

        //         $get_file_type = $file->getClientMimeType();
        //         $explode_file_type = explode("/", $get_file_type);
        //         $file_type = $explode_file_type[1];

        //         $fileName = date("YmdHis") . '.' . $file_type;

        //         $destinationPath = 'uploads/settings/';
        //         $file->move(public_path($destinationPath), $fileName);

        //         default_setting::create([
        //             'image' => $fileName]);

        //     //                    return $folder;
        //     }
        // }

    // public function _tmp_system_Delete()
    // {

    //     $get_img_path = request()->getContent();

    //     dd(request());

    //     $splitDocFilePath = explode("<", $get_doc_path);

    //     $filePath = $splitDocFilePath[0];

    //     $tmp_file = default_setting::where('image', $filePath)->first();

    //     if($tmp_file)
    //     {
    //         //Remove picture from public/uploads
    //         $fp = public_path("uploads/applicants") . "\\" . $tmp_file->filename;
    //         if(file_exists($fp)) {
    //             unlink($fp);
    //         }

    //         return response('');
    //     }
    // }


    public function load_system_setting()
    {
        $userID = Auth::user()->employee;

        $tres = [];

        //$incomingDocs = doc_file_track::where('active',1)->where('user_id', $userID)->with(['getDocDetails.getDocType', 'getDocDetails.getDocLevel', 'getDocDetails.getDocTypeSubmitted', 'getDocDetails.getDocStatus'])->get();

        $system_setting = default_setting::where('active',1)->get();

        $get_user_priv = Session::get('get_user_priv');
            //dd($value[0]->module_id);


        foreach ($system_setting as $ss) {

            $can_update = '';
            $can_delete = '';

            if($get_user_priv[0]->write == 1 || Auth::user()->role_name == 'Admin'){
                $can_update = '<a id="btn_update_ss" href="javascript:;" class="dropdown-item" data-ss-id="'.$ss->id.'"> <i class="fa fa-pencil-square w-4 h-4 mr-2 text-success"></i> Update </a>';
            }
            if($get_user_priv[0]->delete == 1 || Auth::user()->role_name == 'Admin'){
                $can_delete = '<a id="btn_delete_ss" href="javascript:;" class="dropdown-item" data-ss-id="'.$ss->id.'"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Delete </a>';
            }

            $td = [
                "id" => $ss->id,
                "key" => $ss->key,
                "value" => $ss->value,
                "description" => $ss->description,
                "link" => $ss->link,
                "image" => $ss->image,
                "write" => $can_update,
                "delete" =>  $can_delete,



            ];
            $tres[count($tres)] = $td;

        }
        echo json_encode($tres);

    }


    public function remove_ss(Request $request){
        $data = $request->all();

        if($request->has('ss_id')){

            $update_remove = [
                'active' => '0',
            ];
            default_setting::where(['id' =>  $request->ss_id])->first()->update($update_remove);

        }

        __notification_set(1,'Success','System setting removed successfully!');

        add_log('ss',$request->ss_id,'System setting removed successfully!');

        return json_encode(array(
            "data"=>$data,
        ));
    }

    public function load_details(Request $request){
        $data = $request->all();

        if($request->has('ss_id')){

            $get_ss = default_setting::where('active',1)
            ->where('id',$request->ss_id)
            ->first();

        }


        return json_encode(array(
            "data"=>$data,
            "get_ss"=>$get_ss,
        ));
    }
}
