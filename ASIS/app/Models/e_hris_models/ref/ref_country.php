<?php

namespace App\Models\e_hris_models\ref;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_country extends Model
{
    use HasFactory;
    protected $connection = "e-hris";
    protected $table = "ref_country";
    protected $primaryKey = "id";
    protected $timestamp = true;

    protected $fillable = [
        'iso',
        'name',
        'nicename',
        'iso3',
        'numcode',
        'phonecode',
    ];
}
