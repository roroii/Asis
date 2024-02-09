<?php

namespace App\Models\e_hris_models\PDS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pds_special_skills extends Model
{
    use HasFactory;
    protected $table = 'pds_special_skills';
    protected $guarded = [];
    protected $fillable = [
        'employee_id',
        'special_skills',
        'distinctions',
        'org_membership',
        'active',

    ];
}
