<?php

namespace App\Models\e_hris_models\ref;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_eligibility extends Model
{
    use HasFactory;
    protected $connection = "e-hris";
    protected $table = "ref_eligibility";
    protected $primaryKey = "id";
    protected $timestamp = true;

    protected $fillable = [
        'ref_eligibility',
        'desc',
        'active',
    ];
}
