<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;
      protected $connection = 'spamast_digos_srgb';
    protected $table = 'department';
    protected $primaryKey = 'oid';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
    [
        'oid', 'deptcode', 'deptname', 'deptcoll', 'deptchairman'
    ];
}