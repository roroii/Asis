<?php

namespace App\Models\dtr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use App\Models\User;

use App\Models\dtr\dtr_user_profile;

use Illuminate\Support\Facades\DB;

use Auth;

class dtr_attendance extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'dtr_attendance';
    protected $primaryKey = 'id';

    protected $fillable = [
        'agencyid',
        'bioid',
        'log_time',
        'workstate',
        'active',
    ];

    public function AddAttendanceData($user,$bioid,$logtime,$logtype) {
        /***/
        $result = false;
        /***/
        $data = [
            'agencyid' => $user,
            'bioid' => $bioid,
            'log_time' => $logtime,
            'workstate' => $logtype,
        ];
        /***/
        if(trim($user) == "") {
            $user = dtr_user_profile::GetUserAgencyIDByBioID($bioid);
        }
        /***/
        if(!self::AttendanceExist($user,$bioid,$logtime,$logtype)) {
            $result = self::create($data);
            $result = true;
        }
        /***/
        return $result;
    }
    
    public function AttendanceExist($user,$bioid,$logtime,$logtype) {
        $result = false;
        /***/
        $w = [
            'active' => 1,
            'agencyid' => $user,
            'log_time' => $logtime,
            'workstate' => $logtype,
        ];
        /***/
        $w2 = [
            'active' => 1,
            'bioid' => $bioid,
            'log_time' => $logtime,
            'workstate' => $logtype,
        ];
        /***/
        $res = self::where($w)->get();
        if($res != null) {
            if(!empty($res)) {
                if(count($res) > 0) {
                    $result = true;
                }
            }
        }
        if(!$result) {
            $res = self::where($w2)->get();
            if($res != null) {
                if(!empty($res)) {
                    if(count($res) > 0) {
                        $result = true;
                    }
                }
            }
        }
        /***/
        return $result;
    }


}
