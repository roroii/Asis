<?php

namespace App\Models\ASIS_Models\studentFees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class miscfee_perprogram extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'miscfeematrix_perprogram';
    protected $primaryKey ='oid';

    protected $keyType ='string';
    public $incrementing = false;

    protected $fillable = [
        'oid', 'progcode', 'yrlevel','feecode','enrol','amt'
    ];
}
