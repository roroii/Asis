<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use App\Models\ASIS_Models\posgres\enrollment\srgb\semstudent;
use App\Models\ASIS_Models\OnlineRequest\student_request;
use App\Models\ASIS_Models\posgres\portal\srgb\registration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class student extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'student';
    protected $primaryKey = 'oid';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
    [
        'studid', 'studlastname', 'studfirstname', 'studmidname', 'studsuffix',
        'studpermaddr', 'studzip', 'studbirthdate', 'studbirthplace', 'studgender',
        'studlegstatus', 'studcitizen', 'studreligion', 'studethnic', 'studfather',
        'studmother', 'studpaddr', 'studspouse', 'studspaddr', 'studfullname',
        'studfullname2', 'studcontactno', 'payment_sy', 'payment_sem', 'basis_of_admission',
        'date_of_admission', 'graduated_primary', 'graduated_primary_year',
        'graduated_intermediate', 'graduated_intermediate_year', 'graduated_highschool',
        'graduated_highschool_year', 'graduated_primary_addr', 'graduated_intermediate_addr',
        'graduated_highschool_addr', 'allow_sy', 'allow_sem', 'nstp_serial',
        'guardian_name', 'guardian_contactno', 'studlrn', 'password', 'seniorhigh',
        'seniorhighschooladdress', 'strand', 'transferee', 'transferedschoolfrom',
        'translastschoolyearattended', 'transyearlevel', 'seniorhighyeargraduated',
        'seniorhighgpa', 'verbalcomprehension', 'verbalreasoning', 'totalverbalscore',
        'verbalstanine', 'quantitativereasoning', 'figuralreasoning', 'totalnonverbalscore',
        'nonverbalstanine', 'totalrawscore', 'totalstanine', 'studemail',

    ];

    public function sem_student()
    {
        return $this->hasMany(semstudent::class, 'studid', 'studid')->latest('regdate');
    }

    public function load_registration()
    {
        return $this->hasMany(registration::class, 'studid', 'studid')->orderByDesc('oid');
    }

    public function check_sem_student()
    {
        return $this->hasOne(semstudent::class, 'studid', 'studid');
    }

    public function get_student_info()
    {
        return $this->hasOne(student_request::class, 'studid', 'studid');
    }



}
