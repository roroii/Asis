<?php
namespace App\Models\ASIS_Models\notification;

use App\Models\applicant\applicants;
use App\Models\applicant\applicants_list;
use App\Models\ASIS_Models\agency\agency_employees;
use App\Models\ASIS_Models\HRIS_model\employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hiring\tblpanels;

class admin_notification extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'admin_notification';

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'target_id', 'target_type', 'seen','notif_content','purpose','active','created_by',
        'subject', 'subject_id', 'sender_type','sender_id'
    ];

    public function getDocDetails()
    {
        return $this->hasOne(\App\Models\e_hris_models\document\doc_file::class, 'track_number', 'subject_id')->where('active', 1);
    }
    public function getGroupDetails()
    {
        return $this->hasOne(\App\Models\e_hris_models\document\doc_groups::class, 'id', 'subject_id')->where('active', 1);
    }
    public function getUserDetails()
    {
        return $this->hasOne(employee::class, 'agencyid', 'created_by')->where('active', 1);
    }

    public function get_target_details()
    {
        return $this->hasOne(employee::class, 'agencyid', 'target_id')->where('active', 1);
    }
    //ayaw hilabti ni
    public function getUser_Details()
    {
        return $this->hasMany(employee::class, 'agencyid','created_by')->where('active',true);
    }

    public function get_applicant_list()
    {
        return $this->hasOne(applicants::class, 'id', 'subject_id')->where('active', 1);
    }

    public function get_agency_employees()
    {
        return $this->hasOne(agency_employees::class, 'agency_id', 'sender_id');
    }

    function get_Panels()
    {
        return $this->hasMany(tblpanels::class,'available_ref','subject_id');
    }

    public function get_sender_details()
    {
        return $this->hasOne(employee::class, 'agencyid', 'sender_id');
    }

//ok
    public function get_agency()
    {
        return $this->hasOne(agency_employees::class, 'agency_id', 'sender_id');
    }
}
