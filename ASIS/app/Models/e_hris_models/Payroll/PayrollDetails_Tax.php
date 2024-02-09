<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetails_Tax extends Model
{
    use HasFactory;
    protected $table = 'pr_details_tax';
    protected $guarded = [];
    protected $fillable = [
        'payroll_id', 'employee_id', 'tax', 'created_at', 'updated_at'
    ];
}
