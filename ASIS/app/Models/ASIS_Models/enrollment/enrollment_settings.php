<?php

namespace App\Models\ASIS_Models\enrollment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enrollment_settings extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'enrollment_settings';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'description', 'key_value', 'active', 'created_by'
    ];
}
