<?php

namespace App\Models\ASIS_Models\Clearance;

use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\ASIS_Models\system\status_codes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_activities extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'clearance_activities';
    protected $primaryKey = 'id';

    protected $fillable = [

        'tracking_id',
        'clearance_id',
        'student_id',
        'signatory_id',
        'status',
        'remarks',
        'active',

    ];

    public function getStatusCodes()
    {
        return $this->hasOne(status_codes::class, 'id', 'status');
    }

    public function countSignedClearance($tracking_id, $clearance_id, $student_id)
    {
        return self::where('tracking_id', $tracking_id)->where('clearance_id', $clearance_id)->where('student_id', $student_id)->where('status', 11)->count();
    }
    public function get_Student_Data()
    {
        return $this->hasOne(User::class, 'studid', 'student_id');
    }

    public function get_StatusCode()
    {
        return $this->hasOne(status_codes::class, 'id', 'status');
    }

    public function get_enrollees_Data()
    {
        return $this->hasOne(enrollment_list::class, 'studid', 'student_id');
    }

    public function get_employeeSignatory_Data()
    {
        return $this->hasOne(employee::class, 'agencyid', 'signatory_id');
    }
    public function get_studentSignatory_Data()
    {
        return $this->hasOne(User::class, 'studid', 'signatory_id');
    }

    public function get_clearance_signatories()
    {
        return $this->hasOne(clearance_signatories::class, 'signatory_id', 'signatory_id')->where('active', 1);
    }

    public function has_active_clearance()
    {
        return $this->hasOne(clearance::class, 'id', 'clearance_id')->where('active', 1);
    }

}
