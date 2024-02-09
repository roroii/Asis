<?php

namespace App\Models\ASIS_Models\Clearance;

use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\ASIS_Models\HRIS_model\tblemployee;
use App\Models\e_hris_models\ref\ref_province;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_signatories extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'clearance_signatories';
    protected $primaryKey = 'id';

    protected $fillable = [

        'clearance_id',
        'signatory_id',
        'designation',
        'type',
        'active',
    ];

    public function get_Employee_Data()
    {
        return $this->hasOne(employee::class, 'agencyid', 'signatory_id');
    }

    public function get_Student_Data()
    {
        return $this->hasOne(enrollment_list::class, 'studid', 'signatory_id');
    }

    public function get_clearance_students()
    {
        return $this->hasMany(clearance_students::class, 'clearance_id', 'clearance_id');
    }

    public function isApproved()
    {
        return $this->hasOne(clearance_activities::class, 'signatory_id', 'signatory_id')->where('status', 11);
    }

    public function get_Clearance_Activities()
    {
        return $this->hasOne(clearance_activities::class, 'signatory_id', 'signatory_id')->where('status', 11);
    }
}
