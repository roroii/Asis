<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payroll\Loan;

class LoanAssignment extends Model
{
    use HasFactory;
    protected $table = 'pr_loan_emp';
    protected $guarded = [];
    protected $fillable = [
        'id', 'loan_id', 'employee_id', 'amount', 'active', 'recurrence', 'created_at', 'updated_at'
    ];

    public function get_loan(){
        return $this->hasOne(Loan::class, 'id', 'loan_id');
    }
}
