<?php

namespace App\Models\RR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'rr_events';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'desc',
        's_date',
        'e_date',
        'publish',
        'created_by'
    ];
}
