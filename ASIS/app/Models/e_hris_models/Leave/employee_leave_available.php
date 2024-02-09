<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl\tblemployee;
use App\Models\employee_hr_details;
use App\Models\Leave\leave_type;
use App\Models\tbl\tblposition;
use App\Models\tbl\tbluserassignment;

class employee_leave_available extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table= 'employee_leave_available';
    protected $primaryKey='employeeid';

    protected $fillable= [
        'id',
        'employeeid',
        'leave_type_id',
        'year',
        'no_of_leaves',
        'active',
        'username',
        'particulars',
        'period_from',
        'period_to',
        'period_type',
        'balance_as_of',
        'rendered_no_of_days',


    ];

//Leave Relationships

public function get_leave_type(){
        return $this->hasOne(leave_type::class,'id', 'leave_type_id')->where('active', 1);
        }



//End Leave Relationships

}
