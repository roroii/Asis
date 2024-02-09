<?php

namespace App\Models\ASIS_Models\OnlineRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\posgres\enrollment\srgb\semstudent;
use App\Models\ASIS_Models\OnlineRequest\offices;
use App\Models\ASIS_Models\OnlineRequest\student_request;

class admin_User extends Model
{
   use HasFactory;

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
        'office_id',
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

    public function getDocumentRequest()
    {
        return $this->hasOne(student_request::class, 'office', 'office_id')->where('active', 1);
    }

    public function get_office_role(){

        return $this->hasOne(offices::class, 'id', 'office_id');

    }


}
