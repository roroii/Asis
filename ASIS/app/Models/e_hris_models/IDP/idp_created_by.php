<?php

namespace App\Models\IDP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl\tblemployee;
use App\Models\tbl\tblposition;
use App\Models\Hiring\tbl_salarygrade;
use App\Models\agency\agency_employees;

class idp_created_by extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'idp_created_by';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'emp_id',
            'position_id',
            'sg_id',
            'year_n_position',
            'year_n_agency',
            'three_y_period',
            'division',
            'office',
            'develop_year',
            'superior_id',
            'active',
            'year_to',
            'year_from',
        ];

    public function get_employe_info()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'emp_id');
    }
    public function get_supervisor_info()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'superior_id');
    }
    public function get_position()
    {
        return $this->hasone(tblposition::class, 'id', 'position_id');
    }
    public function get_salaryGrade()
    {
        return $this->hasone(tbl_salarygrade::class, 'id', 'sg_id');
    }
}
