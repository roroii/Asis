<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;
    protected $table = 'pr_contribution';
    protected $guarded = [];
    protected $fillable = [
        'id', 'name', 'desc', 'active'
    ];
}
