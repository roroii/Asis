<?php

namespace App\Models\others;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class link_classes extends Model
{
    protected $connection = 'e-hris';
    protected $table = 'link_classes';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        '_oid', 'link_meeting_id', 'started_at', 'ended_at', 'meeting_link', 'active', 'created_by', 'created_at', 'updated_at'
    ];


    public function meetingDetails()
    {
        return $this->hasOne(link_meeting::class,'id','link_meeting_id');
    }

    public function createdBy()
    {
        return $this->hasOne(tblemployee::class,'agencyid','created_by')->where('active',1);
    }
}
