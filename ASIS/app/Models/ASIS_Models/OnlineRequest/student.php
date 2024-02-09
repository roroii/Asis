<?php

namespace App\Models\ASIS_Models\OnlineRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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



}
