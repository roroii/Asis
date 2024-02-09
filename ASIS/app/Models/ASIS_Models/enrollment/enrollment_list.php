<?php

namespace App\Models\ASIS_Models\enrollment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ASIS_Models\SemSched\tbl_program;

class enrollment_list extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'enrollment_list';
    protected $primaryKey = 'id';

    protected $fillable = [
        'studid',
        'fullname',
        'studmajor',
        'email',
        'sem',
        'year',
        'number',
        'section',
        'year_level',
        'address',
        'enrollment_listcol',
        'active',
        'status',
        'created_by',
    ];

    public function isAdmin()
    {
        return $this->hasOne(User::class, 'studid', 'studid')->where('role', 'Admin');
    }

    //get the student program description
    public function getStudentProgram()
    {
        return $this->hasOne(tbl_program::class,'progcode','studmajor');
    }

    public function getStudProgram()
    {
        return $this->hasOne(User::class,'studid','studid');
    }
}
