<?php

namespace App\Models\e_hris_models\document;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_track extends Model
{
    use HasFactory;
    protected $connection = 'dsscd85_qrdts';
    protected $table = 'doc_track';
    protected $primaryKey = 'id';

    protected $fillable = [
        'track_number',
        'doc_trail_id',
        'type',
        'type_id',
        'target_user_id',
        'note',
        'for_status',
        'action',
        'active',
        'seen',
        'created_by',
        'target_type',
        'target_id',
        'last_activity',
        'has_qr_id',
        'from_to_user_id',
        'message_note',
    ];

    public function getDocDetails()
    {
        return $this->hasOne(doc_file::class, 'track_number', 'track_number')->where('active', 1);
    }

    public function getDocStatus()
    {
        return $this->hasOne(doc_status::class, 'id', 'for_status')->where('active', 1);
    }
    public function getUser()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'target_user_id')->where('active', 1);
    }

    public function get_created_by()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'created_by')->where('active', 1);
    }

    public function get_sender()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'type_id')->where('active', 1);
    }

    public function get_Author()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'type_id')->where('active', 1);
    }

    public function get_Trail()
    {
        return $this->hasOne(doc_trail::class, 'track_number', 'track_number')->where('active', 1);
    }

    public function get_target_user()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'target_user_id')->where('active', 1);
    }

    public function get_type_user()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'type_id')->where('active', 1);
    }

    public function getSender_Details()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'created_by')->where('active', 1);
    }

    public function getAttachments()
    {
        return $this->hasMany(doc_file_attachment::class, 'doc_file_id', 'track_number')->where('active', 1);
    }
}
