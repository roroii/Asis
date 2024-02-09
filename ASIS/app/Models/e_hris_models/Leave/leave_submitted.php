<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl\tblemployee;
use App\Models\employee_hr_details;
use App\Models\Leave\leave_type;
use App\Models\Leave\agency_employees;
use App\Models\tbl\tblposition;
use App\Models\tbl\tbluserassignment;

class leave_submitted extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table= 'leave_submitted';
    protected $primaryKey='id';

    protected $fillable= [
        'id',
        'type',
        'specify',
        'swhere',
        'appliedno',
        'from_date',
        'to_date',
        'commutation',
        'employeeid',
        'entrydate',
        'active',
        'leavetype',
        'cancel_status',
        'supervisor_id',


    ];

//Leave Relationships

public function get_employee_name(){
        return $this->hasone(tblemployee::class,'agencyid', 'employeeid')->where('active', 1);

    }

public function get_leave_type(){
    return $this->belongsTo(leave_type::class,'id', 'type')->where('active', 1);
}

public function get_supervisor_info(){
    return $this->hasone(tblemployee::class,'agencyid', 'supervisor_id')->where('active', 1);

}

//End Leave Relationships

}
