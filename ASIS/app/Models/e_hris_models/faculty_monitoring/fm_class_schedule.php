<?php

namespace App\Models\faculty_monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fm_class_schedule extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'fm_class_schedule';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'agency_id', 'subject_name', 'subject_code', 'type', 'days', 'date_time', 'complete', 'status', 'active', 'created_by'
    ];
}
