<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidate_parties_model extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'vote_candidate_parties';
    protected $primaryKey = 'id';

    protected $fillable = [

        'parties',
        'desc',
        'active'

        ];

        // public function getElect_position(){
        //     return $this->hasOne(votePosition_model::class,'id','positionID');
        // }
}
