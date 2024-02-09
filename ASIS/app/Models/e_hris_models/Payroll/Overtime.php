<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;
    protected $table = 'pr_overtime';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'desc',
        'mode',
        'value'
    ];
}
