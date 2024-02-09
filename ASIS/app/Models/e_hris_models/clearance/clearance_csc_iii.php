<?php

namespace App\Models\e_hris_models\clearance;

use App\Models\agency\agency_employees;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class clearance_csc_iii extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'clearance_csc_iii';
    protected $primaryKey = 'id';

    protected $fillable = [

        'clearance_id',
        'type',
        'unit_office_dept_name',
        'cleared',
        'not_cleared',
        'clearing_officer',
        'signature',
        'active',
    ];

    public function getProfile()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'clearing_officer')->where('active', 1);
    }

    public function Signatories()
    {
        return $this->hasOne(clearance_signatories::class, 'clearing_officer', 'clearing_officer')->where('employee_id', Auth::user()->employee);
    }
}
