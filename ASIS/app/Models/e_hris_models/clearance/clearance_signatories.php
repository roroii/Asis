<?php

namespace App\Models\clearance;

use App\Models\doc_user_rc_g;
use App\Models\Leave\agency_employees;
use App\Models\status_codes;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_signatories extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'clearance_signatories';
    protected $primaryKey = 'id';

    protected $fillable = [

        'clearance_id',
        'clearance_request_id',
        'employee_id',
        'clearing_officer',
        'cleared',
        'note',
        'signature',
        'status',
        'active',

    ];

    public function Clearance_Active()
    {
        return $this->hasOne(clearance::class, 'id', 'clearance_id')->where('active', 1);
    }

    public function Employee_Details()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'employee_id');
    }
    public function Status_Codes()
    {
        return $this->hasOne(status_codes::class, 'id', 'status');
    }

    public function Unit_Office()
    {
        return $this->hasOne(clearance_csc_iii::class, 'clearance_id', 'clearance_id');
    }

    public function Clearing_Officer_Details()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'clearing_officer');
    }


    public function getProfile()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'clearing_officer')->where('active', 1);
    }

    public function Clearance_Data()
    {
        return $this->hasOne(clearance_csc_iii::class, 'clearance_id', 'clearance_id');
    }

    public function Responsibility_Center()
    {
        return $this->hasOne(doc_user_rc_g::class, 'user_id', 'employee_id')->where('type', 'rc');
    }

    public function get_Employeee_Profile()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'employee_id')->where('active', 1);
    }

    public function Agency_Employee()
    {
        return $this->hasOne(agency_employees::class, 'agency_id', 'employee_id');
    }

    public function Active_Clearance()
    {
        return $this->hasOne(clearance::class, 'id', 'clearance_id')->where('active', 1);
    }

}
