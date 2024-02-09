<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl\tblemployee;
use App\Models\Hiring\tbl_position;
use App\Models\Hiring\tbleduc_req;
use App\Models\Hiring\tbljob_info;
use App\Models\rating\ratedAppcants_model;
use App\Models\status_codes;


class tbl_shortlisted extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table = "tbl_shortlisted";
    protected $primarykey = "id";
    public $timestamp = true;

    protected $fillable = ['id','ref_num','exam_result','applicant_id','notes','date_applied','rate_sched','approved_by','stat','active','created_at','updated_at'];


    public function get_profile_infos()
    {
        return $this->hasOne(tblemployee::class,'user_id','applicant_id')->where('active',true);
    }

    public function get_job()
    {
        return $this->hasMany(tbljob_info::class,'jobref_no','ref_num')->where('active',true);
    }

    public function get_stat()
    {
        return $this->hasOne(status_codes::class,'id','stat')->where('active',true);
    }

    public function get_educ_requirements()
    {
        return $this->hasone(tbleduc_req::class,'job_info_no','ref_num')->where('active',true);
    }

    //amante relation
    public function get_applicant_rated()
    {
        return $this->hasOne(ratedAppcants_model::class, 'applicant_listID', 'id')->where('rated_by', auth()->user()->id);
    }

    public function get_profile()
    {
        return $this->hasOne(tblemployee::class,'user_id','applicant_id')->where('active', true);
    }
    public function get_job_info()
    {
        return $this->hasOne(tbljob_info::class, 'jobref_no', 'ref_num');
    }


}
