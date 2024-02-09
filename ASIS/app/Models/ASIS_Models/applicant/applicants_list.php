<?php

namespace App\Models\ASIS_Models\applicant;

use App\Models\doc_status;
use App\Models\Hiring\tbl_positionType;
use App\Models\Hiring\tbljob_info;
use App\Models\status_codes;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\ratedAppcants_model;
use App\Models\Hiring\tbl_hiringavailable;
use App\Models\Hiring\tbl_shortlisted;
use App\Models\Hiring\tbleduc_req;

class applicants_list extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'applicants_list';
    protected $primaryKey = 'id';

    protected $fillable = [
        'jobref_no',
        'applicant_id',
        'applicant_status',
        'application_note',
        'approval_date',
        'approved_by',
        'active',
    ];

    public function get_profile()
    {
        return $this->hasOne(tblemployee::class,'user_id','applicant_id')->where('active', true);
    }
    public function get_status()
    {
        return $this->hasOne(status_codes::class,'id','applicant_status')->where('active', true);
    }

    public function get_applicant_rated()
    {
        return $this->hasMany(ratedAppcants_model::class, 'applicant_listID', 'id')->where('rated_by', auth()->user()->employee);
    }

    public function get_avilable_position()
    {
        return $this->hasOne(tbl_hiringavailable::class, 'ref_num', 'jobref_no')->where('active', 1);
    }

    public function get_job_info()
    {
        return $this->hasOne(tbljob_info::class, 'jobref_no', 'jobref_no')->where('active', 1);
    }

    public function get_attachments()
    {
        return $this->hasMany(applicants_attachments::class, 'applicant_id', 'applicant_id')->where('active', 1);
    }

    //GET THE STATUS CODE added by Carlz
    public function get_status_code()
    {
        return $this->hasOne(status_codes::class,'id','applicant_status')->where('active',true);
    }

    public function get_job_infos()
    {
        return $this->hasMany(tbljob_info::class, 'jobref_no', 'jobref_no')->where('active', 1);
    }

    public function get_job_educ_req()
    {
        return $this->hasOne(tbleduc_req::class,'job_info_no','jobref_no')->where('active',true);
    }

}
