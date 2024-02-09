<?php

namespace App\Models\Hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbljob_doc_rec extends Model
{
    use HasFactory;

    protected $connection ="e-hris";
    protected $table ="tbljob_doc_rec";
    protected $primaryKey ="id";
    protected $timestamp =true;

    protected $fillable = [
        'id','job_ref','remarks','active','created_at','updated_at'
    ];
}
