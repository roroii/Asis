<?php

namespace App\Models\Hiring;

use App\Models\applicant\applicants;
use App\Models\applicant\applicants_address;
use App\Models\applicant\applicants_attachments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class tbl_hiringlist extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table = "tbl_hiringlist";
    protected $primaryKey = "id";
    protected $fillable = [
        'hiring_ref_num',
        'applicant_id',
        'hiring_status',
        'active',
    ];

    public function get_job_info()
    {
        return $this->hasMany(tbljob_info::class,'jobref_no','hiring_ref_num')->where('active', 1);
    }

    public function get_applicant_details()
    {
        return $this->hasOne(applicants::class,'applicant_id','applicant_id');
    }
    public function get_applicants()
    {
        return $this->hasMany(applicants::class,'applicant_id','applicant_id');
    }

    public function get_attachments()
    {
        return $this->hasOne(applicants_attachments::class,'applicant_id','applicant_id');
    }

    public function get_profile_pic()
    {
        return $this->hasOne(applicants_attachments::class,'applicant_id','applicant_id')->where('attachment_type', 'PROFILE_PICTURE');
    }

    public function get_applicant_address()
    {
        return $this->hasOne(applicants_address::class,'applicant_id','applicant_id')->where('active', true);
    }
}
