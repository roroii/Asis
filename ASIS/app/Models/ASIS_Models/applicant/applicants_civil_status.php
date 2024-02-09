<?php

namespace App\Models\e_hris_models\applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applicants_civil_status extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'applicants_civil_status';
    protected $primaryKey = 'id';

    protected $fillable = [
        'civil_status',
        'active',
    ];
}
