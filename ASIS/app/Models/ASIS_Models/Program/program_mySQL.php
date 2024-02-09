<?php

namespace App\Models\ASIS_Models\Program;

use App\Models\ASIS_Models\posgres\portal\srgb\department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program_mySQL extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'program';
    protected $primaryKey = 'id';

    protected $fillable = [

        'program_code',
        'program_desc',
        'program_dept',
        'slots',
        'year',
        'sem',
        'active',
    ];

    public function getDepartment()
    {
        return $this->hasOne(department::class, 'deptcode', 'program_dept');
    }
}
