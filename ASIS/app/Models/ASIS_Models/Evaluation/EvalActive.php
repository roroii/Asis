<?php

namespace App\Models\ASIS_Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvalActive extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'eval_active';
    protected $primaryKey = 'id';

    protected $fillable = [
        'rating_scale',
        'questions',
        'date_from',
        'date_to',
        'active'
    ];
}
