<?php

namespace App\Models;

use App\Models\ASIS_Models\agency\agency_employees;
use App\Models\ASIS_Models\applicant\applicants_list;
use App\Models\ASIS_Models\HRIS_model\employee;
use Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, MustVerifyEmailTrait;

   protected $connection = 'e-hris';
   protected $table = 'admin_user';
   protected $primaryKey = 'id';


   protected $fillable = [
    'id',
    'profile_id',
    'employee_id',
    'employee',
    'firstname',
    'middlename',
    'lastname',
    'username',
    'password',
    'active_date',
    'expire_date',
    'role_name',
    'active',
    'email',
    'email_verified',
    'email_verified_at',
    'status',
    'groupss',
    'level',
    'activity',
    'psusys_inuserc',
    'dash_yr',
    'avatar',
    'updateline',
    'updateoptions',
    'login_email',
    'last_seen',
    'session_id',
    'token',
    'remember_token',
    'created_at',
    'updated_at',
    'created_by'
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



    public function getAgencyEmployee()
    {
        return $this->hasOne(agency_employees::class, 'agency_id', 'employee')->where('active', 1);
    }

}
