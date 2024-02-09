<?php

namespace App\Http\Controllers\Pre_Enrollees;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ASIS_Models\file_upload\temp_files;
use App\Models\ASIS_Models\posgres\portal\srgb\student;
use App\Models\ASIS_Models\pre_enrollees\pre_enrollees;
use App\Models\ASIS_Models\pre_enrollees\enrollees_address;
use App\Models\e_hris_models\ref\ref_province;
use App\Models\e_hris_models\ref\ref_citymun;
use App\Models\e_hris_models\ref\ref_brgy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('asis_auth');
    }

    public function my_profile()
    {
        return view('my_Profile.profile');
    }

    public function loadProfileInformation(Request $request)
    {

        $first_name = 'No Data';
        $last_name = 'No Data';
        $mid_name = 'No Data';
        $email = 'No Data';
        $password = 'No Data';
        $username = 'No Data';
        $name_ext = 'No Data';

        $per_province       = '';
        $per_city_mun       = '';
        $per_barangay       = '';
        $res_barangay_code  ='';
        $per_sub_village    = '';
        $per_street         = '';
        $per_house_lot_no   = '';
        $per_zip_code       = '';
        $res_province       ='';
        $res_city_mun       ='';
        $res_barangay       ='';
        $res_barangay_code  ='';
        $res_sub_village    ='';
        $res_street         ='';
        $res_house_lot_no   ='';
        $res_zip_code       ='';

        if(auth()->guard('employee_guard')->check())
        {

            /** LOAD EMPLOYEE PROFILE */

            $employee_id = auth()->guard('employee_guard')->user()->employee;

            $data = Admin::where('employee', $employee_id)->first();

            if($data)
            {
                $first_name = $data->firstname;
                $last_name = $data->lastname;
                $mid_name = $data->middlename;
                $email = $data->email;
                $password = $data->password;
                $username = $data->username;
                $profile_pic = GLOBAL_PROFILE_PICTURE_GENERATOR();
            }


            return json_encode(array(

                'profile_pic' => $profile_pic,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'middle_name' => $mid_name,
                'email' => $email,
                'password' => $password,
                'username' => $username,

            ), JSON_THROW_ON_ERROR);

        }

        elseif (auth()->guard('enrollees_guard')->check())
        {
            /** LOAD ENROLLEES PROFILE */

            $enrollees_id = auth()->guard('enrollees_guard')->user()->id;
            $pre_enrollees_id = auth()->guard('enrollees_guard')->user()->pre_enrollee_id;

            $data = pre_enrollees::where('id', $enrollees_id)->first();

            if($data)
            {
                $first_name = $data->firstname;
                $last_name = $data->lastname;
                $mid_name = $data->midname;
                $name_ext = $data->extension;
                $email = $data->email;
                $password = $data->password;
                $profile_pic = GLOBAL_PROFILE_PICTURE_GENERATOR();
            }

            $permanent_address = enrollees_address::with('get_province', 'get_city_mun', 'get_brgy')->
                                                    where('enrollees_id', $pre_enrollees_id)->
                                                    where('type', 'PERMANENT')->first();

            $residential_address = enrollees_address::with('get_province', 'get_city_mun', 'get_brgy')->
                                                    where('enrollees_id', $pre_enrollees_id)->
                                                    where('type', 'RESIDENTIAL')->first();


            if($permanent_address)
            {
                $per_province       = $permanent_address->province;
                $per_city_mun       = $permanent_address->city_mun;
                $per_barangay       = $permanent_address->barangay;
                $per_sub_village    = $permanent_address->sub_village;
                $per_street         = $permanent_address->street;
                $per_house_lot_no   = $permanent_address->house_lot_no;
                $per_zip_code       = $permanent_address->zip_code;
            }

            if($residential_address)
            {
                $res_province       = $residential_address->province;
                $res_city_mun       = $residential_address->city_mun;
                $res_barangay       = $residential_address->barangay;
                $res_sub_village    = $residential_address->sub_village;
                $res_street         = $residential_address->street;
                $res_house_lot_no   = $residential_address->house_lot_no;
                $res_zip_code       = $residential_address->zip_code;
            }

            return json_encode(array(

                'profile_pic' => $profile_pic,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'middle_name' => $mid_name,
                'name_ext' => $name_ext,
                'email' => $email,
                'password' => $password,

                'per_province'     => $per_province,
                'per_city_mun'     => $per_city_mun,
                'per_barangay'     => $per_barangay,
                'per_sub_village'  => $per_sub_village,
                'per_street'       => $per_street,
                'per_house_lot_no' => $per_house_lot_no,
                'per_zip_code'     => $per_zip_code,

                'res_province'     => $res_province,
                'res_city_mun'     => $res_city_mun,
                'res_barangay'     => $res_barangay,
                'res_sub_village'  => $res_sub_village,
                'res_street'       => $res_street,
                'res_house_lot_no' => $res_house_lot_no,
                'res_zip_code'     => $res_zip_code,

            ), JSON_THROW_ON_ERROR);

        }

    }


    public function temp_upload_profile_picture(Request $request)
    {
        $last_name = 'NULL';
        if(auth()->guard('employee_guard')->check()) {

            /** LOAD EMPLOYEE PROFILE */

            $employee_id = auth()->guard('employee_guard')->user()->employee;
            $employee_data = Admin::where('employee', $employee_id)->first();
            $last_name = $employee_data->lastname;

        }elseif (auth()->guard('enrollees_guard')->check()){

            $enrollees_id = auth()->guard('enrollees_guard')->user()->id;
            $data = pre_enrollees::where('id', $enrollees_id)->first();
            $last_name = $data->lastname;
        }



        if ($request->hasFile('up_profile_pic')) {

            foreach ($request->file('up_profile_pic')as $file )
            {

                $get_file_type = $file->getClientMimeType();
                $explode_file_type = explode("/", $get_file_type);
                $file_type = $explode_file_type[1];

                $fileName = $last_name.'-'.date("YmdHis").'.'.$file_type;
                $folder = $last_name.'-'.uniqid('', true) . '-' . now()->timestamp;
                $file->storeAs('public/tmp/' . $folder,$fileName);

                $destinationPath = 'uploads/profiles/';
                $file->move(public_path($destinationPath), $fileName);

                temp_files::create([
                    'folder' => $folder,
                    'filename' => $fileName]);

                return $folder;
            }
        }
        return '';
    }
    public function save_profile_picture(Request $request)
    {
        $old_profile_picture = $request->input('current_profile_picture_value');

        if(auth()->guard('employee_guard')->check()) {

            /** LOAD EMPLOYEE PROFILE */

            $employee_id = auth()->guard('employee_guard')->user()->employee;
            $employee_data = Admin::where('employee', $employee_id)->first();
            $last_name = $employee_data->lastname;

        }elseif (auth()->guard('enrollees_guard')->check()){

            $enrollees_id = auth()->guard('enrollees_guard')->user()->id;
            $data = pre_enrollees::where('id', $enrollees_id)->first();
            $last_name = $data->lastname;
        }

        $student_id = Auth::user()->studid;

        //Remove picture from public/uploads
        if($old_profile_picture)
        {
            $get_old_pic = User::where('studid', $student_id)->where('profile_pic', $old_profile_picture)->first();

            if($get_old_pic)
            {
                $fp = public_path("uploads/profiles") . "\\" . $get_old_pic->profile_pic;
                if(file_exists($fp)) {
                    unlink($fp);
                }
            }
        }

        $profile_pic = $request->input('up_profile_pic');

        foreach ($profile_pic as $picture)
        {
            $splitDocFilePath = explode("<", $picture);

            $filePath = $splitDocFilePath[0];

            $get_profile_picture = temp_files::where('folder', $filePath)->first();

            User::where('studid', $student_id)->update([
                'profile_pic' => $get_profile_picture->filename,
            ]);

            Storage::deleteDirectory('public/tmp/' . $get_profile_picture->folder);
            temp_files::where('folder', $get_profile_picture->folder)->delete();

        }

        return response()->json([
            'status' => 200,
        ]);
    }
    public function updateProfileInformation(Request $request)
    {
        // Check if the enrollees is authenticated using the enrollees guard
        if (Auth::guard('enrollees_guard')->check()) {

            $profile_firstname = trim($request->profile_firstname);
            $profile_midname = trim($request->profile_midname);
            $profile_lastname = trim($request->profile_lastname);
            $profile_ext = trim($request->profile_ext);

            $pre_enrollees_id = Auth::guard('enrollees_guard')->user()->pre_enrollee_id;

            $res_address_type   = trim($request->res_address_type);
            $per_address_type   = trim($request->per_address_type);
            $ref_province   = trim($request->ref_province);
            $ref_city_mun   = trim($request->ref_city_mun);
            $ref_brgy       = trim($request->ref_brgy);
            $res_sub        = trim($request->res_sub);
            $res_street     = trim($request->res_street);
            $res_house_block = trim($request->res_house_block);
            $res_zip_code   = trim($request->res_zip_code);

            $per_province   = trim($request->per_province);
            $per_city_mun   = trim($request->per_city_mun);
            $per_brgy       = trim($request->per_brgy);
            $per_sub        = trim($request->per_sub);
            $per_street     = trim($request->per_street);
            $per_house_block = trim($request->per_house_block);
            $per_zip_code   = trim($request->per_zip_code);


            pre_enrollees::where('pre_enrollee_id', $pre_enrollees_id)->update([

                'firstname'=> $profile_firstname,
                'midname'=> $profile_midname,
                'lastname' => $profile_lastname,
                'extension' => $profile_ext,
                'account_status' => 7,

            ]);

            if($res_address_type === 'RESIDENTIAL')
            {
                enrollees_address::updateOrCreate(
                    [
                        'enrollees_id'=> $pre_enrollees_id,
                        'type'=> $res_address_type,
                    ],

                    [
                        'enrollees_id'  => $pre_enrollees_id,
                        'type'          => $res_address_type,
                        'province'      => $ref_province,
                        'city_mun'      => $ref_city_mun,
                        'barangay'      => $ref_brgy,
                        'sub_village'   => $res_sub,
                        'street'        => $res_street,
                        'house_lot_no'  => $res_house_block,
                        'zip_code'      => $res_zip_code,
                        'active'        => 1,
                    ]
                );
            }

            if($per_address_type === 'PERMANENT')
            {
                enrollees_address::updateOrCreate(
                    [
                        'enrollees_id'=> $pre_enrollees_id,
                        'type'=> $per_address_type,
                    ],

                    [
                        'enrollees_id'  => $pre_enrollees_id,
                        'type'          => $per_address_type,
                        'province'      => $per_province,
                        'city_mun'      => $per_city_mun,
                        'barangay'      => $per_brgy,
                        'sub_village'   => $per_sub,
                        'street'        => $per_street,
                        'house_lot_no'  => $per_house_block,
                        'zip_code'      => $per_zip_code,
                        'active'        => 1,
                    ]
                );
            }


            return json_encode(array(

                'status' => 'success',
                'title' => 'Success',
                'message' => 'Profile Information Updated Successfully!',

            ), JSON_THROW_ON_ERROR);

        }
    }
    public function updateAccountSettings(Request $request)
    {
        // Check if the enrollees is authenticated using the enrollees guard
        if (Auth::guard('enrollees_guard')->check()) {

            $password = trim($request->account_password);

            $enrollees_id = Auth::guard('enrollees_guard')->user()->id;

            pre_enrollees::where('id', $enrollees_id)->update([

                'password'=> $password,

            ]);

            return json_encode(array(

                'status' => 'success',
                'title' => 'Success',
                'message' => 'Account Settings Updated Successfully!',

            ), JSON_THROW_ON_ERROR);

        }

        // Check if the employee is authenticated using the employee guard
        if (Auth::guard('web')->check()) {

            $password = trim($request->account_password);

            $student_id = Auth::guard('web')->user()->id;

            User::where('id', $student_id)->update([

                'password'=> $password,

            ]);

            return json_encode(array(

                'status' => 'success',
                'title' => 'Success',
                'message' => 'Account Settings Updated Successfully!',

            ), JSON_THROW_ON_ERROR);

        }
    }





    /** SELECT2  BIND ADDRESSES  */
    public function get_address_via_province(Request $request)
    {
        $brgy_option = '';
        $region_option = '';
        $municipality_option = '';

        $province = ref_province::
        with('get_region', 'get_city_mun', 'get_brgy')
            ->where('provCode', $request->provCode)->get();

        foreach ($province as $prov) {
            foreach ($prov->get_region as $region) {
                $region_option .= '<option data-ass-type="desig" value="' . $region->regCode . '">' . $region->regDesc . '</option>';
            }
            foreach ($prov->get_city_mun as $city_mun) {
                $municipality_option .= '<option data-ass-type="desig" value="' . $city_mun->citymunCode . '">' . $city_mun->citymunDesc . '</option>';
            }
            foreach ($prov->get_brgy as $brgy) {
                $brgy_option .= '<option data-ass-type="desig" value="' . $brgy->brgyCode . '">' . $brgy->brgyDesc . '</option>';
            }
        }

        return json_encode(array(

            "region_option" => $region_option,
            "municipality_option" => $municipality_option,
            "brgy_option" => $brgy_option,

        ));
    }
    public function get_address_via_municipality(Request $request)
    {
        $brgy_option = '';
        $region_option = '';
        $province_option = '';

        $municipality = ref_citymun::
        with('get_region', 'get_province', 'get_brgy')
            ->where('citymunCode', $request->city_munCode)->get();

        foreach ($municipality as $mun) {
            foreach ($mun->get_region as $region) {
                $region_option .= '<option data-ass-type="desig" value="' . $region->regCode . '">' . $region->regDesc . '</option>';
            }
            foreach ($mun->get_province as $prov) {
                $province_option .= '<option data-ass-type="desig" value="' . $prov->provCode . '">' . $prov->provDesc . '</option>';
            }
            foreach ($mun->get_brgy as $brgy) {
                $brgy_option .= '<option data-ass-type="desig" value="' . $brgy->brgyCode . '">' . $brgy->brgyDesc . '</option>';
            }
        }

        return json_encode(array(

            "region_option" => $region_option,
            "province_option" => $province_option,
            "brgy_option" => $brgy_option,

        ));
    }
    public function get_permanent_brgy(Request $request)
    {
        $per_municipality_code = $request->per_city_mun;
        $option_val = '';
        $brgy_id = '';
        $brgy_ = '';

        if($per_municipality_code)
        {
            $get_brgy = ref_brgy::where('citymunCode', $per_municipality_code)->get();
            if($get_brgy)
            {
                foreach ($get_brgy as $brgy)
                {
                    $brgy_id = $brgy->brgyCode;
                    $brgy_ = $brgy->brgyDesc;

                    $option_val .= '<option value="'.$brgy->brgyCode.'">'.$brgy->brgyDesc.'</option>';

                }

                return json_encode(array(

                    'option_value' => $option_val,
                    'brgy_id' => $brgy_id,
                    'brgy' => $brgy_,

                ), JSON_THROW_ON_ERROR);

            }
        }
    }
    public function get_residential_brgy(Request $request)
    {
        $res_municipality_code = $request->res_city_mun;
        $option_val = '';
        $brgy_id = '';
        $brgy_ = '';


        if($res_municipality_code)
        {
            $get_brgy = ref_brgy::where('citymunCode', $res_municipality_code)->get();
            if($get_brgy)
            {
                foreach ($get_brgy as $brgy)
                {
                    $brgy_id = $brgy->brgyCode;
                    $brgy_ = $brgy->brgyDesc;

                    $option_val .= '<option value="'.$brgy->brgyCode.'">'.$brgy->brgyDesc.'</option>';

                }

                return json_encode(array(

                    'option_value' => $option_val,
                    'brgy_id' => $brgy_id,
                    'brgy' => $brgy_,

                ), JSON_THROW_ON_ERROR);

            }
        }

    }

}

