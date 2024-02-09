<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leave\leave_submitted;
use App\Models\tbl\tblemployee;
class leave_recommendation extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table= 'leave_recommendation';
    protected $primaryKey='id';

    protected $fillable= [
        'id',
        'leavesubmittedid',
        'employeeid',
        'status',
        'dueto',
        'notedby',
        'notedate',
        'active',

    ];


    public function leave_submitted(){
        return $this->hasOne(leave_submitted::class,'id', 'leavesubmittedid');
        }

    public function get_supervisor_info(){

        return $this->hasOne(tblemployee::class,'agencyid', 'notedby')->where('active', 1);

    }
}
