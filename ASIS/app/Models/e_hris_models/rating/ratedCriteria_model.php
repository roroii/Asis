<?php

namespace App\Models\rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\ratingtCriteria_model;

class ratedCriteria_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'tbl_rated_criteria';
    protected $primaryKey = 'id';

    protected $fillable = [
        'rated',
        'criteria_id',
        'applicant_id',
        'position_id',
        'applicant_job_ref',
        'short_listID',
        'rater_ag_id',
        'rated_by',
        'active',
    ];

    public function get_criteria()
    {
        return $this->hasMany(ratingtCriteria_model::class, 'id', 'criteria_id');
    }
    public function get_criteri()
    {
        return $this->hasOne(ratingtCriteria_model::class, 'id', 'criteria_id');
    }


}
