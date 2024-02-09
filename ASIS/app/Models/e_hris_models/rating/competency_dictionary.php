<?php

namespace App\Models\rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\competency_dictionary_skills;

class competency_dictionary extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'competency_dictionary';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'details',
        'active',
    ];
    public function get_dictionary_skill()
    {
        return $this->hasOne(competency_dictionary_skills::class, 'compid', 'id');
    }
}
