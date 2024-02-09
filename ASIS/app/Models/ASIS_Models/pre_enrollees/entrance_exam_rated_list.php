<?php

namespace App\Models\ASIS_Models\pre_enrollees;

use App\Models\ASIS_Models\enrollment\enrollment_schedule;
use App\Models\ASIS_Models\system\status_codes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entrance_exam_rated_list extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'entrance_exam_rated_list';
    protected $primaryKey = 'id';

    protected $fillable = [

        'examinees_id',
        'enrollees_id',
        'status',
        'active',

    ];

    public function getEnrolleesInfo()
    {
        return $this->hasOne(pre_enrollees::class, 'pre_enrollee_id', 'enrollees_id')->where('active', 1);
    }
    public function getExamineesData()
    {
        return $this->hasOne(entrance_examinees::class, 'id', 'examinees_id')->where('active', 1);
    }
    public function getStatusCodes()
    {
        return $this->hasOne(status_codes::class, 'id', 'status')->where('active', 1);
    }
}
