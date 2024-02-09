<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program_major extends Model
{
    use HasFactory;
    protected $connection = 'spamast_digos_srgb';
    protected $table = 'program_major';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
        [
            'id', 'progcode', 'major', 'active',
        ];
}
