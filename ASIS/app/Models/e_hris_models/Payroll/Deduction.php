<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;
    protected $table = 'pr_deduction';
    protected $guarded = [];
    protected $fillable = [
        'name', 'amount', 'active', 'created_at', 'updated_at'
    ];
}
