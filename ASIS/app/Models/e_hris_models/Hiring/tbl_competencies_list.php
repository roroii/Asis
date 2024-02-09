<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_competencies_list extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'tbl_competencies_list';
    protected $primaryKey = 'id';
    protected $timestamp = true;

    protected $fillable = ['id', 'job_ref', 'comp_list', 'created_at', 'updated_at', 'active'];
}
