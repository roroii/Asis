<?php

namespace App\Models\ASIS_Models\SemSched;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_semestral_sched extends Model
{
    use HasFactory;

     /**
     * The attributes that should be cast.
     *
     * @var array
     */

     protected $casts = [
        'id' => 'encrypted',
    ];

    protected $connection = 'portal';
    protected $table = 'tbl_semestral_sched';
    protected $primaryKey = 'id';
    protected $timestamp = true;

    protected $fillable = [
        'id', 'oid_dept', 'oid_program', 'sem', 'active', 'date_open', 'date_close', 'created_by', 'created_at', 'update_at'
    ];

}
