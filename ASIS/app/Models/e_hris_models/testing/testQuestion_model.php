<?php

namespace App\Models\testing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testQuestion_model extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'test_question';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Question',
        'ans_choice',
        'active',
    ];
}
