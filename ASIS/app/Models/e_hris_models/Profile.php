<?php

namespace App\Models\e_hris_models;

use App\Models\e_hris_models\agency\agency_employees;
use App\Models\e_hris_models\PDS\pds_address;
use App\Models\e_hris_models\PDS\pds_educational_bg;
use App\Models\e_hris_models\PDS\pds_family_bg;
use App\Models\e_hris_models\tbl\tbl_responsibilitycenter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'profile';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'agencyid', 'bioid', 'lastname', 'firstname', 'mi', 'extension', 'dateofbirth'
        , 'civilstatus', 'religion', 'spouse', 'govissueid', 'contact', 'address'
        , 'citizenship', 'dual_citizenship_type', 'dual_citizenship_country', 'tribe', 'entrydate', 'sex', 'placeofbirth', 'height'
        , 'weight', 'bloodtype', 'gsis', 'pagibig', 'philhealth', 'sss', 'tin'
        , 'civilserviceid', 'telephone', 'mobile_number', 'mobile', 'email', 'image','employee_id'
        ,'created_by', 'e_signature',

    ];

    public function getOffice()
    {
        return $this->hasOne(tbl_responsibilitycenter::class, 'head', 'agencyid')->where('active', 1);
    }

    public function getHRdetails()
    {
        return $this->hasOne(agency_employees::class, 'agency_id', 'agencyid')->where('active', 1);
    }

    public function getUsername()
    {
        return $this->hasOne(User::class, 'employee', 'agencyid')->where('active', 1);
    }

    public function res_address()
    {
        return $this->hasOne(pds_address::class, 'employee_id', 'agencyid')->where('address_type', 'RESIDENTIAL')->where('active', 1);
    }

    public function per_address()
    {
        return $this->hasOne(pds_address::class, 'employee_id', 'agencyid')->where('address_type', 'PERMANENT')->where('active', 1);
    }

    public function family_bg()
    {
        return $this->hasOne(pds_family_bg::class, 'employee_id', 'agencyid')->where('active', 1);
    }

    public function educ_bg()
    {
        return $this->hasOne(pds_educational_bg::class, 'employee_id', 'agencyid')->where('active', 1);
    }

    //added by calrz
    public function get_employee_profile_pos(){
        return $this->hasOne(agency_employees::class, 'agency_id', 'agencyid')->where('active',1);
    }



}
