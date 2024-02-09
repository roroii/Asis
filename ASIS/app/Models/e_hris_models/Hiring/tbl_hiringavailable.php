<?php

namespace App\Models\Hiring;

use App\Models\Hiring\tbl_hiringlist;
use App\Models\Hiring\tbl_position;
use App\Models\Hiring\tbl_positionType;
use App\Models\Hiring\tblpanels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hiring\tbl_salarygrade;

class tbl_hiringavailable extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table = "tbl_hiringavailable";
    protected $primaryKey = "id";
    public $timestamp = true;

    protected $fillable = [
        'id','positionid','ref_num','descriptions','salarygrade', 'salaryrate','hiring_start','hiring_until','active','status','pos_type'
    ];
    public function get_position()
    {
        return $this->hasOne(tbl_position::class,'id','positionid');
    }
    //carlz
    public function getPosition()
    {
        return $this->hasMany(tbl_position::class,'id','positionid');
    }

    public function getSalary_rate()
    {
        return $this->hasMany(tbl_salarygrade::class,'id','salarygrade')->where('active','1');
    }

    public function getPosition_type()
    {
        return $this->hasMany(tbl_positionType::class,'id','pos_type')->where('active','1');
    }

    public function getPanels()
    {
        return $this->hasMany(tblpanels::class,'available_ref','ref_num')->where('panel_id', auth()->user()->id)->where('active','1');
    }
    public function get_Panels()
    {
        return $this->hasOne(tblpanels::class,'available_ref','ref_num')->where('panel_id', auth()->user()->id)->where('active','1');
    }


    //Montz Positions
    public function get_available_Position()
    {
        return $this->hasOne(tbl_position::class,'id','positionid');
    }
    public function get_sg()
    {
        return $this->hasOne(tbl_salarygrade::class,'id','salarygrade');
    }
    public function gethiring_list(){

        return $this->hasMany(tbl_hiringlist::class,'hiring_ref_num','ref_num');
    }

}
