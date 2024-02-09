<?php

namespace App\Models\e_hris_models\ref;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_citymun extends Model
{
    use HasFactory;
    protected $connection = "e-hris";
    protected $table = "ref_citymun";
    protected $primaryKey = "id";
    protected $timestamp = true;

    protected $fillable = [
        'psgcCode',
        'citymunDesc',
        'regDesc',
        'provCode',
        'citymunCode',
    ];

    public function get_region()
    {
        return $this->hasMany(ref_region::class, 'regCode', 'regCode');
    }
    public function get_province()
    {
        return $this->hasMany(ref_province::class, 'provCode', 'provCode');
    }
    public function get_brgy()
    {
        return $this->hasMany(ref_brgy::class, 'citymunCode', 'citymunCode');
    }
}
