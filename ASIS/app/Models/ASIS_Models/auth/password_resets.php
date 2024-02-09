<?php

namespace App\Models\ASIS_Models\auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class password_resets extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'password_resets';
    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'token',
        'ip_address',
        'mac_address',

    ];
}
