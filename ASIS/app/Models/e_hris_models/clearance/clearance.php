<?php

namespace App\Models\e_hris_models\clearance;

use App\Models\tbl\tbl_responsibilitycenter;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class clearance extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'clearanceSignatories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'type',
        'name',
        'description',
        'active',
        'created_by',
        'updated_by',
    ];

    public function get_Clearance_Type()
    {
        return $this->hasOne(clearance_type::class, 'id', 'type')->where('active', 1);
    }

    public function get_RC()
    {
        return $this->hasOne(tbl_responsibilitycenter::class, 'responid', 'rc')->where('active', 1);
    }

    public function get_User_Details()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'created_by')->where('active', 1);
    }

    public function check_request()
    {
        return $this->hasOne(clearance_request::class, 'clearance_id', 'id')->where('active', 1)->where('employee_id', Auth::user()->employee);
    }
}
