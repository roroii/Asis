<?php

namespace App\Models\employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl\tblemployee;
use App\Models\Leave\employee_leave_available;
use App\Models\tbl\tblposition;
use App\Models\tbl\tbluserassignment;

class employee_hr_details extends Model
{
    use HasFactory;
    protected $connection = 'dsscd85_kyoshi';
    protected $table = 'employee_hr_details';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employeeid', 'position', 'designation', 'regular_status', 'rank', 'tranch'
        , 'salary', 'entrydate', 'active', 'username', 'agencycodeid',
    ];

    public function getPosition()
    {
        return $this->hasOne(tblposition::class, 'id', 'position');
    }

    public function getDesig()
    {
        return $this->hasOne(tbluserassignment::class, 'id', 'designation')->where('active', 1);
    }

    public function getUsername()
    {
        return $this->hasOne(User::class, 'employee', 'agencyid')->where('active', 1);
    }
    public function get_user_details()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'employeeid')->where('active', 1);
    }


    public function get_employee_leave_available(){
        return $this->hasone(employee_leave_available::class,'employeeid', 'employeeid')->where('active', 1);
        }


}
