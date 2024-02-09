<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roletypes extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'roletypes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'details',
        'code',
        'active',
    ];

}
