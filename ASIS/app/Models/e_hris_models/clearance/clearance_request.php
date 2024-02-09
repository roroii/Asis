<?php

namespace App\Models\e_hris_models\clearance;

use App\Models\doc_user_rc_g;
use App\Models\Leave\agency_employees;
use App\Models\status_codes;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_request extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'clearance_request';
    protected $primaryKey = 'id';

    protected $fillable = [

        'clearance_id',
        'employee_id',
        'request_note',
        'status',
        'response_note',
        'completed',
        'active',

    ];

    public function Clearance_Details()
    {
        return $this->hasOne(clearance::class, 'id', 'clearance_id');
    }

    public function Employee_Details()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'employee_id');
    }

    public function Status_Codes()
    {
        return $this->hasOne(status_codes::class, 'id', 'status');
    }

    public function Responsibility_Center()
    {
        return $this->hasOne(doc_user_rc_g::class, 'user_id', 'employee_id')->where('type', 'rc');
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
