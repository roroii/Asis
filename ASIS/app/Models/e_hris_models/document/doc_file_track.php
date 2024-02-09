<?php

namespace App\Models\e_hris_models\document;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_file_track extends Model
{
    use HasFactory;
    protected $connection = 'dsscd85_qrdts';
    protected $table = 'doc_file_track';
    protected $primaryKey = 'id';

    protected $fillable = [
        'doc_file_id',
        'receive_date',
        'type',
        'type_id',
        'status',
        'user_id',
        'seen',
        'note',
        'ass_from',
        'ass_from_type',
        'send_via',
        'end_of_trail',
        'created_by',
        'active',
        'action_taken',
        'action',
        'track_number',
        'doc_file_trail_id'
    ];

    public function getDocDetails()
    {
        return $this->hasOne(doc_file::class, 'track_number', 'doc_file_id')->where('active', 1);
    }

    public function getDocStatus()
    {
        return $this->hasOne(doc_status::class, 'id', 'status')->where('active', 1);
    }
    public function getUser()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'user_id')->where('active', 1);
    }

}
