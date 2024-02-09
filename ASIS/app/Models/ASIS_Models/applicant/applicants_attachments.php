<?php

namespace App\Models\applicant;

use App\Models\Hiring\tbljob_info;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applicants_attachments extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'applicant_attachments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'applicant_id',
        'jobref_no',
        'attachment_type',
        'attachment_path',
        'attachment_name',
        'status',
        'active',
    ];

    public function get_applicant_list()
    {
        return $this->hasOne(applicants_list::class, 'jobref_no', 'jobref_no')->where('active', 1);
    }

    public function get_job_info()
    {
        return $this->hasOne(tbljob_info::class, 'jobref_no', 'jobref_no')->where('active', 1);
    }

}
