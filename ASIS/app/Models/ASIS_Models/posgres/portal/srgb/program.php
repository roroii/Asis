<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use App\Models\ASIS_Models\posgres\enrollment\srgb\semstudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'program';
    protected $primaryKey = 'oid';
    protected $keyType = 'string';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
    [
        'oid', 'progcode', 'progdesc', 'progdept', 'active'
    ];


    public function programDepartment()
    {
        return $this->hasOne(department::class, 'deptcode', 'progdept');
    }

}
