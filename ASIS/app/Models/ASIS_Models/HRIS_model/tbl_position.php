<?php

namespace App\Models\ASIS_Models\HRIS_model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\ratedDone_model;

class tbl_position extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'tblposition';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'emp_position',
        'level',
        'type',
        'status',
        'descriptions',
        'entrydate',
        'durationlimit',
        'maxyears',
        'role',
        'unitdeload',
        'maxload',
        'overload',
        'minload',
        'active',
        'created_by',
    ];

    public function positioningsdfn(){
        return $this->hasMany(ratedDone_model::class, 'position_id', 'id');
    }

}
