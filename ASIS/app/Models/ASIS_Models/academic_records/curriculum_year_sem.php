<?php

namespace App\Models\ASIS_Models\academic_records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curriculum_year_sem extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'curriculum_year_sem';
    protected $primaryKey = 'id';

    protected $fillable = [
        'curriculum_id', 'curriculum_year_id', 'name', 'active', 'created_by', 'created_at', 'updated_at'
    ];

    public function subjects()
    {
        return $this->hasMany(curriculum_year_sem_subject::class, 'curriculum_year_sem_id', 'id');
    }

    public function schoolYear()
    {
        return $this->belongsTo(curriculum_year::class, 'curriculum_year_id', 'id');
    }
}