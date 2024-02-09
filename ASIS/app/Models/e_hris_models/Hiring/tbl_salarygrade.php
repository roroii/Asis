<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_salarygrade extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table = "sg_salarygrade";
    protected $primaryKey = "id";
    protected $fillable = ['id', 'name'];
}

