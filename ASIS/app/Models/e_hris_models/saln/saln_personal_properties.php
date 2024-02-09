<?php

namespace App\Models\saln;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saln_personal_properties extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'saln_personal_properties';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'saln_id',
            'description',
            'year_acquired',
            'cost',
            'created_by',
            'active',
        ];
}
