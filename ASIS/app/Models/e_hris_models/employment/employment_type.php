<?php

namespace App\Models\e_hris_models\employment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employment_type extends Model
{
    protected $connection = 'e-hris';
    protected $table = 'employment_type';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'name', 'desc', 'active', 'created_at', 'updated_at'
    ];

}
