<?php

namespace App\Models\ASIS_Models\pre_enrollees;

use App\Models\Admin;
use App\Models\ASIS_Models\enrollment\enrollment_schedule;
use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\ASIS_Models\system\status_codes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enrollees_appointment extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'enrollees_appointment';
    protected $primaryKey = 'id';

    protected $fillable = [

        'transaction_id',
        'enrollees_id',
        'schedule_id',
        'status',
        'action',
        'signatory',
        'active',
    ];

    public function getEnrolleesInfo()
    {
        return $this->hasOne(pre_enrollees::class, 'pre_enrollee_id', 'enrollees_id')->where('active', 1);
    }

    public function getEmployeeInfo()
    {
        return $this->hasOne(Admin::class, 'employee', 'signatory')->where('active', 1);
    }

    public function getScheduleData()
    {
        return $this->hasOne(enrollment_schedule::class, 'id', 'schedule_id')->where('active', 1);
    }

    public function getAddress()
    {
        return $this->hasOne(enrollees_address::class, 'enrollees_id', 'enrollees_id')->where('type', 'PERMANENT')->where('active', 1);
    }

    public function getStatusCodes()
    {
        return $this->hasOne(status_codes::class, 'id', 'status')->where('active', 1);
    }

    public function getSchedule()
    {
        return $this->hasOne(enrollment_schedule::class, 'id', 'schedule_id')->where('active', 1);
    }
}
