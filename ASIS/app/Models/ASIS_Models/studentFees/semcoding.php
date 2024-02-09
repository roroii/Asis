<?php

namespace App\Models\ASIS_Models\studentFees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semcoding extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'semcoding';
    protected $primaryKey = 'oid';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
            'oid','semcode','semdesc'
    ];
}
