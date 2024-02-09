<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use App\Models\User;

use Auth;

class user_roles extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'admin_user_roles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'agencyid',
        'roleid',
        'rolecode',
        'level',
        'active',
    ];


    public function getUserRoleByID($user,$roleid) {
        $w = [
            'active' => 1,
            'agencyid' => $user,
            'roleid' => $roleid,
        ];
        /***/
        $result = user_roles::where($w)->get();
        /***/
        return $result;
    }

    public function getUserRoleByCode($user,$rolecode) {
        $w = [
            'active' => 1,
            'agencyid' => $user,
            'rolecode' => $rolecode,
        ];
        /***/
        $limit = 1;
        /***/
        $result = user_roles::where($w)->limit($limit)->get();
        /***/
        return $result;
    }

    public function getUserRoleInUsers($user) {
        $w = [
            'active' => 1,
            'employee' => $user,
        ];
        /***/
        $cols = ['id','employee','role_name','level'];
        /***/
        $limit = 1;
        /***/
        $result = User::select($cols)->where($w)->limit($limit)->get();
        /***/
        return $result;
    }
    
    public function isUserAdmin($user) {
        /***/
        $result = 0;
        /***/
        /***/
        $admin_code = "admin";
        /***/
        /***/
        $an = 0;
        /***/
        /* CHECK USER ROLE IN USERS */
        $users = self::getUserRoleInUsers($user);
        foreach($users as $cd) {
            $tv = $cd->role_name;
            if(trim(strtolower($tv)) == trim(strtolower($admin_code))) {
                $an++;
                break;
            }
        }
        /***/
        /* CHECK USER ROLE IN USER ROLES */
        $userroles = self::getUserRoleByCode($user, $admin_code);
        foreach($userroles as $cd) {
            $an++;
            break;
        }
        /***/
        if($an > 0) {
            $result = 1;
        }else{
            $result = 0;
        }
        /***/
        return $result;
    }

    public function isCurrentUserAdmin() {
        $user = Auth::user()->employee;
        $result = self::isUserAdmin($user);
        /***/
        return $result;
    }
    
}
