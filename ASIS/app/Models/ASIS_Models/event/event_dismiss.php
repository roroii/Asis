<?php

namespace App\Models\ASIS_Models\event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event_dismiss extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'event_dismiss';
    protected $primaryKey = 'id';

    public $timestamp = true;

    protected $fillable = [
        "id", "user_id", "event_id", "status", "active", "created_at", "updated_at"
    ];
}
