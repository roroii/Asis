<?php

namespace App\Models\posgres_db\pis;

use App\Models\posgres_db\srgb\srgb_semsubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pis_employee extends Model
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

    public function get_subjects()
    {
        return $this->hasMany(srgb_semsubject::class, 'facultyid', 'empid');
    }

}
