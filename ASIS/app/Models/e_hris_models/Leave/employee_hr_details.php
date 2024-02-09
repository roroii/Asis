<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl\tblposition;
use App\Models\tbl\tbluserassignment;
use App\Models\tbl\tblemployee;
use App\Models\Leave\leave_type;
use App\Models\leave\employee_leave_available;
use App\Models\agency\agency_employees;

class employee_hr_details extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table = 'employee_hr_details';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','employeeid', 'position', 'designation', 'regular_status', 'rank', 'tranch'
        , 'salary', 'entrydate', 'active', 'username', 'agencycodeid',
    ];


    public function get_employee_leave_available(){
        return $this->hasone(employee_leave_available::class,'employeeid', 'employeeid')->where('active', 1);

    }

    public function get_position()
    {
        return $this->hasone(tblposition::class, 'id', 'position');
    }

    public function get_designation()
    {
        return $this->hasone(tbluserassignment::class, 'id', 'designation');
    }

    public function get_employee(){

    return $this->hasone(tblemployee::class, 'agencyid', 'employeeid')->where('active', 1);

    }

    public function get_agency_employees()
    {
        return $this->hasone(agency_employees::class, 'agency_id', 'employeeid')->where('active', 1);
    }

    public function getPosition()
    {
        return $this->hasone(tblposition::class, 'id', 'position');
    }

    public function getDesig()
    {
        return $this->hasone(tbluserassignment::class, 'id', 'designation');
    }

    public function get_user_profile()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'employeeid')->where('active', 1);
    }
}
