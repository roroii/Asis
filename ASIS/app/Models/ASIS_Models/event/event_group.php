<?php

namespace App\Models\ASIS_Models\event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event_group extends Model
{
    use HasFactory;

    protected $connection = "portal";
    protected $table = "event_groups";
    protected $primaryKey = "id";

    public $timestamp = true;

    protected $fillable = [
        "id", "event_id", "program_code", "status", "active", "created_at", "updated_at"
    ];
}
