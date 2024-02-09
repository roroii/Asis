<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $table = 'pr_salary';
    protected $guarded = [];
    protected $fillable = [
        'id', 'agency_id', 'classification', 'sg', 'step', 'rate', 'salary','rate_id'
    ];
}
