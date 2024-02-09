<?php

namespace App\Models\e_hris_models\posgres_db\srgb;

use App\Models\ASIS_Models\posgres\portal\srgb\subject;
use App\Models\others\link_meeting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class srgb_semsubject extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'semsubject';
    protected $primaryKey = 'oid';

    public $incrementing    =    false;
    public $timestamps        =    false;

    protected $fillable =
    [
        'sy',
        'sem',
        'subjcode',
        'section',
        'subjsecno',
        'days',
        'time',
        'room',
        'bldg',
        'block',
        'maxstud',
        'facultyid',
        'forcoll',
        'fordept',
        'lock',
        'facultyload',
        'tuitionfee',
        'lockgraduating',
        'offertype',
        'semsubject_id',
        'editable',
        'fused_lec_to'
    ];

    public function get_link()
    {
        return $this->hasOne(link_meeting::class, '_oid', 'oid');
    }

    public function subjectDesciption()
    {
        return $this->hasOne(subject::class, 'subjcode', 'subjcode');
    }

    // Define the relationship to the Subject model
    public function subject()
    {
        return $this->belongsTo(subject::class, 'subjcode', 'subjcode'); // Adjust the column names accordingly
    }
}