<?php

namespace App\Models\clearance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_type extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'clearance_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'type', 'description', 'active', 'created_by',
    ];
}
