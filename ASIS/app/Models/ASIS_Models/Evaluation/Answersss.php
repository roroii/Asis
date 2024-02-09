<?php

namespace App\Models\ASIS_Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answersss extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'eval_answer';
    protected $primaryKey = 'id';

    protected $fillable = [
        'instruc_id',
        'question_id',
        'answer_id'
    ];
    
}
