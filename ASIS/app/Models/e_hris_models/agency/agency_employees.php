<?php

namespace App\Models\e_hris_models\agency;


use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\e_hris_models\employment\employment_type;
use App\Models\e_hris_models\tbl\tbl_responsibilitycenter;
use App\Models\status_codes;
use App\Models\tbl\tblposition;
use App\Models\tbl\tbluserassignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class agency_employees extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'agency_employees';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'user_id',
            'profile_id',
            'employee_id',
            'agency_id',
            'designation_id',
            'position_id',
            'agencycode_id',
            'office_id',
            'employment_type',
            'start_date',
            'end_date',
            'salary_amount',
            'regular_status',
            'rank',
            'tranch',
            'status',
            'created_by',
            'active',
        ];

    public function get_user_profile()
    {
        return $this->hasOne(employee::class, 'agencyid', 'agency_id')->where('active', 1);
    }

    public function get_employment_status()
    {
        return $this->hasOne(status_codes::class, 'code', 'status')->where('active', 1);
    }

    public function get_position()
    {
        return $this->hasone(tblposition::class, 'id', 'position_id');
    }

    public function get_designation()
    {
        return $this->hasone(tbluserassignment::class, 'id', 'designation_id');
    }

    public function get_employment_type()
    {
        return $this->hasone(employment_type::class, 'id', 'employment_type');
    }


    public function getPosition()
    {
        return $this->hasOne(tblposition::class,'id', 'position_id');
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
        return $this->hasOne(employee::class, 'agencyid', 'agency_id')->where('active', 1);
    }

    public function get_RC()
    {
        return $this->hasOne(tbl_responsibilitycenter::class, 'responid', 'office_id')->where('active', 1);
    }


    public function get_salary()
    {
        return $this->hasone(Salary::class, 'agency_id', 'agency_id');
    }

    public function get_contribution(){
        return $this->hasMany(Contribution_Emp::class, 'employee_id', 'agency_id');
    }

    public function get_loan(){
        return $this->hasMany(LoanAssignment::class, 'employee_id', 'agency_id');
    }

    public function get_incentive(){
        return $this->hasMany(Incentive_Emp::class, 'employee_id', 'agency_id');
    }

    public function get_deduction(){
        return $this->hasMany(Deduction_Emp::class, 'employee_id', 'agency_id');
    }

    public function salary_grade(){
        return $this->hasOne(tbl_salarygrade::class, 'id', 'tranch_id');
    }

}

