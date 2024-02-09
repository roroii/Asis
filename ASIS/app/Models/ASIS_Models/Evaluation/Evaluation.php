<?php

namespace App\Models\ASIS_Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'eval_instructor';
    protected $primaryKey = 'id';

    protected $fillable = [
        'instructor_id',
        'stud_id',
        'sy',
        'sem',
        'remarks'
    ];

}
