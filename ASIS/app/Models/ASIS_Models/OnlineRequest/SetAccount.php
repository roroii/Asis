<?php

namespace App\Models\ASIS_Models\OnlineRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\OnlineRequest\office_services;

class Set_Account extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'student';
    protected $primaryKey = 'id';
    
    protected $fillable = [

        'id',
        'studid',
        'email',
        'password',
        'fullname',
        'role',
        'office',
        'profile_pic',
        'last_seen',
        'email_verified',
        'email_verified_at',
        'active',
        'status',
        'remember_token',
        'created_by',

        ];

}
