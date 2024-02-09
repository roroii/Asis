<?php

namespace App\Models\rr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rewards extends Model
{
    use HasFactory;
    protected $table = 'rr_awards';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'type',
        'desc',
    ];
}
