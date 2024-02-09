<?php

namespace App\Http\Controllers\dtr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rr\Rewards;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\bioengine\BioEngineController;

use App\Models\user_roles;
use App\Models\dtr\dtr_printed;
use App\Models\dtr\dtr_attendance;
use App\Models\dtr\dtr_user_profile;

use Auth;

use Session;
use PDF;



class DTRController extends Controller
{


    /*  ============ */

    public function DB_SCHEMA() {

        return "primehrmo.";

    }

    public function DBTBL_DTR_FINGERPRINT() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "dtr_fingerprint",
        ];
        return $result;
    }

    public function DBTBL_DTR_ATTENDANCE() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "dtr_attendance",
        ];
        return $result;
    }

    public function DBTBL_EMPLOYEES() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "agency_employees",
        ];
        return $result;
    }

    public function DBTBL_PROFILE() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "profile",
        ];
        return $result;
    }

    /*  ============ */


    /* COMMON START ============ */

    public function get_current_datetime($ftype = 1) {

        $result = "";

        $result = date('Y') . "-" . date('m') . "-" . date('d') . " " . date('H') . ":" . date('i') . ":" . date('s');

        if($ftype == 1) {
            $result = date('Y') . "-" . date('m') . "-" . date('d') . " " . date('H') . ":" . date('i') . ":" . date('s');
        }
        if($ftype == 2) {
            $result = date('Y') . "" . date('m') . "" . date('d') . "" . date('H') . "" . date('i') . "" . date('s');
        }

        if($ftype == 201) {
            $result = date('m') . "/" . date('d') . "/" . date('Y');
        }

        return $result;

    }

    public function get_employee_name($uid, $ftype = 1) {

        $result = "";

        $DBDRIVER = $this->DBTBL_PROFILE()['driver'];
        $DBTBL = $this->DBTBL_PROFILE()['table'];

        $lastname = "";
        $firstname = "";
        $middlename = "";

        $qry = " SELECT * FROM " . $DBTBL . "  WHERE active='1' AND ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) ) LIMIT 1 ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $lastname = trim($cd->lastname);
                $firstname = trim($cd->firstname);
                $middlename = trim($cd->mi);
            }
        }

        $result = $firstname . " " . $middlename . " " . $lastname;

        if($ftype == 1) {

            $result = $firstname . " " . $middlename . " " . $lastname;

        }

        return $result;

    }

    /* COMMON END ============ */


    /* MANAGE BIO START ============ */


    public function manage_bio_load_view() {

        $userdata = Auth::user();
        
        if($userdata != null) {
            $user = Auth::user()->employee;
            $data = user_roles::isCurrentUserAdmin();

            if($data > 0) {
                return view('dtr.manage_dtr_bio');
            }else{
                return redirect(url('') . "/dtr/my");
            }
        }else{
            return redirect(url(''));
        }
    }

    public function manage_bio_users_list(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_EMPLOYEES()['driver'];
        $DBTBL_EMP = $this->DBTBL_EMPLOYEES()['table'];
        $DBTBL_PROFILE = $this->DBTBL_PROFILE()['table'];

        $limit = trim($request->limit);
        $search = trim($request->search);

        $limit = SQL_VALUE_CHECK($limit);
        $search = SQL_VALUE_CHECK($search);

        if(trim($limit) == "" || !is_numeric($limit)) {
            $limit = 100;
        }

        $qs = "";
        if(trim($search) != "") {
            $qs = " AND ( TRIM(LOWER(profile.lastname)) LIKE TRIM(LOWER('%" . $search . "%')) OR TRIM(LOWER(profile.firstname)) LIKE TRIM(LOWER('%" . $search . "%')) OR TRIM(LOWER(profile.mi)) LIKE TRIM(LOWER('%" . $search . "%')) ) ";
        }
        
        $tn = 0;
        $qry = " SELECT DISTINCT profile.agencyid,profile.lastname,profile.firstname,profile.mi FROM " . $DBTBL_EMP . " AS emp LEFT JOIN " . $DBTBL_PROFILE . " AS profile ON profile.agencyid=emp.agency_id WHERE emp.active='1' AND profile.active='1' " . $qs . " ORDER BY profile.lastname ASC, profile.firstname ASC, profile.mi ASC LIMIT " . $limit . " ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $result[count($result)] = $cd;
                /***/
            }
        }

        return $result;
    }

    public function manage_bio_check_employee(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_DTR_FINGERPRINT()['driver'];
        $DBTBL_FP = $this->DBTBL_DTR_FINGERPRINT()['table'];

        $emp = trim($request->employee);
        $emp = SQL_VALUE_CHECK($emp);

        $resn = 0;
        
        // CHECK : FINGERPRINT
        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL_FP . " WHERE active='1' AND ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $emp . "')) ) LIMIT 1 ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
            }
        }
        if($tn <= 0) {
        	$resn++;
        	$cd = [
        		"type" => "danger",
        		"content" => "No fingerprint data detected.",
        	];
        	$result[count($result)] = $cd;
        }

        return $result;
    }

    public function manage_bio_fingerprint_save(Request $request){
        $result = [];

        $res_code = 0;
        $res_msg = "Unable to process.";


        $DBDRIVER = $this->DBTBL_DTR_FINGERPRINT()['driver'];
        $DBTBL = $this->DBTBL_DTR_FINGERPRINT()['table'];

        $errn = 0;
        $errmsg = "";

        $uid = trim($request->uid);
        $fpdata = trim($request->fpdata);

        $uid = SQL_VALUE_CHECK($uid);
        //$fpdata = SQL_VALUE_CHECK($fpdata);

        if(trim($uid) == "") {
            $errn++;
            $errmsg = $errmsg + "UID required. ";
        }
        if(trim($fpdata) == "") {
            $errn++;
            $errmsg = $errmsg + "Fingerprint required. ";
        }

        $hasData = false;

        if($errn <= 0) {

            $tn = 0;
            $qry = " SELECT * FROM " . $DBTBL . "  WHERE active='1' LIMIT 1 ";
            $data = DB::connection($DBDRIVER)->select($qry);
            if($data) {
                foreach ($data as $cd) {
                    $tn++;
                    $hasData = true;
                }
            }

            if($hasData) {
                $qry = " UPDATE " . $DBTBL . " SET active='0'  WHERE active='1' AND ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) )  ";
                $res = DB::connection($DBDRIVER)->update($qry);
                if($res) {

                }
            }

            // INSERT
            $qry = " INSERT INTO " . $DBTBL . " (agencyid,fingerprint) VALUES ('" . $uid . "','" . $fpdata . "')  ";
            $res = DB::connection($DBDRIVER)->insert($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Data saved.";
            }else{
                $res_code = -1;
                $res_msg = "Unable to save.";
            }

        }else{
            $res_code = -1;
            $res_msg = trim($errmsg);
        }


        $result = [
            "code" => $res_code,
            "message" => $res_msg,
        ];
        
        return $result;
    }

    public function manage_bio_user_fingerprint_data_get(Request $request){
        $result = [];


        $DBDRIVER = $this->DBTBL_DTR_FINGERPRINT()['driver'];
        $DBTBL = $this->DBTBL_DTR_FINGERPRINT()['table'];

        $uid = trim($request->uid);

        $uid = SQL_VALUE_CHECK($uid);
        
        if(trim($uid) != "") {

            $tn = 0;
            $qry = " SELECT * FROM " . $DBTBL . "  WHERE active='1' AND ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) ) ORDER BY created_at DESC LIMIT 1 ";
            $data = DB::connection($DBDRIVER)->select($qry);
            if($data) {
                foreach ($data as $cd) {
                    $tn++;
                    $result = $cd;
                }
            }
            
        }

        return $result;
    }

    public function bio_api_data_get_fp_all(Request $request){
        $result = [];

        $res_code = -1;
        $res_msg = "Access denied.";
        $res_data = [];


        $DBDRIVER = $this->DBTBL_DTR_FINGERPRINT()['driver'];
        $DBTBL = $this->DBTBL_DTR_FINGERPRINT()['table'];

        $biosettings = BioEngineController::_get_settings();

        $api = trim($request->api);

        $api = SQL_VALUE_CHECK($api);

        $hasAccess = false;
        if($biosettings['api_key'] == $api) {
            $hasAccess = true;
        }
        
        if($hasAccess) {

            $tn = 0;
            $qry = " SELECT agencyid AS id,fingerprint FROM " . $DBTBL . "  WHERE active='1' ";
            $data = DB::connection($DBDRIVER)->select($qry);
            if($data) {
                foreach ($data as $cd) {
                    $tn++;
                    $res_data[count($res_data)] = $cd;
                }
            }

            if($tn > 0) {
                $res_code = 1;
                $res_msg = "Success.";
            }
            
        }

        $result = [
            "code" => $res_code,
            "message" => $res_msg,
            "data" => $res_data,
        ];

        return $result;

    }


    /* MANAGE BIO END ============ */

    /* ATTENDANCE START ============ */

    public function attendance_load_view() {

        return view('dtr.attendance');

    }

    public function attendance_data_save(Request $request){
        $result = [];

        date_default_timezone_set('Asia/Manila');

        $res_code = 0;
        $res_msg = "Unable to process.";
        $res_data = [];

        $data_name = "";


        $DBDRIVER = $this->DBTBL_DTR_ATTENDANCE()['driver'];
        $DBTBL = $this->DBTBL_DTR_ATTENDANCE()['table'];
        $DBTBL_EMP = $this->DBTBL_EMPLOYEES()['table'];
        $DBTBL_PROFILE = $this->DBTBL_PROFILE()['table'];

        $errn = 0;
        $errmsg = "";

        $uid = trim($request->uid);
        $type = trim($request->type);

        $uid = SQL_VALUE_CHECK($uid);
        $type = SQL_VALUE_CHECK($type);
        $typef = "0";
        
        if(trim(strtolower($type)) == trim(strtolower("time-in")) || trim(strtolower($type)) == trim(strtolower("0"))) {
            $typef = "0";
        }
        if(trim(strtolower($type)) == trim(strtolower("time-out")) || trim(strtolower($type)) == trim(strtolower("1"))) {
            $typef = "1";
        }

        if(trim($uid) == "") {
            $errn++;
            $errmsg = $errmsg + "UID required. ";
        }
        if(trim($type) == "") {
            $errn++;
            $errmsg = $errmsg + "Type required. ";
        }
        if(trim($typef) == "" || !is_numeric($typef)) {
            $errn++;
            $errmsg = $errmsg + "Type required. ";
        }
        // CHECK EMPLOYEE
        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL_EMP . "  WHERE active='1' AND ( TRIM(LOWER(agency_id))=TRIM(LOWER('" . $uid . "')) ) LIMIT 1 ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
            }
        }
        if($tn <= 0) {
            $errn++;
            $errmsg = $errmsg + "Invalid employee. ";
        }else{
            $qry = " SELECT * FROM " . $DBTBL_PROFILE . "  WHERE active='1' AND ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) ) LIMIT 1 ";
            $data = DB::connection($DBDRIVER)->select($qry);
            if($data) {
                foreach ($data as $cd) {
                    $lastname = trim($cd->lastname);
                    $firstname = trim($cd->firstname);
                    $middlename = trim($cd->mi);
                    $data_name = $firstname . " " . $middlename . " " . $lastname;
                }
            }
        }

        $hasData = false;

        if($errn <= 0) {

            $logtime = date("Y-m-d H:i:s");

            // INSERT
            $qry = " INSERT INTO " . $DBTBL . " (agencyid,log_time,workstate) VALUES ('" . $uid . "','" . $logtime . "','" . $typef . "')  ";
            $res = DB::connection($DBDRIVER)->insert($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Data saved.";
                $res_data = [
                    "name" => trim(strtolower($data_name)),
                ];
            }else{
                $res_code = -1;
                $res_msg = "Unable to save.";
            }

        }else{
            $res_code = -1;
            $res_msg = trim($errmsg);
        }


        $result = [
            "code" => $res_code,
            "message" => $res_msg,
            "data" => $res_data,
        ];
        
        return $result;
    }

    /* ATTENDANCE END ============ */

    /* OVERVIEW START ============ */

    public function load_overview(){

        $userdata = Auth::user();
        
        if($userdata != null) {
            $user = Auth::user()->employee;
            $data = user_roles::isCurrentUserAdmin();

            if($data > 0) {
                return view('dtr.overview');
            }else{
                return redirect(url('') . "/dtr/my");
            }
        }else{
            return redirect(url(''));
        }

    }

    public function overview_statistics_data_get(Request $request) {

        $result = [];

        $user = Auth::user()->employee;

        $count_printed_total = 0;
        $count_printed_current = 0;


        $datefrom = trim($request->datefrom);
        $dateto = trim($request->dateto);

        $datefrom = SQL_VALUE_CHECK($datefrom);
        $dateto = SQL_VALUE_CHECK($dateto);


        $data = dtr_printed::GetDTRPrintedList();
        if($data != null) {
            if(!empty($data)) {
                $count_printed_total = count($data);
            }
        }

        $data2 = dtr_printed::GetDTRPrintedListByDateRange($datefrom, $dateto);
        if($data2 != null) {
            if(!empty($data2)) {
                $count_printed_current = count($data2);
            }
        }

        $result = [
            "printed_count_total" => $count_printed_total,
            "printed_count_current" => $count_printed_current,
        ];

        return $result;

    }

    public function overview_data_list_get(Request $request) {

        $result = [];

        $user = Auth::user()->employee;


        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $datefrom = trim($request->datefrom);
        $datefrom = SQL_VALUE_CHECK($datefrom);
        $dateto = trim($request->dateto);
        $dateto = SQL_VALUE_CHECK($dateto);

        $tmpids = [];

        // GET
        $data = dtr_printed::GetDTRPrintedUserList($datefrom, $dateto);

        if($data != null) {
            if(!empty($data)) {
                if(count($data) > 0) {
                    /***/
                    foreach ($data as $cd) {
                        $id1 = $cd->agencyid;
                        $tn = 0;
                        foreach ($tmpids as $tcd) {
                            if(trim(strtolower($tcd)) == trim(strtolower($id1))) {
                                $tn++;
                                break;
                            }
                        }
                        if($tn <= 0) {
                            $tmpids[count($tmpids)] = $id1;
                            $result[count($result)] = $cd;
                        }
                    }
                    /***/
                }
            }
        }
        
        return $result;

    }

    public function overview_records_data_list_get(Request $request) {

        $result = [];

        $user = Auth::user()->employee;

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $datefrom = trim($request->datefrom);
        $datefrom = SQL_VALUE_CHECK($datefrom);
        $dateto = trim($request->dateto);
        $dateto = SQL_VALUE_CHECK($dateto);

        if(trim($id) != "") {
            // GET
            $data = dtr_printed::GetDTRPrintedUserRecordsList($id, $datefrom, $dateto);
            if($data != null) {
                if(!empty($data)) {
                    foreach ($data as $cd) {
                        /***/
                        $datefrom = $cd->datefrom;
                        $dateto = $cd->dateto;
                        $datefrom2 = "";
                        $dateto2 = "";
                        /***/
                        if(trim($datefrom) != "" && trim($dateto) != "") {
                            $datefrom2 = date('F j, Y', strtotime($datefrom));
                            $dateto2 = date('F j, Y', strtotime($dateto));
                        }
                        /***/
                        $td = [
                            "id" => $cd->id,
                            "agencyid" => $cd->agencyid,
                            "datefrom" => $cd->datefrom,
                            "dateto" => $cd->dateto,
                            "datefrom2" => $datefrom2,
                            "dateto2" => $dateto2,
                            "active" => $cd->active,
                        ];

                        $result[count($result)] = $td;
                    }
                }
            }
        }
        
        return $result;

    }

    public function overview_record_info_get(Request $request) {

        $result = [];

        $user = Auth::user()->employee;

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $info = dtr_printed::GetDTRPrintedInfoByID($id);

        $content = "";
        $details = "";

        if($info != null) {
            if(!empty($info)) {

                $uid = trim($info->agencyid);
                $datefrom = trim($info->datefrom);
                $dateto = trim($info->dateto);

                $dinfo = dtr_printed::GetDTRPrintedUserListInfoByID($id);
                if($dinfo != null) {
                    if(!empty($dinfo)) {
                        if(count($dinfo) > 0) {
                            $lastname = trim($dinfo[0]->lastname);
                            $firstname = trim($dinfo[0]->firstname);
                            $mi = trim($dinfo[0]->mi);
                            $name = $firstname . " " . $mi . " " . $lastname;
                            /***/
                            $datefrom2 = "";
                            $dateto2 = "";
                            /***/
                            if(trim($datefrom) != "" && trim($dateto) != "") {
                                $datefrom2 = date('F j, Y', strtotime($datefrom));
                                $dateto2 = date('F j, Y', strtotime($dateto));
                            }
                            /***/
                            $details = $name . " : " . $datefrom2 . " to " . $dateto2;
                            /***/
                        }
                    }
                }
                

                $content = $this->dtr_data_get_table_body_style($uid, $datefrom, $dateto);


            }
        }


        $result = [
            "details" => $details,
            "content" => $content,
        ];

        return $result;

    }

    /* OVERVIEW START ============ */

    /* MANAGE DATA START ============ */

    public function manage_data_load_view() {

        $userdata = Auth::user();

        if($userdata != null) {
            $user = Auth::user()->employee;
            $data = user_roles::isCurrentUserAdmin();

            return view('dtr.manage_data');
        }else{
            return redirect(url(''));
        }

    }

    public function manage_data_save_sata(Request $request) {

        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";
        $res_count = 0;
        $res_count_success = 0;

        $user = Auth::user()->employee;

        if($user != null && trim($user) != "") {

            $data = trim($request->data);
            $data = SQL_VALUE_CHECK($data);
            $startIndex = trim($request->startIndex);
            $startIndex = SQL_VALUE_CHECK($startIndex);
            $endIndex = trim($request->endIndex);
            $endIndex = SQL_VALUE_CHECK($endIndex);
            //$max = $endIndex + 1;
            $max = $endIndex;


            if($data != null) {

                //$tad = explode("\n", $data);
                $tad = preg_split("/\\r\\n|\\r|\\n/", $data);

                $tn = 0;
                $tcn = 0;

                //$result = "";

                if(($max) > count($tad)) {
                    $max = count($tad);
                }
                
                for($i = $startIndex; $i < $max; $i++) {
                //foreach ($tad as $cd) {

                    $cd = $tad[$i];

                    $cds = str_replace(" ", "\t", $cd);
                    $cds = str_replace("\t\t", "\t", $cds);
                    $cds = explode("\t", $cds);


                    if($cd != null && trim($cd) != "") {
                        $cd = trim($cd);
                        $cds = str_replace(" ", "\t", $cd);
                        $cds = explode("\t", $cds);

                        //$result = $result . " <=> " . $cd;
                        //return $result;

                        if(count($cds) > 0) {

                            $taid = "";

                            //$result = $result . " " . $cds[0];

                            $tid = trim($cds[0]);
                            $tdate = trim($cds[1]);
                            $ttime = trim($cds[2]);
                            $tdevid = trim($cds[3]);
                            $tlogtype = trim($cds[4]);

                            $tid = str_replace("\n", "", $tid);
                            $tid = str_replace("\t", "", $tid);
                            $tid = str_replace("\r", "", $tid);

                            $tdate = str_replace("\n", "", $tdate);
                            $tdate = str_replace("\t", "", $tdate);
                            $tdate = str_replace("\r", "", $tdate);
                            
                            $ttime = str_replace("\n", "", $ttime);
                            $ttime = str_replace("\t", "", $ttime);
                            $ttime = str_replace("\r", "", $ttime);
                            
                            $tdevid = str_replace("\n", "", $tdevid);
                            $tdevid = str_replace("\t", "", $tdevid);
                            $tdevid = str_replace("\r", "", $tdevid);
                            
                            $tlogtype = str_replace("\n", "", $tlogtype);
                            $tlogtype = str_replace("\t", "", $tlogtype);
                            $tlogtype = str_replace("\r", "", $tlogtype);

                            $tdt = $tdate . " " . $ttime;


                            if($tid != "" && $tdate != "" && $ttime != "" && $tlogtype != "") {

                                $tcn++;

                                if(trim($taid) == "") {
                                    $taid = dtr_user_profile::GetUserAgencyIDByBioID($tid);
                                }
                                $res = dtr_attendance::AddAttendanceData($taid, $tid, $tdt, $tlogtype);
                                //$result = $res;
                                if($res) {
                                    $tn++;
                                }
                            }

                        }
                    }


                    if($tcn >= 5) {
                        //break;
                    }

                }

                $res_count = $tcn;
                $res_count_success = $tn;

                if($tn > 0) {
                    $res_code = 1;
                    $res_msg = "Data saved.";
                }
                if($tcn > 0) {
                    if($tn <= 0) {
                        $res_code = -1;
                        $res_msg = $res_count . " data already saved.";
                    }
                }else{
                    $res_code = -1;
                    $res_msg = "No valid data detected.";
                }

            }
            
        }

        $result = [
            "code" => $res_code,
            "message" => $res_msg,
            "data_count" => $res_count,
            "success_count" => $res_count_success,
        ];

        return $result;

    }


    public function manage_dtr_remarks_load_view() {

        $userdata = Auth::user();

        if($userdata != null) {
            $user = Auth::user()->employee;
            $data = user_roles::isCurrentUserAdmin();

            return view('dtr.manage_dtr_remarks');
        }else{
            return redirect(url(''));
        }

    }

    public function manage_dtr_remarks_data_get(Request $request){
        $result = "";


        $user = Auth::user()->employee;

        $uid = trim($request->uid);
        $datefrom = trim($request->datefrom);
        $dateto = trim($request->dateto);
        $bioid = "";

        $uid = SQL_VALUE_CHECK($uid);
        $datefrom = SQL_VALUE_CHECK($datefrom);
        $dateto = SQL_VALUE_CHECK($dateto);

        if(trim($uid) == "") {
            $uid = $user;
        }

        if(trim($bioid) == "") {
            $bioid = dtr_user_profile::GetUserBioID($uid);
        }

        $result = $this->manage_dtr_remarks_data_get_table_body_style($uid, $bioid, $datefrom, $dateto);

        return $result;
    }

    public function manage_dtr_remarks_data_get_table_body_style($uid, $bioid, $datefrom, $dateto) {

        $result = "";

        $DBDRIVER = $this->DBTBL_DTR_ATTENDANCE()['driver'];
        $DBTBL = $this->DBTBL_DTR_ATTENDANCE()['table'];

        $am_hour_max = 12;
        $pm_hour_start = 13;
        $ws_in = 0;
        $ws_out = 1;



        if(trim($uid) != "") {

            $date_from_year = 2023;
            $date_from_month = 1;
            $date_from_day = 1;
            $date_to_year = 2023;
            $date_to_month = 1;
            $date_to_day = 1;

            if(trim($datefrom) != "") {
                $ttime = strtotime($datefrom);
                $date_from_year = (int)("" . date("Y", $ttime));
                $date_from_month = (int)("" . date("m", $ttime));
                $date_from_day = (int)("" . date("d", $ttime));
            }
            if(trim($dateto) != "") {
                $ttime = strtotime($dateto);
                $date_to_year = (int)("" . date("Y", $ttime));
                $date_to_month = (int)("" . date("m", $ttime));
                $date_to_day = (int)("" . date("d", $ttime));
            }
            if($date_to_month != $date_from_month) {
                $date_to_month = $date_from_month;
            }

            $days = cal_days_in_month(CAL_GREGORIAN,$date_from_month,$date_from_year);

            $dstart = $date_from_day;
            $dend = $date_to_day;
            if($dend > $days) {
                $dend = $days;
            }


            $date_value = "" . trim($date_from_year);
            $dmonth = trim($date_from_month);
            if(strlen($dmonth) < 1) {
                $dmonth = "0" . $dmonth;
            }


            for($i=$dstart; $i<=$dend; $i++) {
                /***/
                $am_in = "";
                $am_out = "";
                $pm_in = "";
                $pm_out = "";
                $remarks = "";
                /***/
                $dday = trim($i);
                if(strlen($dday) < 1) {
                    $dday = "0" . $dday;
                }
                /***/
                $remarks_edit = '<button class="manage-dtr-remarks-edit-icon b_r_action" data-type="action" data-target="show-edit-remarks" data-id="' . $uid . '" data-bioid="' . $bioid . '" data-year="' . $date_from_year . '" data-month="' . $dmonth . '" data-day="' . $dday . '"><i class="far fa-edit"></i></button>';
                /***/
                $q1 = " ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) OR ( TRIM(bioid) != '' AND bioid IS NOT NULL AND TRIM(LOWER(bioid))=TRIM(LOWER('" . $bioid . "')) ) ) ) AND ( YEAR(log_time)=" . $date_from_year . " AND MONTH(log_time)=" . $date_from_month . " AND DAY(log_time)=" . $i . " ";
                /***/
                // AM : IN
                $tn = 0;
                $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $am_hour_max . " ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                $data = DB::connection($DBDRIVER)->select($qry);
                if($data) {
                    foreach ($data as $cd) {
                        $tn++;
                        /***/
                        $log_time = trim($cd->log_time);
                        if($log_time != "") {
                            $ttime = strtotime($log_time);
                            $tv = date("h:i:s", $ttime);
                            //echo $tv . "\n";
                            $am_in = $tv;
                            break;
                        }
                        /***/
                    }
                }
                // AM : OUT
                $tn = 0;
                $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                $data = DB::connection($DBDRIVER)->select($qry);
                if($data) {
                    foreach ($data as $cd) {
                        $tn++;
                        /***/
                        $log_time = trim($cd->log_time);
                        if($log_time != "") {
                            $ttime = strtotime($log_time);
                            $tv = date("h:i:s", $ttime);
                            //echo $tv . "\n";
                            $am_out = $tv;
                            break;
                        }
                        /***/
                    }
                }
                // PM : IN
                $tn = 0;
                $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $am_hour_max . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_in . "')) ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                $data = DB::connection($DBDRIVER)->select($qry);
                if($data) {
                    foreach ($data as $cd) {
                        $tn++;
                        /***/
                        $log_time = trim($cd->log_time);
                        if($log_time != "") {
                            $ttime = strtotime($log_time);
                            $tv = date("h:i:s", $ttime);
                            //echo $tv . "\n";
                            $pm_in = $tv;
                            break;
                        }
                        /***/
                    }
                }
                // PM : OUT
                $tn = 0;
                $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                $data = DB::connection($DBDRIVER)->select($qry);
                if($data) {
                    foreach ($data as $cd) {
                        $tn++;
                        /***/
                        $log_time = trim($cd->log_time);
                        if($log_time != "") {
                            $ttime = strtotime($log_time);
                            $tv = date("h:i:s", $ttime);
                            //echo $tv . "\n";
                            $pm_out = $tv;
                            break;
                        }
                        /***/
                    }
                }
                /***/
                /***/
                //echo $am_in . " " . $am_out . " " . $pm_in . " " . $pm_out;
                $tvc = '<tr><td>' . $i . '</td><td>' . $am_in . '</td><td>' . $am_out . '</td><td>' . $pm_in . '</td><td>' . $pm_out . '</td><td class="position_relative">' . $remarks . $remarks_edit . '</td></tr>';
                $result = $result . $tvc;
                /***/
            }

        }

        return $result;

    }



    /* MANAGE DATA END ============ */

    /* MY DTR START ============ */

    public function my_dtr_load_view() {

        $userdata = Auth::user();

        if($userdata != null) {
            $user = Auth::user()->employee;
            $data = user_roles::isCurrentUserAdmin();

            return view('dtr.my_dtr');
        }else{
            return redirect(url(''));
        }

    }

    public function my_dtr_data_get(Request $request){
        $result = "";


        $user = Auth::user()->employee;

        $uid = trim($request->uid);
        $datefrom = trim($request->datefrom);
        $dateto = trim($request->dateto);
        $bioid = "";

        $uid = SQL_VALUE_CHECK($uid);
        $datefrom = SQL_VALUE_CHECK($datefrom);
        $dateto = SQL_VALUE_CHECK($dateto);

        if(trim($uid) == "") {
            $uid = $user;
        }

        if(trim($bioid) == "") {
            $bioid = dtr_user_profile::GetUserBioID($uid);
        }

        $result = $this->dtr_data_get_table_body_style($uid, $bioid, $datefrom, $dateto);

        return $result;
    }

    public function dtr_data_get_table_body_style($uid, $bioid, $datefrom, $dateto) {

        $result = "";

        $DBDRIVER = $this->DBTBL_DTR_ATTENDANCE()['driver'];
        $DBTBL = $this->DBTBL_DTR_ATTENDANCE()['table'];

        $am_hour_max = 12;
        $pm_hour_start = 13;
        $ws_in = 0;
        $ws_out = 1;


        if(trim($uid) != "") {

            $date_from_year = 2023;
            $date_from_month = 1;
            $date_from_day = 1;
            $date_to_year = 2023;
            $date_to_month = 1;
            $date_to_day = 1;

            if(trim($datefrom) != "") {
                $ttime = strtotime($datefrom);
                $date_from_year = (int)("" . date("Y", $ttime));
                $date_from_month = (int)("" . date("m", $ttime));
                $date_from_day = (int)("" . date("d", $ttime));
            }
            if(trim($dateto) != "") {
                $ttime = strtotime($dateto);
                $date_to_year = (int)("" . date("Y", $ttime));
                $date_to_month = (int)("" . date("m", $ttime));
                $date_to_day = (int)("" . date("d", $ttime));
            }
            if($date_to_month != $date_from_month) {
                $date_to_month = $date_from_month;
            }

            $days = cal_days_in_month(CAL_GREGORIAN,$date_from_month,$date_from_year);

            $dstart = $date_from_day;
            $dend = $date_to_day;
            if($dend > $days) {
                $dend = $days;
            }


            for($i=$dstart; $i<=$dend; $i++) {
                /***/
                $am_in = "";
                $am_out = "";
                $pm_in = "";
                $pm_out = "";
                /***/
                $q1 = " ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) OR ( TRIM(bioid) != '' AND bioid IS NOT NULL AND TRIM(LOWER(bioid))=TRIM(LOWER('" . $bioid . "')) ) ) ) AND ( YEAR(log_time)=" . $date_from_year . " AND MONTH(log_time)=" . $date_from_month . " AND DAY(log_time)=" . $i . " ";
                /***/
                // AM : IN
                $tn = 0;
                $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $am_hour_max . " ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                $data = DB::connection($DBDRIVER)->select($qry);
                if($data) {
                    foreach ($data as $cd) {
                        $tn++;
                        /***/
                        $log_time = trim($cd->log_time);
                        if($log_time != "") {
                            $ttime = strtotime($log_time);
                            $tv = date("h:i:s", $ttime);
                            //echo $tv . "\n";
                            $am_in = $tv;
                            break;
                        }
                        /***/
                    }
                }
                // AM : OUT
                $tn = 0;
                $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                $data = DB::connection($DBDRIVER)->select($qry);
                if($data) {
                    foreach ($data as $cd) {
                        $tn++;
                        /***/
                        $log_time = trim($cd->log_time);
                        if($log_time != "") {
                            $ttime = strtotime($log_time);
                            $tv = date("h:i:s", $ttime);
                            //echo $tv . "\n";
                            $am_out = $tv;
                            break;
                        }
                        /***/
                    }
                }
                // PM : IN
                $tn = 0;
                $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $am_hour_max . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_in . "')) ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                $data = DB::connection($DBDRIVER)->select($qry);
                if($data) {
                    foreach ($data as $cd) {
                        $tn++;
                        /***/
                        $log_time = trim($cd->log_time);
                        if($log_time != "") {
                            $ttime = strtotime($log_time);
                            $tv = date("h:i:s", $ttime);
                            //echo $tv . "\n";
                            $pm_in = $tv;
                            break;
                        }
                        /***/
                    }
                }
                // PM : OUT
                $tn = 0;
                $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                $data = DB::connection($DBDRIVER)->select($qry);
                if($data) {
                    foreach ($data as $cd) {
                        $tn++;
                        /***/
                        $log_time = trim($cd->log_time);
                        if($log_time != "") {
                            $ttime = strtotime($log_time);
                            $tv = date("h:i:s", $ttime);
                            //echo $tv . "\n";
                            $pm_out = $tv;
                            break;
                        }
                        /***/
                    }
                }
                /***/
                /***/
                //echo $am_in . " " . $am_out . " " . $pm_in . " " . $pm_out;
                $tvc = '<tr><td>' . $i . '</td><td>' . $am_in . '</td><td>' . $am_out . '</td><td>' . $pm_in . '</td><td>' . $pm_out . '</td></tr>';
                $result = $result . $tvc;
                /***/
            }

        }

        return $result;

    }




    public function my_dtr_data_print(Request $request) {

        $user = Auth::user()->employee;

        //echo json_encode($request);
        //exit();

        $ft = trim($request->ft);
        $ft = SQL_VALUE_CHECK($ft);

        if($user != null && trim($user) != "") {

            if(trim(strtolower($ft)) == trim(strtolower("")) || trim(strtolower($ft)) == trim(strtolower("48"))) {
                return $this->my_dtr_data_print_form_48($request);
            }
            if(trim(strtolower($ft)) == trim(strtolower("48wr"))) {
                return $this->my_dtr_data_print_form_48_w_remarks($request);
            }
            if(trim(strtolower($ft)) == trim(strtolower("48wt"))) {
                return $this->my_dtr_data_print_form_48_w_total($request);
            }

        }
    }

    public function my_dtr_data_print_form_48(Request $request) {

        $user = Auth::user()->employee;

        $DBDRIVER = $this->DBTBL_DTR_ATTENDANCE()['driver'];
        $DBTBL = $this->DBTBL_DTR_ATTENDANCE()['table'];

        if($user != null && trim($user) != "") {

            $bioid = "";
            if(trim($bioid) == "") {
                $bioid = dtr_user_profile::GetUserBioID($user);
            }
            
            $title = "Daily Time Record";
            $content = "";
            $header = "";

            $css_v_padding_lr = "16pt";

            $rmin = 1;
            $rmax = 31;

            $am_hour_max = 12;
            $pm_hour_start = 13;
            $ws_in = 0;
            $ws_out = 1;


            $uid = trim($request->uid);
            $datefrom = trim($request->datefrom);
            $dateto = trim($request->dateto);

            $uid = SQL_VALUE_CHECK($uid);
            $datefrom = SQL_VALUE_CHECK($datefrom);
            $dateto = SQL_VALUE_CHECK($dateto);

            if(trim($uid) == "") {
                $uid = $user;
            }

            $emp_name = $this->get_employee_name($uid, 1);

            $date_from_year = 2023;
            $date_from_month = 1;
            $date_from_day = 1;
            $date_to_year = 2023;
            $date_to_month = 1;
            $date_to_day = 1;
            $month_name = "";

            if(trim($datefrom) != "") {
                $ttime = strtotime($datefrom);
                $date_from_year = (int)("" . date("Y", $ttime));
                $date_from_month = (int)("" . date("m", $ttime));
                $date_from_day = (int)("" . date("d", $ttime));
                $month_name = ("" . date("F", $ttime));
            }
            if(trim($dateto) != "") {
                $ttime = strtotime($dateto);
                $date_to_year = (int)("" . date("Y", $ttime));
                $date_to_month = (int)("" . date("m", $ttime));
                $date_to_day = (int)("" . date("d", $ttime));
            }
            if($date_to_month != $date_from_month) {
                $date_to_month = $date_from_month;
            }

            $days = cal_days_in_month(CAL_GREGORIAN,$date_from_month,$date_from_year);

            $dstart = $date_from_day;
            $dend = $date_to_day;
            if($dend > $days) {
                $dend = $days;
            }

            $vformat = "h:i:s";
            $vformat = "h:i";

            $details_1 = $month_name . " " . $date_from_day . " - " . $date_to_day . ", " . $date_from_year;


            /* BODY */
            $body_rows = "";
            for($i=$rmin; $i<=$rmax; $i++) {
                /***/
                $am_in = "";
                $am_out = "";
                $pm_in = "";
                $pm_out = "";
                /***/
                if($i >= $dstart && $i <= $dend) {
                    /***/
                    $q1 = " ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) OR ( TRIM(bioid) != '' AND bioid IS NOT NULL AND TRIM(LOWER(bioid))=TRIM(LOWER('" . $bioid . "')) ) ) ) AND ( YEAR(log_time)=" . $date_from_year . " AND MONTH(log_time)=" . $date_from_month . " AND DAY(log_time)=" . $i . " ";
                    /***/
                    // AM : IN
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $am_hour_max . " ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $am_in = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // AM : OUT
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $am_out = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // PM : IN
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $am_hour_max . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_in . "')) ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $pm_in = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // PM : OUT
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $pm_out = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    /***/
                }
                /***/
                /***/
                /***/
                $body_rows = $body_rows . '
                                    <tr>
                                        <td class="ta-center" style="font-weight: bold;">' . $i . '</td>
                                        <td class="ta-center">' . $am_in . '</td>
                                        <td class="ta-center">' . $am_out . '</td>
                                        <td class="ta-center">' . $pm_in . '</td>
                                        <td class="ta-center">' . $pm_out . '</td>
                                        <td class="ta-center"></td>
                                        <td class="ta-center"></td>
                                    </tr>
                ';
            }

            /* HEADER */

            $cont1 = "";
            $cont1 = '
                        <div style="font-style: italic; font-size: 8pt;">Civil Service Form No. 48</div>
                        <div style="font-style: normal; font-size: 12pt; font-weight: bold; text-align: center;">DAILY TIME RECORD</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">-----o0o-----</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; min-height: 8pt; border-bottom: 1px solid #000; margin-top: 8pt; padding-bottom: 2px;">' . $emp_name . '</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">(Name)</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">
                            <table class="tbl" style="width: 100%; vertical-align: top;">
                                <tr>
                                    <td style="width: 90px;">
                                        <div style="font-style: italic; font-size: 8pt;">For the month of</div>
                                    </td>
                                    <td style="width: 90%; padding-left: 4px;">
                                        <div style="font-style: normal; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000; padding: 0pt 2pt;">' . $details_1 . '</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;">
                                        <div style="font-style: italic; font-size: 8pt;">Official hours for arrival and departure</div>
                                    </td>
                                    <td style="width: 90%; padding-left: 10px;">
                                        <table class="tbl" style="width: 100%; vertical-align: top;">
                                            <tr>
                                                <td style="width: 80px;">
                                                    <div style="font-style: italic; font-size: 8pt;">Regular days</div>
                                                </td>
                                                <td style="width: 100%;">
                                                    <div style="font-style: italic; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000;"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 80px;">
                                                    <div style="font-style: italic; font-size: 8pt;">Saturdays</div>
                                                </td>
                                                <td style="width: 100%;">
                                                    <div style="font-style: italic; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000;"></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 8pt;">
                            <table class="tbl tbl-1" style="width: 100%; vertical-align: top;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="font-size: 7pt;">Day</th>
                                        <th colspan="2" style="font-size: 9pt; font-weight: bold; text-align: center;">A.M.</th>
                                        <th colspan="2" style="font-size: 9pt; font-weight: bold; text-align: center;">P.M.</th>
                                        <th colspan="2" style="font-size: 8pt; font-weight: normal; text-align: center;">Undertime</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;">Arrival</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center; max-width: 50px; width: 50px;">Departure</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;">Arrival</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center; max-width: 50px; width: 50px;">Departure</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;">Hours</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center; max-width: 50px; width: 50px;">Minutes</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 9pt;"">
                                    ' . $body_rows . '
                                </tbody>
                            </table>
                        </div>
                        <div style="font-style: italic; font-size: 7pt; text-align: left; margin-top: 16pt;">
                            I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.
                        </div>
                        <div class="uppercase" style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 16pt; border-bottom: 1px solid #000; padding-bottom: 2px;">' . $emp_name . '</div>
                        <div style="font-style: italic; font-size: 7pt; text-align: left; margin-top: 16pt;">
                            VERIFIED as to the prescribed office hours:
                        </div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 24pt; border-bottom: 1px solid #000; padding-bottom: 2px;"></div>
                        <div style="font-style: italic; font-size: 7pt; text-align: center; margin-top: 2pt;">
                            In Charge
                        </div>
            ';


            $body = '
                    <div style="">
                        <table class="tbl" style="width: 100%; vertical-align: top;">
                            <tr>
                                <td style="width: 50%; padding-right: ' . $css_v_padding_lr . ';">
                                    ' . $cont1 . '
                                </td>
                                <td style="width: 50%; padding-left: ' . $css_v_padding_lr . ';">
                                    ' . $cont1 . '
                                </td>
                            </tr>
                        </table>
                    </div>
            ';


            $tc = "";

            $content = $content . $body;

            $margins = 'margin: 24pt ' . $css_v_padding_lr . ';';

            // ADD LOG
            $this->my_dtr_printed_add($uid,$datefrom,$dateto);

            return $this->pdf_load($title, $content, "a4", "portrait", $margins);

        }

    }

    public function my_dtr_data_print_form_48_w_remarks(Request $request) {

        $user = Auth::user()->employee;

        $DBDRIVER = $this->DBTBL_DTR_ATTENDANCE()['driver'];
        $DBTBL = $this->DBTBL_DTR_ATTENDANCE()['table'];

        if($user != null && trim($user) != "") {
            
            $bioid = "";
            if(trim($bioid) == "") {
                $bioid = dtr_user_profile::GetUserBioID($user);
            }
            
            $title = "Daily Time Record";
            $content = "";
            $header = "";

            $css_v_padding_lr = "16pt";

            $rmin = 1;
            $rmax = 31;

            $am_hour_max = 12;
            $pm_hour_start = 13;
            $ws_in = 0;
            $ws_out = 1;


            $uid = trim($request->uid);
            $datefrom = trim($request->datefrom);
            $dateto = trim($request->dateto);

            $uid = SQL_VALUE_CHECK($uid);
            $datefrom = SQL_VALUE_CHECK($datefrom);
            $dateto = SQL_VALUE_CHECK($dateto);

            if(trim($uid) == "") {
                $uid = $user;
            }

            $emp_name = $this->get_employee_name($uid, 1);

            $date_from_year = 2023;
            $date_from_month = 1;
            $date_from_day = 1;
            $date_to_year = 2023;
            $date_to_month = 1;
            $date_to_day = 1;
            $month_name = "";

            if(trim($datefrom) != "") {
                $ttime = strtotime($datefrom);
                $date_from_year = (int)("" . date("Y", $ttime));
                $date_from_month = (int)("" . date("m", $ttime));
                $date_from_day = (int)("" . date("d", $ttime));
                $month_name = ("" . date("F", $ttime));
            }
            if(trim($dateto) != "") {
                $ttime = strtotime($dateto);
                $date_to_year = (int)("" . date("Y", $ttime));
                $date_to_month = (int)("" . date("m", $ttime));
                $date_to_day = (int)("" . date("d", $ttime));
            }
            if($date_to_month != $date_from_month) {
                $date_to_month = $date_from_month;
            }

            $days = cal_days_in_month(CAL_GREGORIAN,$date_from_month,$date_from_year);

            $dstart = $date_from_day;
            $dend = $date_to_day;
            if($dend > $days) {
                $dend = $days;
            }

            $vformat = "h:i:s";
            $vformat = "h:i";

            $details_1 = $month_name . " " . $date_from_day . " - " . $date_to_day . ", " . $date_from_year;


            /* BODY */
            $body_rows = "";
            for($i=$rmin; $i<=$rmax; $i++) {
                /***/
                $am_in = "";
                $am_out = "";
                $pm_in = "";
                $pm_out = "";
                /***/
                if($i >= $dstart && $i <= $dend) {
                    /***/
                    $q1 = " ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) OR ( TRIM(bioid) != '' AND bioid IS NOT NULL AND TRIM(LOWER(bioid))=TRIM(LOWER('" . $bioid . "')) ) ) ) AND ( YEAR(log_time)=" . $date_from_year . " AND MONTH(log_time)=" . $date_from_month . " AND DAY(log_time)=" . $i . " ";
                    /***/
                    // AM : IN
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $am_hour_max . " ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $am_in = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // AM : OUT
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $am_out = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // PM : IN
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $am_hour_max . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_in . "')) ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $pm_in = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // PM : OUT
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $pm_out = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    /***/
                }
                /***/
                /***/
                /***/
                $body_rows = $body_rows . '
                                    <tr>
                                        <td class="ta-center" style="font-weight: bold;">' . $i . '</td>
                                        <td class="ta-center">' . $am_in . '</td>
                                        <td class="ta-center">' . $am_out . '</td>
                                        <td class="ta-center">' . $pm_in . '</td>
                                        <td class="ta-center">' . $pm_out . '</td>
                                        <td class="ta-center"></td>
                                    </tr>
                ';
            }

            /* HEADER */

            $cont1 = "";
            $cont1 = '
                        <div style="font-style: italic; font-size: 8pt;">Civil Service Form No. 48</div>
                        <div style="font-style: normal; font-size: 12pt; font-weight: bold; text-align: center;">DAILY TIME RECORD</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">-----o0o-----</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; min-height: 8pt; border-bottom: 1px solid #000; margin-top: 8pt; padding-bottom: 2px;">' . $emp_name . '</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">(Name)</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">
                            <table class="tbl" style="width: 100%; vertical-align: top;">
                                <tr>
                                    <td style="width: 90px;">
                                        <div style="font-style: italic; font-size: 8pt;">For the month of</div>
                                    </td>
                                    <td style="width: 90%; padding-left: 4px;">
                                        <div style="font-style: normal; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000; padding: 0pt 2pt;">' . $details_1 . '</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;">
                                        <div style="font-style: italic; font-size: 8pt;">Official hours for arrival and departure</div>
                                    </td>
                                    <td style="width: 90%; padding-left: 10px;">
                                        <table class="tbl" style="width: 100%; vertical-align: top;">
                                            <tr>
                                                <td style="width: 80px;">
                                                    <div style="font-style: italic; font-size: 8pt;">Regular days</div>
                                                </td>
                                                <td style="width: 100%;">
                                                    <div style="font-style: italic; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000;"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 80px;">
                                                    <div style="font-style: italic; font-size: 8pt;">Saturdays</div>
                                                </td>
                                                <td style="width: 100%;">
                                                    <div style="font-style: italic; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000;"></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 8pt;">
                            <table class="tbl tbl-1" style="width: 100%; vertical-align: top;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="font-size: 7pt;">Day</th>
                                        <th colspan="2" style="font-size: 9pt; font-weight: bold; text-align: center;">A.M.</th>
                                        <th colspan="2" style="font-size: 9pt; font-weight: bold; text-align: center;">P.M.</th>
                                        <th colspan="1" style="font-size: 8pt; font-weight: normal; text-align: center;">Remarks</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;">Arrival</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center; max-width: 50px; width: 50px;">Departure</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;">Arrival</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center; max-width: 50px; width: 50px;">Departure</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;"></th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 9pt;"">
                                    ' . $body_rows . '
                                </tbody>
                            </table>
                        </div>
                        <div style="font-style: italic; font-size: 7pt; text-align: left; margin-top: 16pt;">
                            I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.
                        </div>
                        <div class="uppercase" style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 16pt; border-bottom: 1px solid #000; padding-bottom: 2px;">' . $emp_name . '</div>
                        <div style="font-style: italic; font-size: 7pt; text-align: left; margin-top: 16pt;">
                            VERIFIED as to the prescribed office hours:
                        </div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 24pt; border-bottom: 1px solid #000; padding-bottom: 2px;"></div>
                        <div style="font-style: italic; font-size: 7pt; text-align: center; margin-top: 2pt;">
                            In Charge
                        </div>
            ';


            $body = '
                    <div style="">
                        <table class="tbl" style="width: 100%; vertical-align: top;">
                            <tr>
                                <td style="width: 50%; padding-right: ' . $css_v_padding_lr . ';">
                                    ' . $cont1 . '
                                </td>
                                <td style="width: 50%; padding-left: ' . $css_v_padding_lr . ';">
                                    ' . $cont1 . '
                                </td>
                            </tr>
                        </table>
                    </div>
            ';


            $tc = "";

            $content = $content . $body;

            $margins = 'margin: 24pt ' . $css_v_padding_lr . ';';

            // ADD LOG
            $this->my_dtr_printed_add($uid,$datefrom,$dateto);

            return $this->pdf_load($title, $content, "a4", "portrait", $margins);

        }

    }

    public function my_dtr_data_print_form_48_w_total(Request $request) {

        $user = Auth::user()->employee;

        $DBDRIVER = $this->DBTBL_DTR_ATTENDANCE()['driver'];
        $DBTBL = $this->DBTBL_DTR_ATTENDANCE()['table'];

        if($user != null && trim($user) != "") {
            
            $bioid = "";
            if(trim($bioid) == "") {
                $bioid = dtr_user_profile::GetUserBioID($user);
            }
            
            $title = "Daily Time Record";
            $content = "";
            $header = "";

            $css_v_padding_lr = "16pt";

            $rmin = 1;
            $rmax = 31;

            $am_hour_max = 12;
            $pm_hour_start = 13;
            $ws_in = 0;
            $ws_out = 1;


            $uid = trim($request->uid);
            $datefrom = trim($request->datefrom);
            $dateto = trim($request->dateto);

            $uid = SQL_VALUE_CHECK($uid);
            $datefrom = SQL_VALUE_CHECK($datefrom);
            $dateto = SQL_VALUE_CHECK($dateto);

            if(trim($uid) == "") {
                $uid = $user;
            }

            $emp_name = $this->get_employee_name($uid, 1);

            $date_from_year = 2023;
            $date_from_month = 1;
            $date_from_day = 1;
            $date_to_year = 2023;
            $date_to_month = 1;
            $date_to_day = 1;
            $month_name = "";

            if(trim($datefrom) != "") {
                $ttime = strtotime($datefrom);
                $date_from_year = (int)("" . date("Y", $ttime));
                $date_from_month = (int)("" . date("m", $ttime));
                $date_from_day = (int)("" . date("d", $ttime));
                $month_name = ("" . date("F", $ttime));
            }
            if(trim($dateto) != "") {
                $ttime = strtotime($dateto);
                $date_to_year = (int)("" . date("Y", $ttime));
                $date_to_month = (int)("" . date("m", $ttime));
                $date_to_day = (int)("" . date("d", $ttime));
            }
            if($date_to_month != $date_from_month) {
                $date_to_month = $date_from_month;
            }

            $days = cal_days_in_month(CAL_GREGORIAN,$date_from_month,$date_from_year);

            $dstart = $date_from_day;
            $dend = $date_to_day;
            if($dend > $days) {
                $dend = $days;
            }

            $vformat = "h:i:s";
            $vformat = "h:i";

            $details_1 = $month_name . " " . $date_from_day . " - " . $date_to_day . ", " . $date_from_year;


            /* BODY */
            $body_rows = "";
            for($i=$rmin; $i<=$rmax; $i++) {
                /***/
                $am_in = "";
                $am_out = "";
                $pm_in = "";
                $pm_out = "";
                /***/
                if($i >= $dstart && $i <= $dend) {
                    /***/
                    $q1 = " ( TRIM(LOWER(agencyid))=TRIM(LOWER('" . $uid . "')) OR ( TRIM(bioid) != '' AND bioid IS NOT NULL AND TRIM(LOWER(bioid))=TRIM(LOWER('" . $bioid . "')) ) ) ) AND ( YEAR(log_time)=" . $date_from_year . " AND MONTH(log_time)=" . $date_from_month . " AND DAY(log_time)=" . $i . " ";
                    /***/
                    // AM : IN
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $am_hour_max . " ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $am_in = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // AM : OUT
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)<" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $am_out = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // PM : IN
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $am_hour_max . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_in . "')) ) ORDER BY log_time ASC, CAST(workstate AS UNSIGNED) ASC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $pm_in = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    // PM : OUT
                    $tn = 0;
                    $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND( " . $q1 . " AND HOUR(log_time)>=" . $pm_hour_start . " AND TRIM(LOWER(workstate))=TRIM(LOWER('" . $ws_out . "')) ) ORDER BY log_time DESC, CAST(workstate AS UNSIGNED) DESC ";
                    $data = DB::connection($DBDRIVER)->select($qry);
                    if($data) {
                        foreach ($data as $cd) {
                            $tn++;
                            /***/
                            $log_time = trim($cd->log_time);
                            if($log_time != "") {
                                $ttime = strtotime($log_time);
                                $tv = date($vformat, $ttime);
                                //echo $tv . "\n";
                                $pm_out = $tv;
                                break;
                            }
                            /***/
                        }
                    }
                    /***/
                }
                /***/
                /***/
                /***/
                $body_rows = $body_rows . '
                                    <tr>
                                        <td class="ta-center" style="font-weight: bold;">' . $i . '</td>
                                        <td class="ta-center">' . $am_in . '</td>
                                        <td class="ta-center">' . $am_out . '</td>
                                        <td class="ta-center">' . $pm_in . '</td>
                                        <td class="ta-center">' . $pm_out . '</td>
                                        <td class="ta-center"></td>
                                        <td class="ta-center"></td>
                                    </tr>
                ';
            }

            /* HEADER */

            $cont1 = "";
            $cont1 = '
                        <div style="font-style: italic; font-size: 8pt;">Civil Service Form No. 48</div>
                        <div style="font-style: normal; font-size: 12pt; font-weight: bold; text-align: center;">DAILY TIME RECORD</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">-----o0o-----</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; min-height: 8pt; border-bottom: 1px solid #000; margin-top: 8pt; padding-bottom: 2px;">' . $emp_name . '</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">(Name)</div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center;">
                            <table class="tbl" style="width: 100%; vertical-align: top;">
                                <tr>
                                    <td style="width: 90px;">
                                        <div style="font-style: italic; font-size: 8pt;">For the month of</div>
                                    </td>
                                    <td style="width: 90%; padding-left: 4px;">
                                        <div style="font-style: normal; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000; padding: 0pt 2pt;">' . $details_1 . '</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;">
                                        <div style="font-style: italic; font-size: 8pt;">Official hours for arrival and departure</div>
                                    </td>
                                    <td style="width: 90%; padding-left: 10px;">
                                        <table class="tbl" style="width: 100%; vertical-align: top;">
                                            <tr>
                                                <td style="width: 80px;">
                                                    <div style="font-style: italic; font-size: 8pt;">Regular days</div>
                                                </td>
                                                <td style="width: 100%;">
                                                    <div style="font-style: italic; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000;"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 80px;">
                                                    <div style="font-style: italic; font-size: 8pt;">Saturdays</div>
                                                </td>
                                                <td style="width: 100%;">
                                                    <div style="font-style: italic; font-size: 8pt; min-height: 8pt; border-bottom: 1px solid #000;"></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 8pt;">
                            <table class="tbl tbl-1" style="width: 100%; vertical-align: top;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="font-size: 7pt;">Day</th>
                                        <th colspan="2" style="font-size: 9pt; font-weight: bold; text-align: center;">A.M.</th>
                                        <th colspan="2" style="font-size: 9pt; font-weight: bold; text-align: center;">P.M.</th>
                                        <th colspan="2" style="font-size: 8pt; font-weight: normal; text-align: center;"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;">Arrival</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center; max-width: 50px; width: 50px;">Departure</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;">Arrival</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center; max-width: 50px; width: 50px;">Departure</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center;">Hours</th>
                                        <th colspan="1" style="font-size: 7pt; font-weight: bold; text-align: center; max-width: 50px; width: 50px;">Minutes</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 9pt;"">
                                    ' . $body_rows . '
                                </tbody>
                            </table>
                        </div>
                        <div style="font-style: italic; font-size: 7pt; text-align: left; margin-top: 16pt;">
                            I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.
                        </div>
                        <div class="uppercase" style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 16pt; border-bottom: 1px solid #000; padding-bottom: 2px;">' . $emp_name . '</div>
                        <div style="font-style: italic; font-size: 7pt; text-align: left; margin-top: 16pt;">
                            VERIFIED as to the prescribed office hours:
                        </div>
                        <div style="font-style: normal; font-size: 8pt; text-align: center; margin-top: 24pt; border-bottom: 1px solid #000; padding-bottom: 2px;"></div>
                        <div style="font-style: italic; font-size: 7pt; text-align: center; margin-top: 2pt;">
                            In Charge
                        </div>
            ';


            $body = '
                    <div style="">
                        <table class="tbl" style="width: 100%; vertical-align: top;">
                            <tr>
                                <td style="width: 50%; padding-right: ' . $css_v_padding_lr . ';">
                                    ' . $cont1 . '
                                </td>
                                <td style="width: 50%; padding-left: ' . $css_v_padding_lr . ';">
                                    ' . $cont1 . '
                                </td>
                            </tr>
                        </table>
                    </div>
            ';


            $tc = "";

            $content = $content . $body;

            $margins = 'margin: 24pt ' . $css_v_padding_lr . ';';

            // ADD LOG
            $this->my_dtr_printed_add($uid,$datefrom,$dateto);

            return $this->pdf_load($title, $content, "a4", "portrait", $margins);

        }

    }

    public function my_dtr_printed_add($user, $datefrom, $dateto) {

        $loguser = Auth::user()->employee;

        $DBDRIVER = $this->DBTBL_DTR_ATTENDANCE()['driver'];
        $DBTBL = $this->DBTBL_DTR_ATTENDANCE()['table'];

        if($loguser != null && trim($loguser) != "") {

            if(trim($user) != "" && trim($datefrom) != "" && trim($dateto) != "") {

                $result = dtr_printed::AddDTRPrintedData($user,$datefrom,$dateto,$loguser);

            }

        }


    }

    /* MY DTR END ============ */


    /* PDF ================================== */

    public function pdf_load($title = "Print", $content = "", $papersize = "a4", $orientation = "portrait", $margins = "margin: 0.1in 0.1in;", $fontFamily = "sans-serif"){


        $style = '@page { ' . $margins . ' } body { ' . $margins . ' font-family: sans-serif; } .tbl,.tbl tr,.tbl td,.tbl th,.tbl tbody,.tbl thead,.tbl tfoot { padding: 0; margin: 0; border-spacing: 0; } .tbl-1 td,.tbl-1 th { padding: 0; margin: 0; border-spacing: 0; border: 1px solid #000; } .ta-center { text-align: center; } .uppercase { text-transform: uppercase; } ';

        $data = [
            'title' => $title,
            'date' => date('m/d/Y'),
            'content' => $content,
            'style' => $style,
        ];

        $html = view('dtr.print', $data)->with("current_timestamp",$this->get_current_datetime(2))->with('data',$data)->render();
        return @\PDF::loadHTML($html, 'utf-8')->setPaper($papersize, $orientation)->set_option('defaultMediaType', 'all')->set_option('isFontSubsettingEnabled', true)->stream();
        
    }
 


    /* PDF ================================== */


}
