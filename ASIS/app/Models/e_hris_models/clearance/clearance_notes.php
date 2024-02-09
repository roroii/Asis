<?php

namespace App\Models\clearance;

use App\Models\Hiring\tbl_position;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_notes extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'clearance_notes';
    protected $primaryKey = 'id';

    protected $fillable = [

        'title',
        'desc',
        'note_type',
        'target_type',
        'target_id',
        'employee_id',
        'created_by',
        'dismiss',
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

    public function get_Target_Employee()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'employee_id')->where('active', 1);
    }

    public function get_Author()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'created_by')->where('active', 1);
    }

    public function Unit_Office_Department_III()
    {
        return $this->hasOne(clearance_csc_iii::class, 'clearing_officer', 'created_by')->where('active', 1);
    }
}
