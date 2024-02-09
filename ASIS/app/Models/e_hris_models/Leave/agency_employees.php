<?php

namespace App\Models\Leave;

use App\Models\dpcument\doc_status;
use App\Models\tbl\tblemployee;
use App\Models\tbl\tblposition;
use App\Models\tbl\tbluserassignment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agency_employees extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'agency_employees';
    protected $primaryKey = 'agency_id';

    protected $fillable =
        [
            'user_id',
            'profile_id',
            'agency_id',
            'designation_id',
            'position_id',
            'agencycode_id',
            'office_id',
            'employee_id',
            'employment_type',
            'start_date',
            'end_date',
            'status',
            'active',
            'created_by',
        ];


    public function get_user_profile()
    {
        return $this->hasOne(tblemployee::class, 'id', 'profile_id')->where('active', 1);
    }

    public function get_employment_status()
    {
        return $this->hasOne(doc_status::class, 'code', 'status')->where('active', 1);
    }

    public function get_employee_profile(){
        return $this->hasone(tblemployee::class, 'agencyid', 'agency_id');
    }

    public function get_position()
    {
        return $this->hasone(tblposition::class, 'id', 'position_id');
    }

    public function get_designation()
    {
        return $this->hasone(tbluserassignment::class, 'id', 'designation_id');
    }


    public function getPosition()
    {
        return $this->hasOne(tblposition::class,'id', 'position_id')->where('active', 1);
    }

    public function getDesig()
    {
        return $this->hasOne(tbluserassignment::class, 'id', 'designation_id')->where('active', 1);
    }

    public function getUsername()
    {
        return $this->hasOne(User::class, 'employee', 'agency_id')->where('active', 1);
    }
    public function get_user_details()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'agency_id')->where('active', 1);
    }

    public function get_leaverecommendation(){
        return $this->hasMany(tblleaverecommendation::class, 'employeeid', 'agency_id');
    }
}

