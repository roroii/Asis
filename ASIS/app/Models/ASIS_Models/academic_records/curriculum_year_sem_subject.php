<?php

namespace App\Models\ASIS_Models\academic_records;

use App\Models\ASIS_Models\posgres\portal\srgb\registration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curriculum_year_sem_subject extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'curriculum_year_sem_subject';
    protected $primaryKey = 'id';

    protected $fillable = [
        'curriculum_id', 'curriculum_year_id', 'curriculum_year_sem_id', 'subject_code', 'subject_description', 'subject_credits', 'subject_lec', 'subject_lab', 'subject_prereq', 'subject_remarks', 'active', 'created_by', 'created_at', 'updated_at'
    ];

    public function semester()
    {
        return $this->belongsTo(curriculum_year_sem::class, 'curriculum_year_sem_id', 'id');
    }

    public function registration_data()
    {
        return $this->hasMany(registration::class, 'subjcode', 'subject_code');
    }
}