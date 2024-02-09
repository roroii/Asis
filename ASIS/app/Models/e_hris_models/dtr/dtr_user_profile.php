<?php

namespace App\Models\dtr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use App\Models\User;

use Illuminate\Support\Facades\DB;

use Auth;

class dtr_user_profile extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'profile';
    protected $primaryKey = 'id';

    protected $fillable = [
        'employee_id',
        'user_id',
        'agencyid',
        'bioid',
        'lastname',
        'firstname',
        'mi',
        'extension',
        'active',
    ];

    public function GetUserBioID($user) {
        $result = "";
        /***/
        $w = [
            'active' => 1,
            'agencyid' => $user,
        ];
        /***/
        $res = self::GetUserDataByUser($user);
        if($res != null) {
            if(!empty($res)) {
                $result = $res['bioid'];
            }
        }
        /***/
        return $result;
    }

    public function GetUserAgencyIDByBioID($bioid) {
        $result = "";
        /***/
        $w = [
            'active' => 1,
            'bioid' => $bioid,
        ];
        /***/
        $res = self::GetUserDataByBioID($bioid);
        if($res != null) {
            if(!empty($res)) {
                $result = $res['agencyid'];
            }
        }
        /***/
        return $result;
    }
    
    public function GetUserDataByUser($user) {
        $result = [];
        /***/
        $w = [
            'active' => 1,
            'agencyid' => $user,
        ];
        /***/
        $res = self::where($w)->get();
        if($res != null) {
            if(!empty($res)) {
                if(count($res) > 0) {
                    foreach ($res as $cd) {
                        $result = $cd;
                    }
                }
            }
        }
        /***/
        return $result;
    }

    public function GetUserDataByBioID($bioid) {
        $result = [];
        /***/
        $w = [
            'active' => 1,
            'bioid' => $bioid,
        ];
        /***/
        $res = self::where($w)->get();
        if($res != null) {
            if(!empty($res)) {
                if(count($res) > 0) {
                    foreach ($res as $cd) {
                        $result = $cd;
                    }
                }
            }
        }
        /***/
        return $result;
    }
    

}
