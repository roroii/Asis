<?php

namespace App\Models\testing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testChoice_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'test_choices';
    protected $primaryKey = 'id';

    protected $fillable = [
        'test_choices',
        'active',
    ];
}
