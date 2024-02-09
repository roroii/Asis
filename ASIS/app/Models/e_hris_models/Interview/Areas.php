<?php

namespace App\Models\Interview;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;
    protected $table = 'int_areas';
    protected $guarded = [];
    protected $fillable = [
        'criteria_id',
        'name',
        'point',
    ];
}
