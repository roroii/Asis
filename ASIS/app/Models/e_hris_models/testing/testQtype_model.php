<?php

namespace App\Models\testing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testQtype_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'test_question_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'question_type',
        'description',
        'active',
    ];
}
