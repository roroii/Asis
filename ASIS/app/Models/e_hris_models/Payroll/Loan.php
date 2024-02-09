<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $table = 'pr_loan';
    protected $guarded = [];
    protected $fillable = [
        'id', 'name', 'desc', 'active', 'created_at', 'updated_at'
    ];
}
