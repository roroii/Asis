<?php

namespace App\Models\ASIS_Models\Clearance;

use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\ASIS_Models\system\status_codes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_students extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'clearance_students';
    protected $primaryKey = 'id';

    protected $fillable = [

        'tracking_id',
        'clearance_id',
        'student_id',
        'status',
        'active',

    ];

    public function get_Signatories()
    {
        return $this->hasOne(clearance_signatories::class, 'clearance_id', 'clearance_id');
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

    public function get_clearance_activities()
    {
        return $this->hasOne(clearance_activities::class, 'tracking_id', 'tracking_id');
    }

    public function hasRequested($clearance_id, $student_id)
    {
        return self::where('clearance_id', $clearance_id)->where('student_id', $student_id)->first();
    }

    public function clearance_approved()
    {
        return $this->hasOne(clearance_activities::class, 'tracking_id', 'tracking_id')
                    ->where('status', 11);
    }

    public function clearance_returned()
    {
        return $this->hasOne(clearance_activities::class, 'tracking_id', 'tracking_id')
            ->where('status', 4);
    }


    public function hasClearanceActivity($employee_id)
    {
        $tracking_id = $this->tracking_id; // Adjust this based on your actual field names

        $exists = clearance_activities::where('signatory_id', $employee_id)
            ->where(function ($query) {
                $query->where('status', 1)
                    ->orWhere('status', 4);
            })
            ->exists();

        return $exists;
    }
}
