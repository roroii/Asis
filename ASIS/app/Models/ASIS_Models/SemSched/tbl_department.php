<?php

namespace App\Models\ASIS_Models\SemSched;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_department extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'department';
    protected $primaryKey = 'oid';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'oid','deptcode','deptname','deptcoll'
    ];
}
