<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetails_Incentive extends Model
{
    use HasFactory;
    protected $table = 'pr_details_incentive';
    protected $guarded = [];
    protected $fillable = [
        'incentive_id', 'employee_id', 'payroll_id', 'amount', 'created_at', 'updated_at'
    ];
}
