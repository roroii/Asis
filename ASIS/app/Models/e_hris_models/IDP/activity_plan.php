<?php

namespace App\Models\IDP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity_plan extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'idp_activity_plan';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'activity_id',
            'idp_id',
            'planned',
            'accom_mid_year',
            'accom_year_end',
            'active',
           
        ];
}
