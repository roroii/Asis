<?php

namespace App\Models\ASIS_Models\SemSched;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_program extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'program';
    protected $primaryKey = 'oid';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'oid','progcode','progdesc',
    ];
}
