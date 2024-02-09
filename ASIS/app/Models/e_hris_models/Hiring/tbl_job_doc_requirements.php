<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_job_doc_requirements extends Model
{
    use HasFactory;
    protected $connection = "e-hris";
    protected $table = "tbl_job_doc_requirements";
    protected $primaryKey = "id";
    protected $fillable = [
        'job_info_no',
        'doc_requirements',
        'doc_type',
        'active',
    ];
}
