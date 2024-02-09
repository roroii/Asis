<?php

namespace App\Http\Controllers\RR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rr\Rewards;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Session;


class AwardsController extends Controller
{

    /*  ============ */

    public function DB_SCHEMA() {
        return "primehrmo.";
    }

    public function DBTBL_AWARDS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "rr_awards",
        ];
        return $result;
    }

    public function DBTBL_AWARDS_TYPES() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "rr_award_types",
        ];
        return $result;
    }

    public function DBTBL_EVENTS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "rr_events",
        ];
        return $result;
    }

    public function DBTBL_EVENTS_AWARDS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "rr_events_awards",
        ];
        return $result;
    }

    /*  ============ */


    /* COMMON DATA START ============ */

    public function get_competency_group_info($group) {
        $result = [];
        /***/
        $DBDRIVER = $this->DBTBL_GROUPS()['driver'];
        $DBTBL = $this->DBTBL_GROUPS()['table'];

        $group = SQL_VALUE_CHECK($group);

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(id))=TRIM(LOWER('" . $group . "')) ) ORDER BY created_at DESC LIMIT 1 ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $result = $cd;
                /***/
            }
        }
        /***/
        return $result;
    }

    public function get_awards_type_info($id) {
        $result = [];
        /***/
        $DBDRIVER = $this->DBTBL_AWARDS_TYPES()['driver'];
        $DBTBL = $this->DBTBL_AWARDS_TYPES()['table'];

        $id = SQL_VALUE_CHECK($id);

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ) ORDER BY created_at DESC LIMIT 1 ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $result = $cd;
                /***/
            }
        }
        /***/
        return $result;
    }
    
    /* COMMON DATA END ============ */


    /* OVERVIEW START ============ */

    public function load_view(){
        return view('rr.awards');
    }

    public function load_data(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';

        $awards = Rewards::get();

        foreach ($awards as $dt) {
            $cut=Str::limit($dt->desc, 120);
            $name='<a href="" class="font-medium whitespace-nowrap">'. $dt->name .'</a>
                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">'. $cut .'</div>';
            $td = [
                "id" => $dt->id,
                "name" => $name,
                "type" => $dt->type,
            ];

            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }

    /* OVERVIEW END ============ */
    
    /* AWARDS START ============ */

    public function awards_load_view(){
        return view('rr.awards');
    }
    
    public function awards_data_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_AWARDS()['driver'];
        $DBTBL = $this->DBTBL_AWARDS()['table'];

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' ORDER BY name ASC ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $typename = "";
                $typedata = $this->get_awards_type_info($cd->type);
                if($typedata != null && !empty($typedata)) {
                    $typename = ($typedata->name);
                }
                /***/
                $td = [
                    "id" => $cd->id,
                    "name" => $cd->name,
                    "details" => $cd->details,
                    "points" => $cd->points,
                    "type" => $cd->type,
                    "typename" => $typename,
                ];
                /***/
                $result[count($result)] = $td;
                /***/
            }
        }

        return $result;
    }

    public function awards_data_info(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_AWARDS()['driver'];
        $DBTBL = $this->DBTBL_AWARDS()['table'];

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ) ORDER BY created_at DESC LIMIT 1 ";
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

    public function awards_data_add(Request $request){

        $DBDRIVER = $this->DBTBL_AWARDS()['driver'];
        $DBTBL = $this->DBTBL_AWARDS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $name = trim($request->name);
        $details = trim($request->details);
        $type = trim($request->type);
        $points = trim($request->points);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);
        $type = SQL_VALUE_CHECK($type);
        $points = SQL_VALUE_CHECK($points);

        if($points != "" && !is_numeric($points)) {
            $points = "0";
        }

        $errn = 0;
        $errmsg = "";

        if(trim($name) == "") {
            $errn++;
            $errmsg = $errmsg . "Name required. ";
        }

        // CHECK EXIST
        $tn = 0;
        if(trim($name) != "") {
            $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(name))=TRIM(LOWER('" . $name . "')) ) LIMIT 1 ";
            $res = DB::connection($DBDRIVER)->select($qry);
            if($res) {
                foreach ($res as $cd) {
                    $tn++;
                }
            }
        }
        if($tn > 0) {
            $errn++;
            $errmsg = $errmsg . "Award already added. ";
        }


        if($errn <= 0) {
            // SAVE
            $qry = " INSERT INTO " . $DBTBL . " (name,details,type,points) VALUES ('" . $name . "','" . $details . "','" . $type . "','" . $points . "') ";
            $res = DB::connection($DBDRIVER)->insert($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Data added.";
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

    public function awards_data_update(Request $request){

        $DBDRIVER = $this->DBTBL_AWARDS()['driver'];
        $DBTBL = $this->DBTBL_AWARDS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $name = trim($request->name);
        $details = trim($request->details);
        $type = trim($request->type);
        $points = trim($request->points);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);
        $type = SQL_VALUE_CHECK($type);
        $points = SQL_VALUE_CHECK($points);

        if($points != "" && !is_numeric($points)) {
            $points = "0";
        }

        $errn = 0;
        $errmsg = "";

        if(trim($name) == "") {
            $errn++;
            $errmsg = $errmsg . "Name required. ";
        }

        // CHECK EXIST
        $tn = 0;
        if(trim($name) != "") {
            $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ) LIMIT 1 ";
            $res = DB::connection($DBDRIVER)->select($qry);
            if($res) {
                foreach ($res as $cd) {
                    $tn++;
                }
            }
        }
        if($tn <= 0) {
            $errn++;
            $errmsg = $errmsg . "Invalid selected data. ";
        }


        if($errn <= 0) {
            // SAVE
            $qry = " UPDATE " . $DBTBL . " SET name='" . $name . "',details='" . $details . "',points='" . $points . "',type='" . $type . "' WHERE TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ";
            $res = DB::connection($DBDRIVER)->update($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Data updated.";
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

    public function awards_data_delete(Request $request){

        $DBDRIVER = $this->DBTBL_AWARDS()['driver'];
        $DBTBL = $this->DBTBL_AWARDS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $errn = 0;
        $errmsg = "";

        if(trim($id) == "") {
            $errn++;
            $errmsg = $errmsg . "No data selected. ";
        }

        if($errn <= 0) {
            // SAVE
            $qry = " UPDATE " . $DBTBL . " SET active='0' WHERE active='1' AND ( TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ) ";
            $res = DB::connection($DBDRIVER)->delete($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Data removed.";
            }else{
                $res_code = -1;
                $res_msg = "Unable to remove.";
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

    public function awards_option_awards_type_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_AWARDS_TYPES()['driver'];
        $DBTBL = $this->DBTBL_AWARDS_TYPES()['table'];

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' ORDER BY name ASC ";
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

    /* AWARDS END ============ */
    


}
