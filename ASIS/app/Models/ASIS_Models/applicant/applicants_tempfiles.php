<?php

namespace App\Models\applicant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applicants_tempfiles extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'applicants_tempfiles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'folder',
        'filename',
    ];
}
