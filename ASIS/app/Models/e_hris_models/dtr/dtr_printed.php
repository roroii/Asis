<?php

namespace App\Models\dtr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use App\Models\User;

use Illuminate\Support\Facades\DB;

use Auth;

class dtr_printed extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'dtr_printed';
    protected $primaryKey = 'id';

    protected $fillable = [
        'agencyid',
        'datefrom',
        'dateto',
        'user',
        'active',
    ];

    public function AddDTRPrintedData($user,$datefrom,$dateto,$byuser) {
        /***/
        $result = false;
        /***/
        $data = [
            'agencyid' => $user,
            'datefrom' => $datefrom,
            'dateto' => $dateto,
            'user' => $byuser,
        ];
        /***/
        if(!self::DTRPrintedExist($user,$datefrom,$dateto)) {
            $result = self::create($data);
            $result = true;
        }
        /***/
        return $result;
    }

    public function DTRPrintedExist($user,$datefrom,$dateto) {
        $result = false;
        /***/
        $w = [
            'active' => 1,
            'agencyid' => $user,
            'datefrom' => $datefrom,
            'dateto' => $dateto,
        ];
        $res = self::where($w)->get();
        if($res != null) {
            if(!empty($res)) {
                if(count($res) > 0) {
                    $result = true;
                }
            }
        }
        /***/
        return $result;
    }

    public function GetDTRPrintedList() {
        $result = [];
        /***/
        $w = [
            'active' => 1,
        ];
        $res = self::where($w)->get();
        $result = $res;
        /***/
        return $result;
    }

    public function GetDTRPrintedListByDateRange($datefrom, $dateto) {
        $result = [];
        /***/
        $w = [
            'active' => 1,
        ];
        $res = self::where($w)
                    ->whereDate('datefrom', '>=', date('Y-m-d', strtotime($datefrom)))
                    ->whereDate('dateto', '<=', date('Y-m-d', strtotime($dateto)))
                    ->get();
        $result = $res;
        /***/
        return $result;
    }

    public function GetDTRPrintedInfoByID($id) {
        $result = [];
        /***/
        $w = [
            'active' => 1,
            'id' => $id,
        ];
        $res = self::where($w)->limit(1)->get();
        if($res != null) {
            if(!empty($res)) {
                if(count($res) > 0) {
                    $result = $res[0];
                }
            }
        }
        /***/
        return $result;
    }

    public function GetDTRPrintedUserList($datefrom = "", $dateto = "") {
        $result = [];
        /***/
        $w = [
            'dp.active' => 1,
        ];
        /***/
        /*
        $res = DB::table('dtr_printed AS dp')
                    ->select('dp.id','dp.agencyid','dp.datefrom','dp.dateto','prof.lastname','prof.firstname','prof.mi','prof.extension')
                    ->leftJoin('profile AS prof','prof.agencyid','=','dp.agencyid')
                    ->where($w)
                    ->orderBy('prof.lastname','ASC')
                    ->orderBy('prof.firstname','ASC')
                    ->get();
                    */
        /***/
        $qry = DB::table('dtr_printed AS dp')
                    ->select('dp.id','dp.agencyid','dp.datefrom','dp.dateto','prof.lastname','prof.firstname','prof.mi','prof.extension')
                    ->leftJoin('profile AS prof','prof.agencyid','=','dp.agencyid')
                    ->where($w);
        /***/
        if(trim($datefrom) != "") {
            $qry = $qry->whereDate('datefrom', '>=', date('Y-m-d', strtotime($datefrom)));
        }
        if(trim($dateto) != "") {
            $qry = $qry->whereDate('dateto', '<=', date('Y-m-d', strtotime($dateto)));
        }
        /***/
        $res = $qry->orderBy('prof.lastname','ASC')
                ->distinct()
                ->orderBy('prof.firstname','ASC')
                ->get();
        /***/
        $result = $res;
        /***/
        return $result;
    }

    public function GetDTRPrintedUserListInfoByID($id) {
        $result = [];
        /***/
        $w = [
            'dp.active' => 1,
            'dp.id' => $id,
        ];
        $res = DB::table('dtr_printed AS dp')
                    ->select('dp.id','dp.agencyid','dp.datefrom','dp.dateto','prof.lastname','prof.firstname','prof.mi','prof.extension')
                    ->leftJoin('profile AS prof','prof.agencyid','=','dp.agencyid')
                    ->where($w)
                    ->orderBy('prof.lastname','ASC')
                    ->orderBy('prof.firstname','ASC')
                    ->get();
        $result = $res;
        /***/
        return $result;
    }

    public function GetDTRPrintedUserRecordsList($id, $datefrom = "", $dateto = "") {
        $result = [];
        /***/
        $w = [
            'active' => 1,
            'agencyid' => $id,
        ];
        /***/
        /***/
        $qry = self::where($w);
        /***/
        if(trim($datefrom) != "") {
            $qry = $qry->whereDate('datefrom', '>=', date('Y-m-d', strtotime($datefrom)));
        }
        if(trim($dateto) != "") {
            $qry = $qry->whereDate('dateto', '<=', date('Y-m-d', strtotime($dateto)));
        }
        /***/
        $res = $qry->orderBy('created_at','DESC')
                ->get();
        /*
        $res = self::where($w)
                    ->orderBy('created_at','DESC')
                    ->get();
                    */
        $result = $res;
        /***/
        return $result;
    }


}
