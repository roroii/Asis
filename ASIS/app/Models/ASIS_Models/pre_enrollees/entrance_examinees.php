<?php

namespace App\Models\ASIS_Models\pre_enrollees;

use App\Models\Admin;
use App\Models\ASIS_Models\enrollment\enrollment_schedule;
use App\Models\ASIS_Models\system\status_codes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entrance_examinees extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'entrance_examinees';
    protected $primaryKey = 'id';

    protected $fillable = [

        'appointment_id',
        'transaction_id',
        'enrollees_id',
        'schedule_id',
        'status',
        'action',
        'exam_result',
        'stanine',
        'year',
        'sem',
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

    public function getEnrollmentSchedule()
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
