<?php

namespace App\Models\ASIS_Models\posgres\portal\srgb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeeee extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_pis';
    protected $table = 'employee';
    protected $primaryKey = 'oid';

    protected $fillable =
    [
        'empid',
        'fullname',
        'birthdate',
        'payccno',
        'currentrank',
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'deptcode',
        'email'
    ];
}
