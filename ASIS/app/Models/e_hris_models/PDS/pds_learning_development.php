<?php

namespace App\Models\e_hris_models\PDS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pds_learning_development extends Model
{
    use HasFactory;
    protected $table = 'pds_learning_development';
    protected $guarded = [];
    protected $fillable = [
        'employee_id',
        'learning_dev_title',
        'from',
        'to',
        'hours_number',
        'learning_dev_type',
        'conducted_sponsored',
        'ld_others',
        'active',

    ];
}
