<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class supported_candidate_model extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'vote_suported_candidate';
    protected $primaryKey = 'id';

    protected $fillable = [

        'type_id',
        'position_id',
        'candidates',
        'supported_by',
        'active'

        ];

        // public function getElect_position(){
        //     return $this->hasOne(votePosition_model::class,'id','positionID');
        // }
        public function getCandidate(){
            return $this->hasOne(User::class,'studid','candidates');
        }

}
