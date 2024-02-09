<?php

namespace App\Models\e_hris_models\PDS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pds_other_information extends Model
{
    use HasFactory;
    protected $table = 'pds_other_information';
    protected $guarded = [];
    protected $fillable = [
        'employee_id',
        'other_info_34_a',
        'other_info_34_b',
        'other_info_34_b_details',

        'other_info_35_a',
        'other_info_35_a_details',

        'other_info_35_b',
        'other_info_35_b_details',
        'other_info_35_b_date_filed',
        'other_info_35_b_status',

        'other_info_36',
        'other_info_36_details',

        'other_info_37',
        'other_info_37_details',

        'other_info_38_a',
        'other_info_38_a_details',

        'other_info_38_b',
        'other_info_38_b_details',

        'other_info_39',
        'other_info_39_details',

        'other_info_40_a',
        'other_info_40_a_details',

        'other_info_40_b',
        'other_info_40_b_details',

        'other_info_40_c',
        'other_info_40_c_details',
        'active',

    ];
}
