<?php

namespace App\Models\IDP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class idp_acrtivity extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'idp_acrtivity';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'idp_id',
            'dev_activity',
            'support_needed',
            'planned',
            'accom_mid_year',
            'accom_year_end',
            'active',

        ];

    // public function getUsers()
    // {
    //     return $this->hasOne(employee::class, 'agencyid', 'created_by')->where('active', 1);
    // }
}
