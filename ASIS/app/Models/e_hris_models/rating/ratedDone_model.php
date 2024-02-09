<?php

namespace App\Models\rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tblemployee;
use App\Models\doc_status;
use App\Models\Hiring\tbljob_info;
use App\Models\Hiring\tbl_position;

class ratedDone_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'tbl_rated_done';
    protected $primaryKey = 'id';

    protected $fillable = [
        'applicant_id',
        'applicant_job_ref',
        'shortList_id',
        'approved_by',
        'position_id',
        'notified',
        'final_proceed_by',
        'pres_interview_date',
        'status',
        'remarks',
        'active',
    ];

    public function get_applicant_profile()
    {
        return $this->hasOne(tblemployee::class, 'user_id', 'applicant_id');
    }
    public function get_approve_officer()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'approved_by');
    }
    public function get_proceeding_officer()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'final_proceed_by');
    }
    public function get_selection_officer()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'selected_by');
    }
    public function get_position()
    {
        return $this->hasOne(tbl_position::class, 'id', 'position_id');
    }

    public function get_status()
    {
        return $this->hasOne(doc_status::class, 'id', 'status');
    }
    public function get_jof_info()
    {
        return $this->hasOne(tbljob_info::class, 'jobref_no', 'applicant_job_ref');
    }
}
