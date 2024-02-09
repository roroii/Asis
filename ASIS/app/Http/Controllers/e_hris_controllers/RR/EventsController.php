<?php

namespace App\Http\Controllers\RR;

use App\Http\Controllers\Controller;
use App\Models\RR\Events;
use Illuminate\Http\Request;
Use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Session;


class EventsController extends Controller
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


    public function index(){
        return view('rr.events');
    }

    public function load(Request $request){
        $data = $request->all();
        $tres = [];
        $name = '';

        $awards = Events::get();

        foreach ($awards as $dt) {
            $name='<a href="" class="font-medium whitespace-nowrap">'. $dt->name .'</a>
                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">'. $dt->desc .'</div>';
            $td = [
                "id" => $dt->id,
                "name" => $name,
                "sdate" => Carbon::parse($dt->s_date)->format("F j, Y H:i A"),
                "edate" => Carbon::parse($dt->e_date)->format("F j, Y H:i A"),
            ];

            $tres[count($tres)] = $td;
        }
        echo json_encode($tres);
    }


    /* EVENTS START ============ */

    public function events_load_view(){
        return view('rr.events');
    }
    
    public function events_data_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_EVENTS()['driver'];
        $DBTBL = $this->DBTBL_EVENTS()['table'];

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' ORDER BY s_date ASC, name ASC ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $s_date = $cd->s_date;
                $s_date2 = "";
                if(trim($s_date) != "") {
                    $s_date2 = date("F j, Y", strtotime($s_date));
                }
                $e_date = $cd->e_date;
                $e_date2 = "";
                if(trim($e_date) != "") {
                    $e_date2 = date("F j, Y", strtotime($e_date));
                }
                /***/
                $td = [
                    "id" => $cd->id,
                    "name" => $cd->name,
                    "details" => $cd->details,
                    "s_date" => $cd->s_date,
                    "s_date2" => $s_date2,
                    "e_date" => $cd->e_date,
                    "e_date2" => $e_date2,
                ];
                /***/
                $result[count($result)] = $td;
                /***/
            }
        }

        return $result;
    }

    public function events_data_info(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_EVENTS()['driver'];
        $DBTBL = $this->DBTBL_EVENTS()['table'];

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ) ORDER BY created_at DESC LIMIT 1 ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $s_date = $cd->s_date;
                $s_date2 = "";
                if(trim($s_date) != "") {
                    $s_date2 = date("Y-m-d", strtotime($s_date));
                }
                $e_date = $cd->e_date;
                $e_date2 = "";
                if(trim($e_date) != "") {
                    $e_date2 = date("Y-m-d", strtotime($e_date));
                }
                /***/
                /***/
                $td = [
                    "id" => $cd->id,
                    "name" => $cd->name,
                    "details" => $cd->details,
                    "s_date" => $cd->s_date,
                    "s_date2" => $s_date2,
                    "e_date" => $cd->e_date,
                    "e_date2" => $e_date2,
                ];
                /***/
                $result[count($result)] = $td;
                /***/
            }
        }

        return $result;
    }

    public function events_data_add(Request $request){

        $DBDRIVER = $this->DBTBL_EVENTS()['driver'];
        $DBTBL = $this->DBTBL_EVENTS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $name = trim($request->name);
        $details = trim($request->details);
        $s_date = trim($request->s_date);
        $e_date = trim($request->e_date);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);
        $s_date = SQL_VALUE_CHECK($s_date);
        $e_date = SQL_VALUE_CHECK($e_date);

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
            $errmsg = $errmsg . "Event already added. ";
        }


        if($errn <= 0) {
            // SAVE
            $qry = " INSERT INTO " . $DBTBL . " (name,details,s_date,e_date) VALUES ('" . $name . "','" . $details . "','" . $s_date . "','" . $e_date . "') ";
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

    public function events_data_update(Request $request){

        $DBDRIVER = $this->DBTBL_EVENTS()['driver'];
        $DBTBL = $this->DBTBL_EVENTS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $name = trim($request->name);
        $details = trim($request->details);
        $s_date = trim($request->s_date);
        $e_date = trim($request->e_date);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);
        $s_date = SQL_VALUE_CHECK($s_date);
        $e_date = SQL_VALUE_CHECK($e_date);

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
            $qry = " UPDATE " . $DBTBL . " SET name='" . $name . "',details='" . $details . "',s_date='" . $s_date . "',e_date='" . $e_date . "' WHERE TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ";
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

    public function events_data_delete(Request $request){

        $DBDRIVER = $this->DBTBL_EVENTS()['driver'];
        $DBTBL = $this->DBTBL_EVENTS()['table'];


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

    /* EVENTS END ============ */
    


}
