<?php

namespace App\Models\competency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\competency_skills;

class competency_dictionary_skills extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'competency_dictionary_skills';
    protected $primaryKey = 'id';

    protected $fillable = [
        'compid',
        'skill',
        'points',
        'active',
    ];
    public function get_competency_skill()
    {
        return $this->hasMany(competency_skills::class, 'skillid', 'skill');
    }
}
