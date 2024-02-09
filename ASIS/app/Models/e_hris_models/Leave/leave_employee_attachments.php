<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class leave_employee_attachments extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table= 'leave_employee_attachments';
    protected $primaryKey='id';

    protected $fillable= [
        'id',
        'leavesubmittedid',
        'employeeid',
        'attachment_type',
        'filename',
        'path',
        'active',
        'created_at',
        'updated_at',

    ];


  
}
