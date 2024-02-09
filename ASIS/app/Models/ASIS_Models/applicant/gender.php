<?php

namespace App\Models\ASIS_Models\applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gender extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'applicants_gender';
    protected $primaryKey = 'id';

    protected $fillable = [
        'gender',
        'active',
    ];
}
