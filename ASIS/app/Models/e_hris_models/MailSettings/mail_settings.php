<?php

namespace App\Models\MailSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mail_settings extends Model
{
    use HasFactory;


    protected $connection = 'e-hris';
    protected $table = 'settings_mail';
    protected $primaryKey = 'id';
    protected $timestamp = true;

    protected $fillable = [
        'id', 'driver', 'host', 'port', 'username', 'password', 'encryption', 'name', 'created_at', 'updated_at', 's'
    ];

}
