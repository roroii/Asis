<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetails_Deduction extends Model
{
    use HasFactory;
    protected $table = 'pr_details_deduction';
    protected $guarded = [];
    protected $fillable = [
        'deduction_id','payroll_id', 'employee_id', 'amount', 'created_at', 'updated_at'
    ];
}
