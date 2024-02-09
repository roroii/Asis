<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registration extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'registration';
    protected $primaryKey = 'oid';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
    [
        'oid', 'sy', 'sem', 'studid', 'subjcode', 'section', 'midterm', 'finalterm', 'grade',
        'gcompl', 'lock', 'registered', 'tuitionfee', 'labfee', 'grade_enc', 'compfee',
        'remarks', 'nstpfee', 'status', 'confirmed'
    ];
}
