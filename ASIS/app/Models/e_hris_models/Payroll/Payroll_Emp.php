<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll_Emp extends Model
{
    use HasFactory;
    protected $table = 'pr_payroll_emp';
    protected $guarded = [];
    protected $fillable = [
        'payroll_id',
        'user_id',
    ];
}
