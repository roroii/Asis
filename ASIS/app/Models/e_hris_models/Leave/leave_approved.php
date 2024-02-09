<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave_approved extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table= 'leave_approved';
    protected $primaryKey='employeeid';

    protected $fillable= [
        'id',
        'leavesubmittedid',
        'employeeid',
        'no_of_leaves',
        'no_of_leaves',
        'active',
        'created_at',
        'updated_at',



    ];

//Leave Relationships

public function get_leave_type_val(){
        return $this->hasOne(leave_type::class,'id', 'leavesubmittedid');
        }


//End Leave Relationships

}
