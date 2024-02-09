<?php

namespace App\Models\ASIS_Models\pre_enrollees;

use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\ASIS_Models\system\status_codes;
use Auth;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class pre_enrollees extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, MustVerifyEmailTrait;

    protected $connection = 'portal';
    protected $table = 'pre_enrollees';
    protected $primaryKey = 'id';

    protected $fillable = [

        'pre_enrollee_id',
        'firstname',
        'midname',
        'lastname',
        'extension',
        'sem',
        'year',
        'email',
        'password',
        'email_verified',
        'email_verified_at',
        'account_status',
        'active'
    ];


    public function getStatusCodes()
    {
        return $this->hasOne(status_codes::class, 'id', 'account_status')->where('active', 1);
    }
    public function getAddress()
    {
        return $this->hasOne(enrollees_address::class, 'enrollees_id', 'enrollees_id')->where('type', 'PERMANENT')->where('active', 1);
    }
}
