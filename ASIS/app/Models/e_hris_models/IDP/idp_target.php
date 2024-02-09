<?php

namespace App\Models\IDP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class idp_target extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'idp_target';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'dev_target',
            'pg_support',
            'objective',
            'idp_id',
            'active',
        ];

    // public function getUsers()
    // {
    //     return $this->hasOne(employee::class, 'agencyid', 'created_by')->where('active', 1);
    // }
}
