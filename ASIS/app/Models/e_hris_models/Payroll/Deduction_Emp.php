<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction_Emp extends Model
{
    use HasFactory;
    protected $table = 'pr_deduction_emp';
    protected $guarded = [];
    protected $fillable = [
        'id', 'deduction_id', 'employee_id', 'active', 'created_at', 'updated_at'
    ];



    public function deduction_details(){
        return $this->hasOne(Deduction::class, 'id', 'deduction_id');
    }
}
