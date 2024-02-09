<?php

namespace App\Models\e_hris_models\clearance;

use App\Models\Hiring\tbl_position;
use App\Models\Hiring\tbl_salarygrade;
use App\Models\Hiring\tbl_step;
use App\Models\tbl\tbl_responsibilitycenter;
use App\Models\tbl\tblemployee;
use App\Models\tbl\tblstep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_csc_others extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'clearance_csc_others';
    protected $primaryKey = 'id';

    protected $fillable = [

        'clearance_id',
        'employee_id',
        'purpose',
        'purpose_others',
        'date_filing',
        'date_effective',
        'rc',
        'position',
        'sg',
        'step',
        'cleared',
        'immediate_supervisor',
        'case',
        'active',

    ];

    public function getProfile()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'clearing_officer')->where('active', 1);
    }

    public function get_Position()
    {
        return $this->hasOne(tbl_position::class, 'id', 'position')->where('active', 1);
    }

    public function get_SG()
    {
        return $this->hasOne(tbl_salarygrade::class, 'id', 'sg')->where('active', 1);
    }

    public function get_Step()
    {
        return $this->hasOne(tbl_step::class, 'id', 'step');
    }

    public function get_Immediate_Head()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'immediate_supervisor');
    }

    public function RC()
    {
        return $this->hasOne(tbl_responsibilitycenter::class, 'responid', 'rc');
    }
}

