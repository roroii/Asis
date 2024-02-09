<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution_Emp extends Model
{
    use HasFactory;
    protected $table = 'pr_contribution_emp';
    protected $guarded = [];
    protected $fillable = [
        'id', 'employee_id', 'contribution_id', 'amount', 'recurrence'
    ];


    public function get_contribution(){
        return $this->hasOne(Contribution::class, 'id', 'contribution_id');
    }
}
