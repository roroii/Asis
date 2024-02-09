<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'subject';
    protected $primaryKey = 'oid';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

}