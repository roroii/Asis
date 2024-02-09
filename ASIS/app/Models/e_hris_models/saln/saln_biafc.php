<?php

namespace App\Models\saln;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saln_biafc extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'saln_biafc';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'saln_id',
            'name_of_entity',
            'business_address',
            'nature_of_business_interest',
            'date_of_acquisistion',
            'active',
            'created_by',
        ];
}
