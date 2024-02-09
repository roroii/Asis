<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbleduc_req extends Model
{
    use HasFactory;

    protected $connection ="e-hris";
    protected $table ="tbleduc_req";
    protected $primaryKey ="id";
    protected $timestamp = true;

    protected $fillable = [
        'id','job_info_no','item_no','eligibility','educ','work_ex','competency','training','active','created_at','updated_at'
    ];

    public function get_competency()
    {
        return $this->hasOne(tbl_competency_skills::class,'skillid','competency')->where('active','1');
    }

}
