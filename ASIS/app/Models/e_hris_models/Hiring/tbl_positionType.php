<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_positionType extends Model
{
    use HasFactory;
    protected $connection = "e-hris";
    protected $table = "tbl_position_type";
    protected $primaryKey = "id";
    protected $fillable = [
        'positiontype',
        'desc',
        'active'
    ];
}
