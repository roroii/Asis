<?php

namespace App\Models\ASIS_Models\posgres\enrollment\srgb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\OnlineRequest\student;
class semstudent extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'semstudent';
    protected $primaryKey = 'oid';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
    [
        'sy', 'sem', 'studid', 'regdate', 'studcuraddr', 'studguardian', 'studgaddr',
        'studfull', 'studscholar', 'studunits', 'studfte', 'studgrad', 'studlevel',
        'studmajor', 'status', 'registered', 'nightclass', 'scholarstatus', 'returnee',
        'graduating', 'graduated', 'payment_sy', 'payment_sem'

    ];


    public function get_StudentRequest()
    {
        return $this->hasMany(student::class, 'studid', 'studid');
    }

}
