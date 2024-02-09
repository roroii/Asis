<?php

namespace App\Models\saln;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saln_real_properties extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'saln_real_properties';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'saln_id',
            'description',
            'kind',
            'exact_location',
            'assessed_value',
            'market_value',
            'year',
            'mode',
            'cost',
            'active',
            'created_by',
        ];
}
