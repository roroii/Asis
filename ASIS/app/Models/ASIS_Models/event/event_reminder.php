<?php

namespace App\Models\ASIS_Models\event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\event\event_group;

class event_reminder extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'event_reminder';
    protected $primaryKey = 'id';

    protected $timestamp = true;

    protected $fillable = [
        "id", "title", "event_desc","title_icon", "message_icon", "status","active" ,"created_at", "updated_at"
    ];

    /*get the program of the student*/
    public function getProgramCode()
    {
        return $this->hasMany(event_group::class,'event_id','id');
    }
}
