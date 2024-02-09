<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl\tblemployee;
class leave_president_approval extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table= 'leave_president_approval';
    protected $primaryKey='id';

    protected $fillable= [
        'id',
        'leavesubmittedid',
        'employeeid',
        'status',
        'due_to',
        'notedby',
        'entrydate',
        'active',
        'created_at',
        'updated_at',



    ];

    public function get_President_info(){
        return $this->hasOne(tblemployee::class,'agencyid', 'notedby')->where('active', 1);

    }

}
