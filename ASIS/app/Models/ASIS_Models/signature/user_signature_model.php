<?php

namespace App\Models\ASIS_Models\signature;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_signature_model extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'user_signature';
    protected $primaryKey = 'id';

    protected $fillable = [
        'studid',
        'signature',
        'active',
    ];
}
