<?php

namespace App\Models\others;

use App\Models\posgres_db\srgb\srgb_semsubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class linked_faculty_agency_user extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'linked_faculty_agency_user';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'esms_faculty_id', 'hris_agency_id', 'active', 'created_by', 'created_id', 'updated_at'
        ];

        public function get_semsubject()
        {
            return $this->hasMany(srgb_semsubject::class,'facultyid','esms_faculty_id');
        }
}
