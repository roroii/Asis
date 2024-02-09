<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hiring\tbl_hiringavailable;
use App\Models\Hiring\tblpanels;
use App\Models\Hiring\tbl_positionType;



class tbl_position extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table = "tblposition";
    protected $primaryKey = "id";
    protected $timestamp = true;

    protected $fillable = [
        'id','emp_position','descriptions','created_at','updated_at'
    ];

    public function getPos()
    {
        return $this->hasMany(tbl_hiringavailable::class,'id','positionid');
    }
}
