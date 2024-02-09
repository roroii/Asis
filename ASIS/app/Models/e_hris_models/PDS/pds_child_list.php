<?php

namespace App\Models\e_hris_models\PDS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pds_child_list extends Model
{
    use HasFactory;
    protected $table = 'pds_child_list';
    protected $guarded = [];
    protected $fillable = [
        'employee_id',
        'name',
        'birth_date',
        'active',

    ];
}
