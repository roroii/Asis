<?php

namespace App\Models\rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hiring\tbl_positionType;
use App\Models\Hiring\tbl_position;
use App\Models\rating\competency_dictionary;

class ratingtCriteria_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'tbl_applicant_ratingcriteria';
    protected $primaryKey = 'id';

    protected $fillable = [
        'creteria',
        'position_id',
        'competency_id',
        'maxrate',
        'active',
    ];

    public function get_areas(){
        return $this->hasMany(areas_model::class, 'criteria_id', 'id');
    }
    public function get_Position()
    {
        return $this->hasOne(tbl_position::class, 'id', 'position_id');
    }

    public function get_competency()
    {
        return $this->hasOne(competency_dictionary::class, 'id', 'competency_id');
    }

}
