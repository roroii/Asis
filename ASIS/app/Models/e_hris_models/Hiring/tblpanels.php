<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tbl\tblemployee;
use App\Models\Hiring\tbl_position;
use App\Models\rating\ratedAppcants_model;
use App\Models\User;
use App\Models\Profile;

class tblpanels extends Model
{
    use HasFactory;

    protected $connection = "e-hris";
    protected $table = "tblpanels";
    protected $primaryKey = "id";
    protected $timestamp = true;

    protected $fillable = ['id','available_ref','panel_id','created_at','updated_at'];

public function get_available_position()
{
    return $this->hasOne(tbl_hiringavailable::class,'ref_num','available_ref')->where('active', 1);
}
public function get_hiring_list()
{
    return $this->hasMany(tbl_hiringlist::class,'hiring_ref_num','available_ref')->where('active', 1);
}
public function get_employee()
{
    return $this->hasOne(tblemployee::class,'agencyid','panel_id');
}
public function get_rated()
{
    return $this->hasOne(ratedAppcants_model::class,'applicant_job_ref','available_ref')->where('rated_by', 'panel_id');
}
//get the position in tbl position


}
