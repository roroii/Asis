<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semsubject extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'semsubject';
    protected $primaryKey = 'oid';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
    [
        'oid', 'sy', 'sem', 'subjcode', 'section', 'subjsecno', 'days', 'time', 'room', 'bldg', 'block', 'maxstud', 'facultyid',
        'forcoll', 'fordept', 'lock', 'facultyload', 'tuitionfee', 'lockgraduating', 'offertype', 'semsubject_id', 'editable', 'fused_lec_to'
    ];
}
