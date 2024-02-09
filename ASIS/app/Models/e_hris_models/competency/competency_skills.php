<?php

namespace App\Models\competency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class competency_skills extends Model
{
    use HasFactory;
    protected $table = 'competency_skills';
    protected $primaryKey = 'skillid';

    protected $fillable = [
        'skill',
        'details',
        'default_points',
        'active',
    ];
    // public function get_competency_skill()
    // {
    //     return $this->hasOne(competency_skills::class, 'skillid', 'skill');
    // }
}
