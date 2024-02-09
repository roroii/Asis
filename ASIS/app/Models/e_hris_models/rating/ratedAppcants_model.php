<?php

namespace App\Models\rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hiring\tbl_position;
use App\Models\agency\agency_employees;
use App\Models\Hiring\tbljob_info;
use App\Models\Hiring\tblpanels;
use App\Models\applicant\applicants_list;
use App\Models\rating\ratedDone_model;
use App\Models\tblemployee;
use App\Models\User;

class ratedAppcants_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'tbl_rated_applicants';
    protected $primaryKey = 'id';

    protected $fillable = [
        'applicantID',
        'positionID',
        'position_type',
        'rate',
        'average',
        'applicant_job_ref',
        'remarks',
        'rater_agency_id',
        'rated_by',
        'active',
    ];

    public function get_applicant()
    {
        return $this->hasMany(applicants_list::class, 'applicant_id', 'applicantID');
    }
    public function get_applicant_profile()
    {
        return $this->hasOne(tblemployee::class, 'user_id', 'applicantID');
    }
    public function get_rater_profile()
    {
        return $this->hasOne(User::class, 'id', 'rated_by');
    }
    public function get_position()
    {
        return $this->hasMany(tbl_position::class, 'id', 'positionID');
    }

    public function get_positionee()
    {
        return $this->hasOne(tbl_position::class, 'id', 'positionID');
    }

    public function get_jof_info()
    {
        return $this->hasOne(tbljob_info::class, 'jobref_no', 'applicant_job_ref');
    }

    public function get_ratedcriteria()
    {
        return $this->hasMany(ratedCriteria_model::class, 'applicant_id', 'applicantID');
    }


    public function get_criteria()
    {
        return $this->hasMany(ratingtCriteria_model::class, 'id', 'criteriaID');
    }
    public function get_panels()
    {
        return $this->hasMany(tblpanels::class, 'available_ref', 'applicant_job_ref');
    }
    public function get_rated_done()
    {
        return $this->hasMany(ratedDone_model::class, 'shortList_id', 'applicant_listID');
    }

    public function get_rater_prof()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'rater_agency_id');
    }
    public function get_rater_position()
    {
        return $this->hasOne(agency_employees::class, 'agency_id', 'rater_agency_id');
    }




}
