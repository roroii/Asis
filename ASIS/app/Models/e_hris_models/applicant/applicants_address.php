<?php

namespace App\Models\e_hris_models\applicant;

use App\Models\e_hris_models\ref\ref_citymun;
use App\Models\e_hris_models\ref\ref_country;
use App\Models\e_hris_models\ref\ref_province;
use App\Models\e_hris_models\ref\ref_region;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applicants_address extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'applicants_address';
    protected $primaryKey = 'id';

    protected $fillable = [
        'applicant_id',
        'brgy',
        'municipalitycity',
        'province',
        'region',
        'country',
        'active',
    ];

    public function get_country()
    {
        return $this->hasOne(ref_country::class,'id','country');
    }
    public function get_region()
    {
        return $this->hasOne(ref_region::class,'regCode','region');
    }
    public function get_province()
    {
        return $this->hasOne(ref_province::class,'provCode','province');
    }
    public function get_mun()
    {
        return $this->hasOne(ref_citymun::class,'citymunCode','municipalitycity');
    }
}
