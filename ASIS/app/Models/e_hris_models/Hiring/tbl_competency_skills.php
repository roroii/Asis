<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_competency_skills extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table ="competency_skills";
    protected $primaryKey = "skillid";
    protected $fillable = ["skillid","skill","active"];

}
