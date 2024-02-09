<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class leave_tardiness_deduction extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table= 'leave_tardiness_deduction';
    protected $primaryKey='id';

    protected $fillable= [
        'id',
        'employeeid',
        'leave_type_id',
        'deducted',
        'particulars',
        'month',
        'year',
        'no_of_min',
        'no_of_hours',
        'no_of_day',
        'no_of_tardiness',
        'entrydate',
        'active',
        'username',
     

    ];


}
