<?php

namespace App\Models\rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\ratingtCriteria_model;

class areas_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'tbl_area_criteria';
    protected $primaryKey = 'id';

    protected $fillable = [
        'area',
        'rate',
        'criteria_id',
        'active',
    ];

    public function get_criteria()
    {
        return $this->hasOne(ratingtCriteria_model::class, 'id', 'criteria_id');
    }

}
