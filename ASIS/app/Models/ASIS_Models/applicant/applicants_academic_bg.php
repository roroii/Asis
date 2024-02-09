<?php

namespace App\Models\applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applicants_academic_bg extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'applicants_academic_bg';
    protected $primaryKey = 'id';

    protected $fillable = [
        'applicant_id',
        'level',
        'school_name',
        'degree_course',
        'from',
        'to',
        'units_earned',
        'year_graduate',
        'honors_received',
        'active',
    ];
}
