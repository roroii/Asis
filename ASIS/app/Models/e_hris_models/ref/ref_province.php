<?php

namespace App\Models\e_hris_models\ref;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_province extends Model
{
    use HasFactory;
    protected $connection = "e-hris";
    protected $table = "ref_province";
    protected $primaryKey = "id";
    protected $timestamp = true;

    protected $fillable = [
        'psgcCode',
        'provDesc',
        'regCode',
        'provCode',
    ];

    public function get_region()
    {
        return $this->hasMany(ref_region::class, 'regCode', 'regCode');
    }
    public function get_city_mun()
    {
        return $this->hasMany(ref_citymun::class, 'provCode', 'provCode');
    }
    public function get_brgy()
    {
        return $this->hasMany(ref_brgy::class, 'provCode', 'provCode');
    }
}
