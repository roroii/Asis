<?php

namespace App\Http\Controllers\OneLogin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;


class OneLoginController extends Controller
{
    //

    public function get_settings() {

        $logintoken = session()->get('onelogin_login_token');
        if($logintoken == null) {
            $logintoken = '';
        }

        $result = [
            "server_page" => "https://account.dssc.edu.ph",
            "server_page_login" => "https://account.dssc.edu.ph/login",
            "server_login_check" => "https://account.dssc.edu.ph/client/logincheck2",
            "server_logout" => "https://account.dssc.edu.ph/client/logout",
            "page_home" => "http://192.168.10.205:80/login",
            "page_login_save" => "onelogin/login/save",
            "api_key" => "QRDTS1234ggICT",
            "page_default" => "home",
            "logintoken" => $logintoken,
            "logintype" => "101",
        ];

        return $result;

    }

    public function post_login_check(Request $req) {

        $token = $req->token;
        session()->put('onelogin_login_token',$token);

        $src = trim($req->src);
        $dst = trim($req->dst);

        if(trim($dst) == "") {
            $dst = $src;
        }

        if(trim($dst) == "") {
            $settings = $this->get_settings();
            $dst = $settings['page_default'];
        }

        return redirect($dst);

    }

    public function save_login(Request $req) {

        $result = [];

        $res_code = -1;
        $res_msg = "Error.";

        //$data = json_decode($req->data);
        $data = ($req->data);

        $type = trim($req->type);
        if(trim($type) == "") {
            $settings = $this->get_settings();
            if($settings != null) {
                if(array_key_exists('logintype',$settings)) {
                    $type = trim($settings['logintype']);
                }
            }
        }
        if(trim($type) == "" || !is_numeric($type)) {
            $type = 0;
        }

        /*
            TYPE:
                <= 0 : BASIC
                == 101 : WITH LARAVEL DEFAULT AUTH
        */

        //echo json_encode($data);

        if($data != null) {
            if(array_key_exists('token',$data)) {
                if(trim($data['token']) != "") {

                    session()->put('accountdata',$data);

                    $terr = 0;

                    if($type == 101) {
                        if($data != null) {
                            if(array_key_exists('uid',$data)) {
                                $uid = trim($data['uid']);
                                Auth::loginUsingId($uid);
                                $tuser = Auth::user();
                                if($tuser == null) {
                                    $terr++;
                                }
                            }
                        }
                    }

                    if($terr <= 0) {
                        $res_code = 1;
                        $res_msg = 'Success.';
                    }


                }else{
                    session()->forget('accountdata');
                }
            }else{
                session()->forget('accountdata');
            }
        }else{
            session()->forget('accountdata');
        }

        $result = [
            "code" => $res_code,
            "message" => $res_msg,
        ];

        return json_encode($result);

    }

    public function logout(Request $req) {

        $settings = $this->get_settings();

        $src = trim($req->src);
        $dst = trim($req->dst);
        if(trim($dst) == "") {
            $dst = $src;
        }

        if(trim($src) == "") {
            $src = $settings['page_home'];
        }
        if(trim($dst) == "") {
            $dst = $settings['page_home'];
        }

        $type = trim($req->type);
        if(trim($type) == "") {
            if($settings != null) {
                if(array_key_exists('logintype',$settings)) {
                    $type = trim($settings['logintype']);
                }
            }
        }
        if(trim($type) == "" || !is_numeric($type)) {
            $type = 0;
        }


        $token = session()->get('onelogin_login_token');

        $sto = $settings['server_logout'] . '?' . 'api=' . $settings['api_key'] . '&token=' . $token . '&src=' . $src . '&dst=' . $dst;



        session()->forget('onelogin_login_token');
        session()->forget('accountdata');

        if($type == 101) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }


        return redirect($sto);

    }

}
