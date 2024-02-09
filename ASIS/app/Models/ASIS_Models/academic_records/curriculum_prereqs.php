<?php

namespace App\Models\ASIS_Models\academic_records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curriculum_prereqs extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'curriculum_prereqs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'curriculum_id', 'subject_id', 'prereq_code', 'active'
    ];

}