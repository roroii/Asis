<?php

namespace App\Models\EmployeeRating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_survey_indicators extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'tbl_survey_indicators';
    protected $primaryKey = 'id';

    public $timestamp = true;

    protected $fillable = [
        'id', 'ref_id', 'indicators', 'active', 'created_at', 'updated_at'
    ];
}
