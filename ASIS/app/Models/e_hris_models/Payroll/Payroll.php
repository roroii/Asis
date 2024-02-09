<?php

namespace App\Models\Payroll;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $table = 'pr_payroll';
    protected $guarded = [];
    protected $fillable = [
        'group_name',
        'date_desc',
        'date_month',
        'date_year',
        'processed_by',
        'status',
        'date_from',
        'date_to',
        'date_dates'
    ];

    public function employee()
    {
        return $this->hasMany(PayrollDetails_Salary::class, 'payroll_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'profile_id')->where('active', 1);
    }


}


