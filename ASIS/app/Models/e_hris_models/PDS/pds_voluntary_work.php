<?php

namespace App\Models\e_hris_models\PDS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pds_voluntary_work extends Model
{
    use HasFactory;
    protected $table = 'pds_voluntary_work';
    protected $guarded = [];
    protected $fillable = [
        'employee_id',
        'org_name_address',
        'from',
        'to',
        'hours_number',
        'work_position_nature',
        'active',

    ];
}
