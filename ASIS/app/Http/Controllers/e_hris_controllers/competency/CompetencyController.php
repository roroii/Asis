<?php

namespace App\Http\Controllers\competency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rr\Rewards;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Session;
use Auth;
use PDF;


class CompetencyController extends Controller
{

    /*  ============ */

    public function DB_SCHEMA() {
        return "primehrmo.";
    }

    public function DBTBL_SKILLS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "competency_skills",
        ];
        return $result;
    }

    public function DBTBL_GROUPS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "competency_groups",
        ];
        return $result;
    }

    public function DBTBL_DICTIONARY() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "competency_dictionary",
        ];
        return $result;
    }

    public function DBTBL_DICTIONARY_SKILLS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "competency_dictionary_skills",
        ];
        return $result;
    }

    public function DBTBL_DICTIONARY_REQS() {
        $result = [
            "driver" => "e-hris",
            "table" => $this->DB_SCHEMA() . "competency_dictionary_reqs",
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

    public function get_competency_skills($competency) {
        $result = [];
        /***/
        $DBDRIVER = $this->DBTBL_DICTIONARY_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_SKILLS()['table'];
        $DBTBL2 = $this->DBTBL_SKILLS()['table'];

        $competency = SQL_VALUE_CHECK($competency);

        $tn = 0;
        $qry = " SELECT dict.id,dict.compid,dict.skill,dict.points,skill.skill AS name,skill.details,skill.default_points FROM " . $DBTBL . " AS dict LEFT JOIN " . $DBTBL2 . " AS skill ON skill.skillid=dict.skill WHERE dict.active='1' AND ( TRIM(LOWER(dict.compid))=TRIM(LOWER('" . $competency . "')) ) ORDER BY skill.skill ASC ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $result[count($result)] = $cd;
                /***/
            }
        }
        /***/
        return $result;
    }

    public function get_competency_reqs($competency) {
        $result = [];
        /***/
        $DBDRIVER = $this->DBTBL_DICTIONARY_REQS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_REQS()['table'];
        $DBTBL2 = $this->DBTBL_DICTIONARY()['table'];

        $competency = SQL_VALUE_CHECK($competency);

        $tn = 0;
        $qry = " SELECT req.id,req.compid,dict.name,dict.details,dict.points,dict.level,dict.grp FROM " . $DBTBL . " AS req LEFT JOIN " . $DBTBL2 . " AS dict ON dict.id=req.reqid WHERE req.active='1' AND ( TRIM(LOWER(req.compid))=TRIM(LOWER('" . $competency . "')) ) ORDER BY dict.name ASC ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $result[count($result)] = $cd;
                /***/
            }
        }
        /***/
        return $result;
    }

    /* COMMON DATA END ============ */


    /* OVERVIEW START ============ */

    public function load_view(){
        $userdata = Auth::user();
        if($userdata != null) {
            return view('competency.competency');
        }else{
            return redirect(url(''));
        }
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
    
    /* SKILLS START ============ */

    public function skills_load_view(){

        $userdata = Auth::user();
        if($userdata != null) {
            return view('competency.skills');
        }else{
            return redirect(url(''));
        }

    }
    
    public function skills_data_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_SKILLS()['table'];

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' ORDER BY skill ASC ";
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

    public function skills_data_info(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_SKILLS()['table'];

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(skillid))=TRIM(LOWER('" . $id . "')) ) ORDER BY created_at DESC LIMIT 1 ";
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

    public function skills_data_add(Request $request){

        $DBDRIVER = $this->DBTBL_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_SKILLS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $name = trim($request->name);
        $details = trim($request->details);
        $points = trim($request->points);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);
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
            $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(skill))=TRIM(LOWER('" . $name . "')) ) LIMIT 1 ";
            $res = DB::connection($DBDRIVER)->select($qry);
            if($res) {
                foreach ($res as $cd) {
                    $tn++;
                }
            }
        }
        if($tn > 0) {
            $errn++;
            $errmsg = $errmsg . "Skill already added. ";
        }


        if($errn <= 0) {
            // SAVE
            $qry = " INSERT INTO " . $DBTBL . " (skill,details,default_points) VALUES ('" . $name . "','" . $details . "','" . $points . "') ";
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

    public function skills_data_update(Request $request){

        $DBDRIVER = $this->DBTBL_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_SKILLS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $name = trim($request->name);
        $details = trim($request->details);
        $points = trim($request->points);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);
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
            $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(skillid))=TRIM(LOWER('" . $id . "')) ) LIMIT 1 ";
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
            $qry = " UPDATE " . $DBTBL . " SET skill='" . $name . "',details='" . $details . "',default_points='" . $points . "' WHERE TRIM(LOWER(skillid))=TRIM(LOWER('" . $id . "')) ";
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

    public function skills_data_delete(Request $request){

        $DBDRIVER = $this->DBTBL_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_SKILLS()['table'];


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
            $qry = " UPDATE " . $DBTBL . " SET active='0' WHERE active='1' AND ( TRIM(LOWER(skillid))=TRIM(LOWER('" . $id . "')) ) ";
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

    /* SKILLS END ============ */
    
    /* DICTIONARY START ============ */

    public function dictionary_load_view(){

        $userdata = Auth::user();
        if($userdata != null) {
            return view('competency.dictionary');
        }else{
            return redirect(url(''));
        }

    }
    
    public function dictionary_data_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_DICTIONARY()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY()['table'];

        $tn = 0;
        $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' ORDER BY name ASC ";
        $data = DB::connection($DBDRIVER)->select($qry);
        if($data) {
            foreach ($data as $cd) {
                $tn++;
                /***/
                $grp = $cd->grp;
                $grp_name = "";
                $grp_data = $this->get_competency_group_info($grp);
                if($grp_data != null && !empty($grp_data)) {
                    $grp_name = $grp_data->name;
                }
                /***/
                $skills = 0;
                $skill_list = $this->get_competency_skills($cd->id);
                if($skill_list != null && !empty($skill_list)) {
                    $skills = count($skill_list);
                }
                /***/
                $reqs = 0;
                $req_list = $this->get_competency_reqs($cd->id);
                if($req_list != null && !empty($req_list)) {
                    $reqs = count($req_list);
                }
                /***/
                $td = [
                    "id" => $cd->id,
                    "name" => $cd->name,
                    "details" => $cd->details,
                    "points" => $cd->points,
                    "level" => $cd->level,
                    "grp" => $cd->grp,
                    "grp_name" => $grp_name,
                    "skills" => $skills,
                    "requirements" => $reqs,
                ];
                /***/
                //$result[count($result)] = $cd;
                $result[count($result)] = $td;
                /***/
            }
        }

        return $result;
    }

    public function dictionary_data_info(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_DICTIONARY()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY()['table'];

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

    public function dictionary_data_add(Request $request){

        $DBDRIVER = $this->DBTBL_DICTIONARY()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $name = trim($request->name);
        $details = trim($request->details);
        $points = trim($request->points);
        $level = trim($request->level);
        $group = trim($request->group);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);
        $points = SQL_VALUE_CHECK($points);
        $level = SQL_VALUE_CHECK($level);
        $group = SQL_VALUE_CHECK($group);

        if($points != "" && !is_numeric($points)) {
            $points = "0";
        }
        if($level != "" && !is_numeric($level)) {
            $level = "0";
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
            $errmsg = $errmsg . "Competency already added. ";
        }


        if($errn <= 0) {
            // SAVE
            $qry = " INSERT INTO " . $DBTBL . " (name,details,points,level,grp) VALUES ('" . $name . "','" . $details . "','" . $points . "','" . $level . "','" . $group . "') ";
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

    public function dictionary_data_update(Request $request){

        $DBDRIVER = $this->DBTBL_DICTIONARY()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY()['table'];
        

        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $name = trim($request->name);
        $details = trim($request->details);
        $points = trim($request->points);
        $level = trim($request->level);
        $group = trim($request->group);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);
        $points = SQL_VALUE_CHECK($points);
        $level = SQL_VALUE_CHECK($level);
        $group = SQL_VALUE_CHECK($group);

        if($points != "" && !is_numeric($points)) {
            $points = "0";
        }
        if($level != "" && !is_numeric($level)) {
            $level = "0";
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
            $qry = " UPDATE " . $DBTBL . " SET name='" . $name . "',details='" . $details . "',points='" . $points . "',level='" . $level . "',grp='" . $group . "' WHERE TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ";
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

    public function dictionary_data_delete(Request $request){

        $DBDRIVER = $this->DBTBL_DICTIONARY()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY()['table'];


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

    public function dictionary_option_groups_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_GROUPS()['driver'];
        $DBTBL = $this->DBTBL_GROUPS()['table'];

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

    public function dictionary_skills_data_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_DICTIONARY_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_SKILLS()['table'];
        $DBTBL2 = $this->DBTBL_SKILLS()['table'];

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        if(trim($id) != "") {

            $tn = 0;
            $qry = " SELECT dict.id,dict.compid,dict.skill,dict.points,dict.active,skill.skillid,skill.skill AS skillname,skill.details 
                     FROM " . $DBTBL . " AS dict 
                     LEFT JOIN " . $DBTBL2 . " AS skill ON skill.skillid=dict.skill 
                     WHERE dict.active='1' AND TRIM(LOWER(dict.compid))=TRIM(LOWER('" . $id . "')) 
                     ORDER BY skill.skill ASC ";
            $data = DB::connection($DBDRIVER)->select($qry);
            if($data) {
                foreach ($data as $cd) {
                    $tn++;
                    /***/
                    /***/
                    /***/
                    $td = [
                        "id" => $cd->id,
                        "skillid" => $cd->skillid,
                        "name" => $cd->skillname,
                        "details" => $cd->details,
                        "points" => $cd->points,
                        "active" => $cd->active,
                    ];
                    /***/
                    $result[count($result)] = $td;
                    /***/
                }
            }

        }

        return $result;
    }

    public function dictionary_skills_data_add(Request $request){

        $DBDRIVER = $this->DBTBL_DICTIONARY_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_SKILLS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $dict_id = trim($request->dict_id);
        $skill = trim($request->skill);

        $dict_id = SQL_VALUE_CHECK($dict_id);
        $skill = SQL_VALUE_CHECK($skill);


        $errn = 0;
        $errmsg = "";

        if(trim($dict_id) == "") {
            $errn++;
            $errmsg = $errmsg . "Competency required. ";
        }
        if(trim($skill) == "") {
            $errn++;
            $errmsg = $errmsg . "Skill required. ";
        }

        // CHECK EXIST
        $tn = 0;
        if(trim($skill) != "") {
            $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(compid))=TRIM(LOWER('" . $dict_id . "')) AND TRIM(LOWER(skill))=TRIM(LOWER('" . $skill . "')) ) LIMIT 1 ";
            $res = DB::connection($DBDRIVER)->select($qry);
            if($res) {
                foreach ($res as $cd) {
                    $tn++;
                }
            }
        }
        if($tn > 0) {
            $errn++;
            $errmsg = $errmsg . "Skill already added. ";
        }


        if($errn <= 0) {
            // SAVE
            $qry = " INSERT INTO " . $DBTBL . " (compid,skill) VALUES ('" . $dict_id . "','" . $skill . "') ";
            $res = DB::connection($DBDRIVER)->insert($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Skill added.";
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

    public function dictionary_skills_data_update(Request $request){

        $DBDRIVER = $this->DBTBL_DICTIONARY_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_SKILLS()['table'];
        

        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $points = trim($request->points);
        $points = SQL_VALUE_CHECK($points);

        if($points != "" && !is_numeric($points)) {
            $points = "0";
        }

        $errn = 0;
        $errmsg = "";


        if($errn <= 0) {
            // SAVE
            $qry = " UPDATE " . $DBTBL . " SET points='" . $points . "'  WHERE TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ";
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

    public function dictionary_skills_data_delete(Request $request){

        $DBDRIVER = $this->DBTBL_DICTIONARY_SKILLS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_SKILLS()['table'];
        

        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $errn = 0;
        $errmsg = "";


        if($errn <= 0) {
            // SAVE
            $qry = " UPDATE " . $DBTBL . " SET active='0'  WHERE TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ";
            $res = DB::connection($DBDRIVER)->update($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Data removed.";
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

    public function dictionary_reqs_data_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_DICTIONARY_REQS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_REQS()['table'];
        $DBTBL2 = $this->DBTBL_DICTIONARY()['table'];

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        if(trim($id) != "") {

            $tn = 0;
            $qry = " SELECT req.id,req.compid,req.reqid,req.active,dict.name,dict.details,dict.points,dict.level,dict.grp 
                     FROM " . $DBTBL . " AS req 
                     LEFT JOIN " . $DBTBL2 . " AS dict ON dict.id=req.reqid 
                     WHERE req.active='1' AND TRIM(LOWER(req.compid))=TRIM(LOWER('" . $id . "')) 
                     ORDER BY dict.name ASC ";
            $data = DB::connection($DBDRIVER)->select($qry);
            if($data) {
                foreach ($data as $cd) {
                    $tn++;
                    /***/
                    /***/
                    $td = [
                        "id" => $cd->id,
                        "compid" => $cd->compid,
                        "reqid" => $cd->reqid,
                        "name" => $cd->name,
                        "details" => $cd->details,
                        "points" => $cd->points,
                        "level" => $cd->level,
                        "grp" => $cd->grp,
                        "active" => $cd->active,
                    ];
                    /***/
                    $result[count($result)] = $td;
                    /***/
                }
            }

        }

        return $result;
    }

    public function dictionary_reqs_data_add(Request $request){

        $DBDRIVER = $this->DBTBL_DICTIONARY_REQS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_REQS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $compid = trim($request->compid);
        $reqid = trim($request->reqid);

        $compid = SQL_VALUE_CHECK($compid);
        $reqid = SQL_VALUE_CHECK($reqid);


        $errn = 0;
        $errmsg = "";

        if(trim($compid) == "") {
            $errn++;
            $errmsg = $errmsg . "Competency required. ";
        }
        if(trim($reqid) == "") {
            $errn++;
            $errmsg = $errmsg . "Requirement required. ";
        }

        // CHECK EXIST
        $tn = 0;
        if(trim($reqid) != "") {
            $qry = " SELECT * FROM " . $DBTBL . " WHERE active='1' AND ( TRIM(LOWER(compid))=TRIM(LOWER('" . $compid . "')) AND TRIM(LOWER(reqid))=TRIM(LOWER('" . $reqid . "')) ) LIMIT 1 ";
            $res = DB::connection($DBDRIVER)->select($qry);
            if($res) {
                foreach ($res as $cd) {
                    $tn++;
                }
            }
        }
        if($tn > 0) {
            $errn++;
            $errmsg = $errmsg . "Requirement already added. ";
        }


        if($errn <= 0) {
            // SAVE
            $qry = " INSERT INTO " . $DBTBL . " (compid,reqid) VALUES ('" . $compid . "','" . $reqid . "') ";
            $res = DB::connection($DBDRIVER)->insert($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Requirement added.";
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

    public function dictionary_reqs_data_delete(Request $request){

        $DBDRIVER = $this->DBTBL_DICTIONARY_REQS()['driver'];
        $DBTBL = $this->DBTBL_DICTIONARY_REQS()['table'];
        
        
        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $errn = 0;
        $errmsg = "";


        if($errn <= 0) {
            // SAVE
            $qry = " UPDATE " . $DBTBL . " SET active='0'  WHERE TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ";
            $res = DB::connection($DBDRIVER)->update($qry);
            if($res) {
                $res_code = 1;
                $res_msg = "Data removed.";
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

    /* DICTIONARY END ============ */
    
    /* GROUPS START ============ */

    public function groups_load_view(){
        $userdata = Auth::user();
        if($userdata != null) {
            return view('competency.groups');
        }else{
            return redirect(url(''));
        }
    }
    
    public function groups_data_get(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_GROUPS()['driver'];
        $DBTBL = $this->DBTBL_GROUPS()['table'];

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

    public function groups_data_info(Request $request){
        $result = [];

        $DBDRIVER = $this->DBTBL_GROUPS()['driver'];
        $DBTBL = $this->DBTBL_GROUPS()['table'];

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

    public function groups_data_add(Request $request){

        $DBDRIVER = $this->DBTBL_GROUPS()['driver'];
        $DBTBL = $this->DBTBL_GROUPS()['table'];


        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $name = trim($request->name);
        $details = trim($request->details);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);

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
            $errmsg = $errmsg . "Group already added. ";
        }


        if($errn <= 0) {
            // SAVE
            $qry = " INSERT INTO " . $DBTBL . " (name,details) VALUES ('" . $name . "','" . $details . "') ";
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

    public function groups_data_update(Request $request){

        $DBDRIVER = $this->DBTBL_GROUPS()['driver'];
        $DBTBL = $this->DBTBL_GROUPS()['table'];
        

        $result = [];

        $res_code = -1;
        $res_msg = "Unable to process.";

        $id = trim($request->id);
        $id = SQL_VALUE_CHECK($id);

        $name = trim($request->name);
        $details = trim($request->details);

        $name = SQL_VALUE_CHECK($name);
        $details = SQL_VALUE_CHECK($details);

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
            $qry = " UPDATE " . $DBTBL . " SET name='" . $name . "',details='" . $details . "' WHERE TRIM(LOWER(id))=TRIM(LOWER('" . $id . "')) ";
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

    public function groups_data_delete(Request $request){

        $DBDRIVER = $this->DBTBL_GROUPS()['driver'];
        $DBTBL = $this->DBTBL_GROUPS()['table'];


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

    /* GROUPS END ============ */
    
}
