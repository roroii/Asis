<?php

namespace App\Models\Hiring;

use App\Models\Hiring\tbl_position;
use App\Models\Hiring\tbl_positionType;
use App\Models\Hiring\tbleduc_req;
use App\Models\Hiring\tbljob_doc_rec;
use App\Models\Hiring\tblpanels;
use App\Models\Leave\agency_employees;
use App\Models\rating\ratedDone_model;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class tbljob_info extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table = "tbljob_info";
    protected $primarykey = "id";
    protected $timestamp = true;

    protected $fillable = [
        'id','jobref_no','assign_agency','pos_title','sg','step','salary','pos_type','post_date','close_date','email_through','email_add',
        'address','active','status','created_at','updated_at'
    ];

    public function getJob_doc()
    {
        return $this->hasMany(tbleduc_req::class,'job_info_no','jobref_no')->where('active','1');
    }

    public function getDoc_rec()
    {
        return $this->hasMany(tbljob_doc_rec::class,'job_ref','jobref_no')->where('active','1');
    }

    public function getPos()
    {
        return $this->hasMany(tbl_position::class,'id','pos_title');
    }

    public function getPos_applicants()
    {
        return $this->hasOne(tbl_position::class,'id','pos_title');
    }

    public function getPos_type()
    {
        return $this->hasMany(tbl_positionType::class,'id','pos_type');
    }

    public function getPanels()
    {
        return $this->hasMany(tblpanels::class,'available_ref','jobref_no');
    }

    public function getPanelist()
    {
        return $this->hasOne(tblpanels::class,'available_ref','jobref_no')
        ->where('active', 1)->where('panel_id', auth()->user()->employee);
    }

    // public function get_Positions()
    // {
    //     return $this->hasOne(tbl_position::class,'id','pos_title');
    // }


    //BEGIN:: Added by MONTZ
    public function get_profile()
    {
        return $this->hasOne(tblemployee::class,'agencyid','email_through');
    }

    public function get_hr_profile()
    {
        return $this->hasOne(tblemployee::class,'user_id','email_through');
    }


    public function get_Position()
    {
        return $this->hasOne(tbl_position::class,'id','pos_title');
    }

    public function get_remarks()
    {
        return $this->hasOne(tbljob_doc_rec::class,'job_ref','jobref_no')->where('active','1');
    }

    public function get_educ_requirements()
    {
        return $this->hasOne(tbleduc_req::class,'job_info_no','jobref_no')->where('active','1');
    }

    public function get_SG()
    {
        return $this->hasOne(tbl_salarygrade::class,'id','sg')->where('active','1');
    }
    public function get_position_type()
    {
        return $this->hasOne(tbl_positionType::class,'id','pos_type');
    }

    public function get_job_doc_requirements()
    {
        return $this->hasMany(tbl_job_doc_requirements::class,'job_info_no','jobref_no')->where('active','1');
    }

    public function get_agency_employees()
    {
        return $this->hasOne(agency_employees::class, 'agency_id', 'email_through');
    }

    //END:: Added by MONTZ

    public function get_rated_done()
    {
        return $this->hasOne(ratedDone_model::class, 'applicant_job_ref', 'jobref_no');
    }
}
