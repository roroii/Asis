<?php

namespace App\Models;

use App\Models\agency\agency_employees;
use App\Models\applicant\applicants_list;
use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $connection = 'e-hris';
    protected $table = 'admin_user';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee',
        'username',
        'firstname',
        'lastname',
        'middlename',
        'password',
        'active',
        'status',
        'groupss',
        'level',
        'activity',
        'duration',
        'startduration',
        'endduration',
        'entrydate',
        'role_name',
        'psusys_inuserc',
        'dash_yr',
        'avatar',
        'updateline',
        'updateoptions',
        'login_email',
        'session_id',
        'token',
        'last_seen',
        'profile_id',
        'employee_id',
        'active_date',
        'expire_date',
        'created_by',
        'email_verified_at',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserinfo()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'employee')->where('active', 1);
    }

    public function get_user_profile()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'employee')->where('active', 1);
    }

    public function get_HR_Details()
    {
        return $this->hasOne(employee_hr_details::class, 'employeeid', 'employee')->where('active', 1);
    }

    public function isOnline()
    {
        return Cache::has('is_online'.Auth::user()->id);
    }

    public function get_user_employment()
    {
        return $this->hasOne(agency_employees::class, 'agency_id', 'employee')->where('active', 1);
    }
    //pag buhat ug imohang function dli mang hilabot sa naa na dha kay mag error ang uban na mga na code na, salamat.

    public function get_is_at_applicant_list()
    {
        return $this->hasOne(applicants_list::class,'applicant_id','id')->where('active', 1);
    }
}
