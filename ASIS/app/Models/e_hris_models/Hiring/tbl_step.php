<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_step extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table = "sg_step";
    protected $primarykey ="id";
    public $timestamp = true;

    protected $fillable=['id','sg_id','stepname','amount','stepnum'];

    public function get_salary_grade()
    {
        return $this->hasOne(tbl_salarygrade::class,'id','sg_id');
    }

}
