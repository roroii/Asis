<?php

namespace App\Models\ASIS_Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvalQuestion extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'eval_question';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ques_name',
        'ques_title',
        'ques_sub',
        'ques_direction',
        'active'
    ];
}
