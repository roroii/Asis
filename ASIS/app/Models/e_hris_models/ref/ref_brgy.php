<?php

namespace App\Models\e_hris_models\ref;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_brgy extends Model
{
    use HasFactory;
    protected $connection = "e-hris";
    protected $table = "ref_brgy";
    protected $primaryKey = "id";
    protected $timestamp = true;

    protected $fillable = [
        'brgyCode',
        'brgyDesc',
        'regCode',
        'provCode',
        'citymunCode',
    ];
}
