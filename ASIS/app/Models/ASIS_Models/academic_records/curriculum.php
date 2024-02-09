<?php

namespace App\Models\ASIS_Models\academic_records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curriculum extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'curriculum';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'description', 'college', 'major', 'degree', 'sy', 'status', 'active', 'created_by', 'created_at', 'updated_at'
    ];

    public function schoolYears()
    {
        return $this->hasMany(curriculum_year::class, 'curriculum_id', 'id');
    }
}