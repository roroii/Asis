<?php

namespace App\Models\e_hris_models\PDS;

use App\Models\e_hris_models\ref\ref_brgy;
use App\Models\e_hris_models\ref\ref_citymun;
use App\Models\e_hris_models\ref\ref_province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pds_address extends Model
{
    use HasFactory;
    protected $table = 'pds_address';
    protected $guarded = [];
    protected $fillable = [
        'employee_id',
        'address_type',
        'house_block_no',
        'street',
        'subdivision_village',
        'brgy',
        'city_mun',
        'province',
        'zip_code',
        'active',

    ];

    public function get_province()
    {
        return $this->hasOne(ref_province::class, 'provCode', 'province');
    }

    public function get_city_mun()
    {
        return $this->hasOne(ref_citymun::class, 'citymunCode', 'city_mun');
    }
    public function get_brgy()
    {
        return $this->hasOne(ref_brgy::class, 'brgyCode', 'brgy');
    }

}
