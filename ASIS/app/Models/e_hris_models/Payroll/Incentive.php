<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Incentive extends Model
{
    use HasFactory;
    protected $table = 'pr_incentive';
    protected $guarded = [];
    protected $fillable = [
        'name', 'desc', 'active', 'created_at', 'updated_at'
    ];
}
