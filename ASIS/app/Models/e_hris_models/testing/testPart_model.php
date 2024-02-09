<?php

namespace App\Models\testing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testPart_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'test_part';
    protected $primaryKey = 'id';

    protected $fillable = [
        'test_part',
        'description',
        'active',
    ];
}
