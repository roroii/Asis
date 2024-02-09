<?php

namespace App\Models\ASIS_Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingScale extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'rating_scale';
    protected $primaryKey = 'id';

    protected $fillable = [
        'scale_name',
        'numerical',
        'descriptive',
        'qualitative',
        'saved'
    ];
}
