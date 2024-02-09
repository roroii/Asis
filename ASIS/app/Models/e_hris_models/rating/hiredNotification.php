<?php

namespace App\Models\rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hiredNotification extends Model
{
    use HasFactory;
    protected $table = 'tbl_rated_hirednotification';
    protected $primaryKey = 'id';

    protected $fillable = [
        'subject',
        'notifaication',
        'active',
    ];
}
