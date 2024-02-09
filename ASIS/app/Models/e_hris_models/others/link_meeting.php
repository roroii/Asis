<?php

namespace App\Models\others;

use App\Models\posgres_db\srgb\srgb_semsubject;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class link_meeting extends Model
{
    protected $connection = 'e-hris';
    protected $table = 'link_meeting';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        '_oid','link_class_id' ,'sy', 'sm', 'sc', 'sec', 'scd', 'blk', 'fid', 'fc', 'status','link_meeting', 'link_meeting_description', 'created_by', 'active',
        'title','time_start','time_end','days','end_after'
    ];

    public function createdBy()
    {
        return $this->hasOne(tblemployee::class,'agencyid','created_by')->where('active',1);
    }

}
