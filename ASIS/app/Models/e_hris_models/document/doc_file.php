<?php

namespace App\Models\e_hris_models\document;

use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\employee\employee_address;
use App\Models\travel_order\to_travel_orders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_file extends Model
{
    use HasFactory;
    protected $connection = 'dsscd85_qrdts';
    protected $table = 'doc_file';
    protected $primaryKey = 'id';

    protected $fillable = [
        'doc_type',
        'doc_type_id',
        'track_number',
        'name',
        'desc',
        'note',
        'type',
        'level',
        'status',
        'active',
        'type_submitted',
        'send_to_all',
        'show_author',
        'created_by',
        'created_at',
        'updated_at',
        'trail_release',
        'holder_type',
        'holder_id',
        'holder_user_id',
        'display_type'
    ];

    public function getDocType()
    {
        return $this->hasOne(doc_type::class, 'id', 'type')->where('active', 1);
    }

    public function getDocLevel()
    {
        return $this->hasOne(doc_level::class, 'id', 'level')->where('active', 1);
    }

    public function getDocTypeSubmitted()
    {
        return $this->hasOne(doc_type_submitted::class, 'id', 'type_submitted')->where('active', 1);
    }

    public function getDocStatus()
    {
        return $this->hasOne(doc_status::class, 'id', 'status')->where('active', 1);
    }

    public function getAttachments()
    {
        return $this->hasMany(doc_file_attachment::class, 'doc_file_id', 'track_number')->where('active', 1);
    }

    public function countUsersToReceive()
    {
        return $this->hasMany(doc_track::class, 'track_number', 'track_number')->where('active', 1)->where('for_status', 3);
    }

    public function getAuthor()
    {
        return $this->hasOne(employee::class, 'agencyid', 'created_by')->where('active', 1);
    }
    public function getAddress()
    {
        return $this->hasOne(employee_address::class, 'employeeid', 'agencyid')->where('active', 1);
    }
    public function getHolder()
    {
        return $this->hasOne(employee::class, 'agencyid', 'holder_id')->where('active', 1);
    }
    public function getTrackdetails()
    {
        return $this->hasMany(doc_track::class, 'track_number', 'track_number')->where('active', 1);
    }

    public function get_track_creator()
    {
        return $this->hasMany(doc_track::class, 'track_number', 'track_number')->where('active', 1);
    }

    public function get_travel_orders()
    {
        return $this->hasMany(to_travel_orders::class, 'id', 'doc_type_id')->where('active', 1);
    }

    public function get_track_sent_to()
    {
        return $this->hasMany(doc_track::class, 'track_number', 'track_number')->where('for_status', 3)->where('active', 1);
    }
    public function get_track_received_by()
    {
        return $this->hasMany(doc_track::class, 'track_number', 'track_number')->where('for_status', 6)->where('active', 1);
    }
}
