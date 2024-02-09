<?php

namespace App\Models\ASIS_Models\Clearance;

use App\Models\ASIS_Models\system\status_codes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'clearance';
    protected $primaryKey = 'id';

    protected $fillable = [

        'name',
        'course',
        'type',
        'sem',
        'year',
        'created_by',
        'status',
        'active',

    ];

    public function getStatusCodes()
    {
        return $this->hasOne(status_codes::class, 'id', 'status')->where('active', 1);
    }

    public function getSignatories()
    {
        return $this->hasMany(clearance_signatories::class, 'clearance_id', 'id')->where('active', 1);
    }

    public function isRequested()
    {
        return $this->hasOne(clearance_students::class, 'clearance_id', 'id')->where('active', 1);
    }

    public function get_clearance_students()
    {
        return $this->hasOne(clearance_students::class, 'clearance_id', 'id')->where('active', 1);
    }

    public function get_clearance_activities()
    {
        return $this->hasOne(clearance_activities::class, 'clearance_id', 'id')->where('active', 1);
    }

    public function active_clearance()
    {
        return self::where('status', 13)->where('active', 1);
    }
}
