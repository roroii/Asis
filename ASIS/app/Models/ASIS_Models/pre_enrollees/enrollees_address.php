<?php

namespace App\Models\ASIS_Models\pre_enrollees;

use App\Models\e_hris_models\ref\ref_brgy;
use App\Models\e_hris_models\ref\ref_citymun;
use App\Models\e_hris_models\ref\ref_province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enrollees_address extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'enrollees_address';
    protected $primaryKey = 'id';

    protected $fillable = [

        'enrollees_id',
        'type',
        'region',
        'province',
        'city_mun',
        'barangay',
        'sub_village',
        'street',
        'house_lot_no',
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
        return $this->hasOne(ref_brgy::class, 'brgyCode', 'barangay');
    }

}
