<?php

namespace App\Models\rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\areas_model;

class ratedArea_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'tbl_rated_area';
    protected $primaryKey = 'id';

    protected $fillable = [
        'applicant_id',
        'position_id',
        'criteria_id',
        'job_ref',
        'short_list_id',
        'areas_id',
        'rate',
        'rated_by',
        'active',

    ];
    public function get_area()
    {
        return $this->hasOne(areas_model::class, 'id', 'areas_id');
    }
}
