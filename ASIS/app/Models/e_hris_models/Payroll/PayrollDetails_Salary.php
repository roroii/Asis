<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetails_Salary extends Model
{
    use HasFactory;
    protected $table = 'pr_details_salary';
    protected $guarded = [];
    protected $fillable = [
        'payroll_id', 'employee_id', 'salary', 'created_at', 'updated_at','net_salary'
    ];
}
