<?php

namespace App\Models\ASIS_Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvalTempQues extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'eval_temp_ques';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ques_name_id',
        'ques_type',
        'ques_ques'
    ];
}
