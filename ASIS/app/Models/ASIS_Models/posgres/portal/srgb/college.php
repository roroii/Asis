<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class college extends Model
{
    use HasFactory;
    
    protected $connection = 'spamast_digos_srgb';
    protected $table = 'college';
    protected $primaryKey = 'oid';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
    [
        'oid', 'collcode', 'collname', 'colldean', 'collasstdean'
    ];

}