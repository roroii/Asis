<?php

namespace App\Models\ASIS_Models\academic_records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curriculum_year extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'curriculum_year';
    protected $primaryKey = 'id';

    protected $fillable = [
        'curriculum_id', 'name', 'school_year', 'active', 'created_by', 'created_at', 'updated_at'
    ];

    public function semesters()
    {
        return $this->hasMany(curriculum_year_sem::class, 'curriculum_year_id', 'id');
    }

    public function curriculum()
    {
        return $this->belongsTo(curriculum::class, 'curriculum_id', 'id');
    }
}