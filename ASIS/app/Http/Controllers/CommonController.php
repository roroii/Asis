<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Session;


class CommonController extends Controller
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
        //$log_user = Auth::user();

        //$this->log_user = new User;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function get_current_user() {
        $tres = "";


        $tres = Auth::user()->id;

        return $tres;
    }



    public function GetNotificationData() {

        $result = [];

        $code = 0;
        $ttl = "";
        $cont = "";

        $user = Auth::user()->id;

        if(trim($user) != "") {


            $code = Session::get('__notif_code');
            $ttl = Session::get('__notif_title');
            $cont = Session::get('__notif_content');

            if(!is_numeric($code)) {
                $code = 0;
            }

            Session::put('__notif_code',"0");
            Session::put('__notif_title',"");
            Session::put('__notif_content',"");

        }

        $result = [
            "code" => $code,
            "title" => $ttl,
            "content" => $cont,
        ];

        echo json_encode($result);

    }

    public function SetNotificationData($code = 0, $title = "", $content = "") {

        if(!is_numeric($code)) {
            $code = 0;
        }

        Session::put('__notif_code',$code);
        Session::put('__notif_title',trim($title));
        Session::put('__notif_content',trim($content));

    }

    public function get_current_timestamp($type = 1) {
        $tres = "";

        $tres = date("YmdHis");

        return $tres;
    }

    public function UploadFile($request, $uploadDirectory = "uploads", $useOriginalName = true, $filetype = "", $prefix = "", $overwrite = false) {

        $tres = [];
        $resn = 0;
        $resmsg = "";
        $rescont = "";

        $errn = 0;
        $errmsg = "";

        $uploadOk = 1;

        $target_file = "";

        $ts = $this->get_current_timestamp();

        $filename = $request->file->getClientOriginalName();
        $fileExt = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
        $fp = public_path($uploadDirectory) . "\\" . $filename;
        $target_file = $filename;

        if(trim(strtolower($filetype)) == trim(strtolower("image"))) {
            if($fileExt != "jpg" && $fileExt != "png" && $fileExt != "jpeg" &&
                $fileExt != "gif" && $fileExt != "bmp" && $fileExt != "ico" &&
                $fileExt != "svg" && $fileExt != "webp" ) {
                $errn++;
                $errmsg = $errmsg . "Invalid file type. ";
                $uploadOk = 0;
            }
        }

        if(!$useOriginalName) {
            $target_file = trim($ts) . "." . trim($fileExt);
        }

        if(trim($prefix) != "") {
            $target_file = $prefix . $target_file;
        }

        $fp = public_path($uploadDirectory) . "\\" . $target_file;

        if(file_exists($fp)) {
            if($overwrite) {
                unlink($fp);
            }else{
                $uploadOk = 0;
                $errn++;
                $errmsg = $errmsg . "File already exists. ";
            }
        }

        if($uploadOk > 0) {
            //$filepath = $request->file('file')->storeAs('uploads',$filename,'public');
            $filepath = $request->file('file')->move(public_path($uploadDirectory), $target_file);
            if(file_exists($fp) || $filepath) {
                $resn = 1;
                $rescont = $target_file;
            }else{
                $resn = 0;
                $errn++;
                $errmsg = $errmsg . "Unable to upload file. ";
            }
        }

        /*
        $target_dir = $uploadDirectory;
        $target_file = $target_dir . basename($files["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            if($overwrite) {
                unlink($target_file);
            }else{
                $errn++;
                $errmsg = $errmsg . "File already exists. " . $target_file . " ";
                $uploadOk = 0;
            }
        }

        if(trim(strtolower($filetype)) == trim(strtolower("image"))) {
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" &&
                $imageFileType != "gif" && $imageFileType != "bmp" && $imageFileType != "ico" &&
                $imageFileType != "svg" && $imageFileType != "webp" ) {
                $errn++;
                $errmsg = $errmsg . "Invalid file type. ";
                $uploadOk = 0;
            }
        }

        if ($uploadOk == 0) {
            $errn++;
            $errmsg = $errmsg . "Unable to upload file. ";
        } else {
            if (move_uploaded_file($files["tmp_name"], $target_file)) {
                $resn = 1;
                $rescont = $target_file;
            } else {
                $errn++;
                $errmsg = $errmsg . "Unable to upload file. ";
            }
        }

        */

        if($errn <= 0) {
            $resn = 1;
            $resmsg = "File uploaded.";
            $rescont = $target_file;
        }else{
            $resn = -1;
            $resmsg = trim($errmsg);
            $rescont = "";
        }

        $tres = [
            "code" => $resn,
            "message" => $resmsg,
            "content" => $rescont,
        ];

        return $tres;

    }


    public function search(Request $req) {

        $system_load_information = system_load_information();

        $username = $this->get_current_user();

        $ts = "";
        $ts = GET_RES_TIMESTAMP_2();

        $search_result = [];

        $search = trim($req->s);

        if(trim($username) != "" && trim($search) != "") {

            /* USER */

            $qry = " SELECT * FROM users WHERE active='1' AND ( TRIM(LOWER(lastname)) LIKE TRIM(LOWER('%" . $search . "%')) OR TRIM(LOWER(firstname)) LIKE TRIM(LOWER('%" . $search . "%')) OR TRIM(LOWER(middlename)) LIKE TRIM(LOWER('%" . $search . "%')) OR TRIM(LOWER(username)) LIKE TRIM(LOWER('%" . $search . "%')) OR TRIM(LOWER(name)) LIKE TRIM(LOWER('%" . $search . "%')) OR TRIM(LOWER(email)) LIKE TRIM(LOWER('%" . $search . "%')) OR TRIM(LOWER(contact_number)) LIKE TRIM(LOWER('%" . $search . "%')) ) ORDER BY name ASC ";
            $res = DB::connection('mysql')->select($qry);

            if($res) {
                foreach ($res as $cd) {

                    $committee = [];
                    $agency = [];

                    /* GET COMMITTEE START */
                    /*
                    $qry1 = " SELECT cm.committeeid,cm.memberid,comm.name,comm.details,comm.code,comm.img FROM committee_members AS cm LEFT JOIN committee AS comm ON comm.committeeid=cm.committeeid WHERE cm.active='1' AND ( TRIM(LOWER(cm.memberid))=TRIM(LOWER('" . $cd->id . "')) ) GROUP BY cm.committeeid ORDER BY cm.entrydate DESC LIMIT 5 ";
                    $res1 = DB::connection('mysql')->select($qry1);
                    if($res1) {
                        foreach ($res1 as $cd1) {
                            $img = "";
                            $img = GLOBAL_GET_COMMITTEE_PHOTO($cd1->committeeid);
                            $tv1 = [
                                "committeeid" => $cd1->committeeid,
                                "name" => $cd1->committeeid,
                                "details" => $cd1->committeeid,
                                "code" => $cd1->committeeid,
                                "img" => $img,
                            ];
                        }
                    }
                    */
                    /* GET COMMITTEE END */

                    $tv = [
                        "id" => $cd->id,
                        "lastname" => $cd->lastname,
                        "firstname" => $cd->firstname,
                        "middlename" => $cd->middlename,
                        "name" => $cd->name,
                        "email" => $cd->email,
                        "contact_number" => $cd->contact_number,
                        "committee" => $cd->committee,
                        "agency" => $cd->agency,
                    ];

                    $search_result[count($search_result)] = $tv;

                }
            }

        }

        return view('search',compact('system_load_information'))->with('timestamp',$ts)->with('search_result',$search_result)->with('s',$search);

    }



    public function testlogin() {



    }


    /* ======================================== */

}
