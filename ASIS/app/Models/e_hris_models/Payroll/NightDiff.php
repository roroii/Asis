<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NightDiff extends Model
{
    use HasFactory;
    protected $table = 'pr_nightdiff';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'desc',
        'mode',
        'value'
    ];
}
