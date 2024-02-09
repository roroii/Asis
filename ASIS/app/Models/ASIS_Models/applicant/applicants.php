<?php

namespace App\Models\ASIS_Models\applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\ratedAppcants_model;
use App\Models\Hiring\tbl_hiringlist;

class applicants extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'applicants_info';
    protected $primaryKey = 'id';

    protected $fillable = [
        'applicant_id',
        'lastname',
        'firstname',
        'mi',
        'citizenship',
        'sex',
        'dateofbirth',
        'age',
        'phonenumber',
        'email',
        'username',
        'password',
        'active',
    ];
    public function get_applicant_address()
    {
        return $this->hasOne(tbl_hiringlist::class,'applicant_id','applicant_id')->where('active', true);
    }
    public function get_Hiring_List()
    {
        return $this->hasMany(tbl_hiringlist::class,'applicant_id','applicant_id')->where('active', true);
    }
    public function get_applicant_rated()
    {
        return $this->hasMany(ratedAppcants_model::class,'applicantID','applicant_id')->where('active', 1);
    }
}
