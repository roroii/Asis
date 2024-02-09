<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incentive_Emp extends Model
{
    use HasFactory;
    protected $table = 'pr_incentive_emp';
    protected $guarded = [];
    protected $fillable = [
        'incentive_id', 'employee_id', 'amount', 'active', 'created_at', 'updated_at', 'recurrence'
    ];

    public function get_incentive(){
        return $this->hasOne(Incentive::class, 'id', 'incentive_id');
    }
}
